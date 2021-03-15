<?php

namespace App\Controllers;

use App\Models\Cobro_model;
use App\Models\Cuotas_model;
use App\Models\Detalle_cobro_model;
use App\Models\Deudor_model;
use App\Models\Empresa_model;
use App\Models\Letras_model;
use App\Models\Operacion_model;
use App\Models\Prestamo_model;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Exception;

class Operacion extends BaseController
{

	//constructor
	public function __construct()
	{
	}


	// Vista de operaciones pendientes (sin vencimientos aun)
	public function pendientes()
	{
		//Operaciones pendientes
		$operaciones =  (new Operacion_model())
			->join("deudor", "deudor.IDNRO =  operacion.NRO_CLIENTE")
			->select("operacion.*, deudor.CEDULA, concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES")
			->where("operacion.ESTADO", "PENDIENTE");
		$data = [
			"lista" =>   $operaciones->paginate(10),
			"pager" => $operaciones->pager
		];

		if ($this->request->isAJAX())
			echo view("operacion/grill_pendientes",  $data);
		else
			echo view("operacion/index_pendientes",  $data);
	}



	//Vista de operaciones procesadas, con cuotas generadas
	public function procesadas()
	{
		$BUSCADO = "";
		if ($this->request->getMethod(TRUE) == "POST")
			$BUSCADO =  $this->request->getPost("BUSCADO");

		$operaciones =  (new Operacion_model())
			->join("deudor", "deudor.IDNRO =  operacion.NRO_CLIENTE")
			->select("operacion.*, deudor.CEDULA, concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES")
			->where(" (operacion.ESTADO='APROBADO')  AND 
			( deudor.CEDULA LIKE '%$BUSCADO%' OR CONCAT(operacion.LETRA,operacion.CORRELATIVO) LIKE '%$BUSCADO%'  OR  deudor.NOMBRES LIKE '%$BUSCADO%'  OR  deudor.APELLIDOS LIKE '%$BUSCADO%' )")
			->orderBy("created_at", "DESC");

		$data = [
			"lista" =>   $operaciones->paginate(10),
			"pager" => $operaciones->pager
		];

		if ($this->request->isAJAX())
			echo view("cobro/index/grill_procesados",  $data);
		else
			echo view("cobro/index/index_procesados",  $data);
	}


	public function crear()
	{
		echo view("operacion/index_crear_operacion");
	}

	public function create($IDCLIENTE = null)
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario
			$reg = new Operacion_model();
			$datos = $this->request->getPost();

			$db = \Config\Database::connect();
			$reg->insert($datos);
			return $this->response->setJSON(array("ok" => $db->insertID()));
			//return redirect()->to("index");
		} else {

			$CLIENTE =   (new Deudor_model())
				->select("deudor.*, format( MONTO_SOLICI, 0, 'de_DE') as MONTO_SOLICI")
				->where("IDNRO",  $IDCLIENTE)->first();
			echo view('operacion/create',  ['CLIENTE' =>  $CLIENTE]);
		}
	}





	public function generar_vencimiento($ID_OPERACION =  NULL)
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario

			$datos = $this->request->getPost();

			$db = \Config\Database::connect();

			$datos =  $this->request->getJSON(true);
			$cabecera = $datos['CABECERA'];
			$cabecera['ESTADO'] = 'APROBADO';
			$detalle =  $datos['DETALLE'];
			$db->transBegin();
			$db->transStart();

			if ((new Operacion_model())->find($cabecera['IDNRO'])->ESTADO != "PENDIENTE")
				return $this->response->setJSON(['err' => "ATENCIÓN: ESTA OPERACIÓN YA FUE APROBADA ANTERIORMENTE"]);

			$reg = new Operacion_model();
			$reg->update($cabecera['IDNRO'],  $cabecera);

			//Generar las cuotas 
			$DETALLE_ID = 1;

			for ($cuo = 0; $cuo <  sizeof($detalle); $cuo++) {
				$nueva_fila =  $detalle[$cuo];
				$nueva_fila['OPERACION'] = $cabecera['IDNRO'];
				$nueva_fila["SALDO_PENDIENTE"] =   $nueva_fila['MONTO'];
				$nva_cuota = new Cuotas_model();
				$nva_cuota->insert($nueva_fila);

				$DETALLE_ID++;
			}
			//ACTUALIZAR CORRELATIVO
			(new Letras_model())->where("LETRA", $cabecera['LETRA'])
				->set(['ULT_NUMERO' =>   $cabecera['CORRELATIVO']])
				->update();

			$db->transCommit();
			$db->transComplete();

			return $this->response->setJSON(array("ok" => $cabecera['IDNRO']));


			//return redirect()->to("index");
		} else {
			if (is_null($ID_OPERACION))
				echo view('vencimiento/index/index');
			else {


				if ((new Operacion_model())->find($ID_OPERACION)->ESTADO != "PENDIENTE")
					return  view("plantillas/error", ['titulo' => "<NO PERMITIDO>", "mensaje" => "ESTA OPERACIÓN YA FUE APROBADA ANTERIORMENTE"]);


				$operacion = (new Operacion_model())
					->join("deudor", "deudor.IDNRO =  operacion.NRO_CLIENTE")
					->select("operacion.* ,  FORMAT(operacion.CREDITO, 0, 'de_DE') AS CREDITO, FORMAT(operacion.TOTAL_INTERESES, 0, 'de_DE') AS TOTAL_INTERESES,
					format(TOTAL_INTERESES_IVA, 0 , 'de_DE') AS TOTAL_INTERESES_IVA,	format(PORCEN_INTERES, 8, 'de_DE') AS PORCEN_INTERES, 	format(PORCEN_IVA_INTERES, 0 , 'de_DE') AS PORCEN_IVA_INTERES,
					FORMAT(operacion.SEGURO_CANCEL, 0, 'de_DE') AS SEGURO_CANCEL, FORMAT(operacion.SEGURO_3ROS, 0, 'de_DE') AS SEGURO_3ROS,  FORMAT(operacion.GASTOS_ADM, 0, 'de_DE') AS GASTOS_ADM,
					FORMAT(operacion.CAPITAL_DESEMBOLSO, 0, 'de_DE') AS CAPITAL_DESEMBOLSO,FORMAT(operacion.TOTAL_PRESTAMO, 0, 'de_DE') AS TOTAL_PRESTAMO,
					FORMAT(operacion.CUOTA_IMPORTE, 0, 'de_DE') AS CUOTA_IMPORTE,
					 FORMAT(deudor.MONTO_SOLICI, 0, 'de_DE') AS MONTO_SOLICI, deudor.TIPO_CREDITO, deudor.CEDULA, concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES")

					->where("operacion.IDNRO", $ID_OPERACION)->first();

				echo view('vencimiento/generacion/create', ['OPERACION' =>  $operacion]);
			}
		}
	}



	public function edit($ID_OPERACION = null)
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario

			$datos = $this->request->getPost();

			$reg = (new Operacion_model())
				->update($datos['IDNRO'],   $datos);


			return $this->response->setJSON(array("ok" =>  $datos['IDNRO']));
			//return redirect()->to("index");
		} else {


			$operacion = (new Operacion_model())
				->join("deudor", "deudor.IDNRO =  operacion.NRO_CLIENTE")
				->select("operacion.*,  FORMAT(operacion.CREDITO, 0,'de_DE') AS CREDITO,
					 FORMAT(operacion.CUOTA_IMPORTE, 0,'de_DE') AS CUOTA_IMPORTE,
					 format( deudor.MONTO_SOLICI, 0,'de_DE') as MONTO_SOLICI ,
					 format( operacion.TOTAL_INTERESES, 0,'de_DE') as TOTAL_INTERESES ,
					 format( operacion.PORCEN_IVA_INTERES,0, 'de_DE') AS PORCEN_IVA_INTERES,
					 format( operacion.TOTAL_INTERESES_IVA, 0,'de_DE') as TOTAL_INTERESES_IVA,
					 format( operacion.SEGURO_3ROS,0, 'de_DE') AS SEGURO_3ROS,
					 format( operacion.SEGURO_CANCEL,0, 'de_DE') AS SEGURO_CANCEL,
					 format( operacion.GASTOS_ADM,0, 'de_DE') AS GASTOS_ADM,
					 format( operacion.CAPITAL_DESEMBOLSO,0, 'de_DE') AS CAPITAL_DESEMBOLSO,
					 format( operacion.TOTAL_PRESTAMO,0, 'de_DE') AS TOTAL_PRESTAMO,

					 deudor.TIPO_CREDITO, deudor.CEDULA, concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES")

				->where("operacion.IDNRO", $ID_OPERACION)->first();
			echo view('operacion/edit',  ['OPERACION' =>  $operacion]);
		}
	}


	public function view($id)
	{
		$reg = new Empresa_model();
		$registro = $reg->find($id);
		echo view("empresa/view", array("dato" => $registro, "vista" => true));
	}



	public function delete($id)
	{
		$reg = new Operacion_model();

		if ($reg->delete($id))
			return $this->response->setJSON(["ok" =>  $id]);
		else
			return $this->response->setJSON(['err' => "ERROR AL BORRAR"]);
	}





	public function  list($IDCLIENTE = NULL)
	{
		//LETRA CORRE FACTURA RAZONS DEUDAT CREDITO

		//RECOGER PARAMETROS
		$CLIENTE = is_null($IDCLIENTE) ? "" :  $IDCLIENTE;
		$ESTADO =  $this->request->getPost("ESTADO");
		$BUSCADO =   $this->request->getPost("BUSCADO");

		$operac = (new Operacion_model())->builder();

		//jOIN CLIENTE
		if ($CLIENTE != "") {
			$operac = $operac->join("deudor", "deudor.IDNRO = operacion.NRO_CLIENTE")
				->select("operacion.*, deudor.CEDULA,concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES")
				->where("NRO_CLIENTE", $IDCLIENTE)
				->where("ESTADO",  $ESTADO);
		} else {
			if ($BUSCADO != "") {
				$operac = $operac->join("deudor", "deudor.IDNRO = operacion.NRO_CLIENTE")
					->select("operacion.*, deudor.CEDULA,concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES")
					->where("ESTADO",  $ESTADO)
					->like('deudor.CEDULA', $BUSCADO)
					->orLike('deudor.NOMBRES', $BUSCADO)
					->orLike('deudor.APELLIDOS', $BUSCADO)
					->orLike('concat(operacion.LETRA, concat("-", operacion.CORRELATIVO))', $BUSCADO);
			} else {
				$operac = $operac->join("deudor", "deudor.IDNRO = operacion.NRO_CLIENTE")
					->select("operacion.*, deudor.CEDULA,concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES")
					->where("ESTADO",  $ESTADO);
			}
		}



		//Formato de respuest
		$cabecera_formato = $this->request->getHeader("formato");
		$formato = is_null($cabecera_formato) ? "" :  $cabecera_formato->getValue();

		if ($formato == "json") {
			return $this->response->setJSON($operac->get()->getResult());
		}


		//Formato HTML
		$data = [
			'OPERACION' => $operac->paginate(10),
			'pager' => $operac->pager
		];
		if ($CLIENTE == "") {
			if ($this->request->isAJAX())
				return view("vencimiento/index/grill",  $data);
			else
				return view("vencimiento/index/index",  $data);
		} else
			return view("operacion/operaciones_cliente",  array_merge($data,  ['CLIENTE' =>   $CLIENTE]));
	}





	public function ver_vencimientos($ID_OPERACION =  NULL)
	{
		$cuotas = (new Cuotas_model())->where("OPERACION", $ID_OPERACION);
		$data = [
			"cuotas" =>   $cuotas->paginate(10),
			"pager" => $cuotas->pager,
			"OPERACION" => (new Operacion_model())->find($ID_OPERACION)
		];

		if ($this->request->isAJAX())
			return view("vencimiento/cuotas/grill",    $data);
		else
			return view("vencimiento/cuotas/index",    $data);
	}




	public function  cuotas($ID_OPERACION = null)
	{
		/***Cuotas */
		$cuotas = (new Cuotas_model())
			->select("operacion_cuotas.*, FORMAT( operacion_cuotas.MONTO, 0,  'de_DE') as MONTO,  
			DATE_FORMAT( VENCIMIENTO, '%d/%m/%Y') AS VENCIMIENTO, 
IF( DATEDIFF(VENCIMIENTO,  CURRENT_DATE)<0, ABS(DATEDIFF(VENCIMIENTO,  CURRENT_DATE)), 0) AS ATRASO,
if( FECHA_PAGO IS NULL, '',  FECHA_PAGO) AS FECHA_PAGO
")
			->where("OPERACION",  $ID_OPERACION)->get()->getResult();
		return $this->response->setJSON($cuotas);
	}

	public function cobrar($ID_OPERACION =  NULL)
	{

		if ($this->request->getMethod() === 'post') {
			$dataJSON = $this->request->getJSON(TRUE);
			$data = $dataJSON['CABECERA'];

			if ((new Operacion_model())->find($data['IDOPERACION'])->ESTADO != "APROBADO")
				return  $this->response->setJSON(["err" => "ESTA OPERACIÓN  AÚN NO FUE APROBADA "]);


			//Actualizar estado de prestamo a Aprobado
			//Generar las cuotas
			$db = \Config\Database::connect();

			//COD de recibo
			$id_recibo = NULL;
			$cobr = new Cobro_model();
			try {
				$db->transStart();
				//1	Header de cobro
				$cobr->insert($data);
				//2	Detalle de cuota cobradas

				$IDCOBRO = $db->insertID(); // Ultimo ID generado
				//Obtener de la BD las cuotas asociadas a la operacion, y filtrar segun cuantas se cobraron
				$nroCuotasPagadas = $data['CUOTAS_PAGADAS'];

				$dataCuotas =  (new Cuotas_model())
					->select("operacion_cuotas.*,  
				IF( DATEDIFF(VENCIMIENTO,  CURRENT_DATE)<0, ABS(DATEDIFF(VENCIMIENTO,  CURRENT_DATE)), 0) AS ATRASO")
					->where("OPERACION", $data['IDOPERACION'])
					->where("ESTADO", "P")->orderBy("NUMERO", "ASC")
					->limit($nroCuotasPagadas)->get()->getResult();

				//Iterar las cuotas y grabarlas en cobro
				//Total pagado en cuotas, distribuir esto en monto pagado por cuota
				$totalEnCuotasPagadas =  round($data['IMPORTE_PAGADO']);
				/************* */
				//$moraPorCadaAtraso = intval($data['MORA_UNITARIA']);
				foreach ($dataCuotas  as  $detail) :
					//	IDCOBRO 	IDCUOTA 	IMPORTE 	IDOPERACION 
					$montoPagado = 0;
					$nuevoSaldo = 0;
					//calculo de monto pagado
					if ($detail->MONTO  > $totalEnCuotasPagadas) $montoPagado = $totalEnCuotasPagadas; //Pago parcial
					else {
						$montoPagado = $detail->MONTO;
						$totalEnCuotasPagadas -=  $montoPagado;
					} //pago total
					//calcular nuevo saldo
					//cuota - (saldo_ant + pago actual)
					$saldo_pendiente =   $detail->SALDO_PENDIENTE;
					$nuevoSaldo =   ($saldo_pendiente - $montoPagado);

					//Pago por mora, y otros pesares
					//	$pagadoPorMora =  $detail->ATRASO  *  $moraPorCadaAtraso;

					//Grabar en detalle de cobro
					$cob_det = new Detalle_cobro_model();
					$data_det =  [
						'IDCUOTA' =>  $detail->IDNRO,
						'IDOPERACION' =>  $detail->OPERACION,
						'IMPORTE' =>  $montoPagado,
						'IDCOBRO' =>  $IDCOBRO,
						//	'IMPORTE_MOROSO' =>  $pagadoPorMora
					];
					$cob_det->insert($data_det);

					//3	Actualizar estado de cuotas, dependiendo del estado del Saldo, 
					$nuevoEstado = $detail->MONTO > $montoPagado ? "P"  : "C";
					(new Cuotas_model())
						->where("OPERACION", $detail->OPERACION)
						->where("IDNRO", $detail->IDNRO)
						->set(
							[
								"ESTADO" => $nuevoEstado,
								"FECHA_PAGO" => date("Y-m-d"),
								"SALDO_PENDIENTE" => $nuevoSaldo,
								"ATRASO" =>  $detail->ATRASO,
							]
						)->update();
				endforeach;
				//4 Actualizar estado de Operacion(prestamo)  si se pagó la totalidad de las cuotas
				$yaPagadas =  (new Cuotas_model())
					->where("OPERACION", $data['IDOPERACION'])
					->where("ESTADO", "C")->countAllResults();
				$nroTotalDeCuotas = ((new Operacion_model())->find($data['IDOPERACION']))->NRO_CUOTAS;
				if ($yaPagadas ==  $nroTotalDeCuotas) ((new Operacion_model())->where("IDNRO",  $data['IDOPERACION']))
					->set(['ESTADO' => 'LIQUIDADO'])->update();

				$db->transComplete();
			} catch (Exception $ex) {
				return $this->response->setJSON(['err' => $ex->getMessage()]);
			} catch (DatabaseException $ex) {
				return $this->response->setJSON(['err' => $ex->getMessage()]);
			}

			if ($db->transStatus()) {
				return $this->response->setJSON(['ok' => "Cobro registrado"]);
			} else
				return $this->response->setJSON(['err' => "Hubo un error en la transacción. Reintente"]);
		}

		//GET REQUEST
		if (is_null($ID_OPERACION)) return view("cobro/index/index_procesados");

		if ((new Operacion_model())->find($ID_OPERACION)->ESTADO != "APROBADO")
			return  view("plantillas/error", ['titulo' => "<NO PERMITIDO>", "mensaje" => "ESTA OPERACIÓN  AÚN NO FUE APROBADA "]);


		// formulario de cobro contextualizado a una operacion
		$prestamo = (new Operacion_model())
			->select("deudor.CEDULA, concat(deudor.NOMBRES, CONCAT('',deudor.APELLIDOS) ) AS NOMBRES,operacion.* ")
			->join("deudor",  "deudor.IDNRO = operacion.NRO_CLIENTE")
			->where("operacion.IDNRO",  $ID_OPERACION)
			->first();

		helper("form");
		echo view(
			"cobro/proceso/index",
			["prestamo_dato" => $prestamo]
		);
	}
}
