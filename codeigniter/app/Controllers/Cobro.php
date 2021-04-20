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

class Cobro  extends BaseController
{

	//constructor
	public function __construct()
	{
	}



	public function index()
	{
		$data_ = $this->request->getJSON(true);

		//RECOGER PARAMETROS 
		$BUSCADO =  isset( $data_["BUSCADO"]) ?   $data_["BUSCADO"] : "";
		$FECHA=  isset( $data_["FECHA"]) ?   $data_["FECHA"] :   date("Y-m-d");
		$operac = (new Cobro_model())->builder();
 
			$operac = $operac->join("deudor", "deudor.IDNRO = cobro.DEUDOR")
			->join("operacion", " cobro.IDOPERACION = operacion.IDNRO")
				->select("cobro.*, date_format( cobro.FECHA, '%d/%m/%Y') as FECHA,date_format( cobro.FECHA, '%H:%i') as HORA, deudor.CEDULA,concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES, 
				concat(operacion.LETRA, concat('-', operacion.CORRELATIVO)) AS COD_OPE, format(operacion.CREDITO, 0, 'de_DE') AS CREDITO,
				 format(cobro.TOTAL_ABSOLUTO, 0, 'de_DE') as TOTAL_COBRO, operacion.NRO_CUOTAS,
				 (select count(IDCUOTA) from detalle_cobro  where IDCOBRO=cobro.IDNRO  ) AS CUOTAS_PAGADAS,
				 (SELECT FORMAT(SUM(TOTAL_ABSOLUTO),0,'de_DE') from cobro where FECHA='$FECHA' ) as TOTAL_COBRADO
				 ");
				 //filtro fecha
				 if( $FECHA !=  "")
				 $operac= $operac->where("cobro.FECHA", $FECHA);

				 $operac= $operac->groupStart()
				->like('deudor.CEDULA', $BUSCADO)
				->orLike('deudor.NOMBRES', $BUSCADO)
				->orLike('deudor.APELLIDOS', $BUSCADO)
				->orLike('concat(operacion.LETRA, concat("-", operacion.CORRELATIVO))', $BUSCADO)
				->groupEnd()
				->orderBy("cobro.FECHA", "DESC");
		 
		//Formato de respuest 
		if ($this->getRequestContentType() ==  "json") {
			return $this->response->setJSON($operac->get()->getResult());
		}

		//Formato HTML
		$data = [
			'COBRO' => $operac->paginate(10),
			'pager' => $operac->pager
		];

		if ($this->request->isAJAX())
			return view("cobro/index/grill/index",  $data);
		else
			return view("cobro/index/index",  $data);
	}






	public function create($ID_OPERACION =  NULL)
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
					//(P)endiente  (C)obrado
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
		/*
		$requestService= \Config\Services::request();
$request=  $requestService->uri;
echo $request->getPath();

//Mostrar boton de cobro, dependiendo de la url de origen en el request
$mostrarBotonDeCobro = false;
if( preg_match( "",  $request->getPath()  ) )  $mostrarBotonDeCobro= true;

	*/
		if (is_null($ID_OPERACION)) return view("operacion/index/aprobados/index", ['COBRANZA'=>"SI"]);

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
