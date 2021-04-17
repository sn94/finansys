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
			echo view("operacion/index/pendientes/grill",  $data);
		else
			echo view("operacion/index/pendientes/index",  $data);
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
			"pager" => $operaciones->pager,
			'ACCION_GRILL' => ['COBRAR']
		];

		if ($this->request->isAJAX())
			echo view("operacion/index/aprobados/grill/index",  $data); //boton cobrar  boton ver cuotas
		else
			echo view("operacion/index/aprobados/index",  $data);
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

			if( is_null( $IDCLIENTE))
			return view("operacion/create/buscador_clientes");

			$CLIENTE =   (new Deudor_model())
				->select("deudor.*, format( MONTO_SOLICI, 0, 'de_DE') as MONTO_SOLICI")
				->where("IDNRO",  $IDCLIENTE)->first();

			return view('operacion/create/form',  ['CLIENTE' =>  $CLIENTE]);
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
				echo view('operacion/index/aprobados/index', ['ACCION_GRILL' => ['VER_CUOTA']]);
			else {


				if ((new Operacion_model())->find($ID_OPERACION)->ESTADO != "PENDIENTE")
					return  view("plantillas/error", ['titulo' => "<NO PERMITIDO>", "mensaje" => "ESTA OPERACIÓN YA FUE APROBADA ANTERIORMENTE"]);
				$operacion = (new Operacion_model())
					->join("deudor", "deudor.IDNRO =  operacion.NRO_CLIENTE")
					->select("operacion.* ,  FORMAT(operacion.CREDITO, 0, 'de_DE') AS CREDITO, FORMAT(operacion.TOTAL_INTERESES, 0, 'de_DE') AS TOTAL_INTERESES,
					format(TOTAL_INTERESES_IVA, 0 , 'de_DE') AS TOTAL_INTERESES_IVA,	format(INTERES_PORCE, 8, 'de_DE') AS INTERES_PORCE, 	format(INTERES_IVA_PORCE, 0 , 'de_DE') AS INTERES_IVA_PORCE,
					FORMAT(operacion.SEGURO_CANCEL, 0, 'de_DE') AS SEGURO_CANCEL, FORMAT(operacion.SEGURO_3ROS, 0, 'de_DE') AS SEGURO_3ROS,  FORMAT(operacion.GASTOS_ADM, 0, 'de_DE') AS GASTOS_ADM,
					FORMAT(operacion.CAPITAL_DESEMBOLSO, 0, 'de_DE') AS CAPITAL_DESEMBOLSO,FORMAT(operacion.TOTAL_PRESTAMO, 0, 'de_DE') AS TOTAL_PRESTAMO,
					FORMAT(operacion.CUOTA_IMPORTE, 0, 'de_DE') AS CUOTA_IMPORTE,
					 FORMAT( if(deudor.MONTO_SOLICI is null, 0, deudor.MONTO_SOLICI), 0, 'de_DE') AS MONTO_SOLICI, deudor.TIPO_CREDITO, deudor.CEDULA, concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES")

					->where("operacion.IDNRO", $ID_OPERACION)
					->orderBy("operacion.IDNRO", "DESC")
					->first();

				echo view('aprobacion/create', ['OPERACION' =>  $operacion]);
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

			//verificar estado
			$operaModel =  (new Operacion_model())->find($ID_OPERACION);
			if ($operaModel->ESTADO  ==  "PENDIENTE");

			$operacion = (new Operacion_model())
				->join("deudor", "deudor.IDNRO =  operacion.NRO_CLIENTE")
				->select("operacion.*,  FORMAT(operacion.CREDITO, 0,'de_DE') AS CREDITO,
					 FORMAT(operacion.CUOTA_IMPORTE, 0,'de_DE') AS CUOTA_IMPORTE,
					 format( deudor.MONTO_SOLICI, 0,'de_DE') as MONTO_SOLICI ,
					 format( operacion.TOTAL_INTERESES, 0,'de_DE') as TOTAL_INTERESES ,
					 format( operacion.INTERES_IVA_PORCE,0, 'de_DE') AS INTERES_IVA_PORCE,
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
		//verificar estado
		$operaModel =  (new Operacion_model())->find($id);
		if ($operaModel->ESTADO  ==  "PENDIENTE") {
			if ($reg->delete($id))
				return $this->response->setJSON(["ok" =>  $id]);
			else
				return $this->response->setJSON(['err' => "ERROR AL BORRAR"]);
		}
		return $this->response->setJSON(['err' => "NO PERMITIDO. SOLO ES POSIBLE BORRAR OPERACIONES PENDIENTES"]);
	}




	public function  list($IDCLIENTE = NULL)
	{

		$data_ = $this->request->getJSON(true);


		//acciones
		$acciones =  $data_['ACCIONES'];

		//RECOGER PARAMETROS
		$CLIENTE = is_null($IDCLIENTE) ? "" :  $IDCLIENTE;
		$ESTADO =  $data_["ESTADO"];
		$BUSCADO =   $data_["BUSCADO"];

		$operac = (new Operacion_model())->builder();

		//jOIN CLIENTE
		if ($CLIENTE != "") {
			$operac = $operac->join("deudor", "deudor.IDNRO = operacion.NRO_CLIENTE")
				->select("operacion.*, deudor.CEDULA,concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES")
				->where("NRO_CLIENTE", $IDCLIENTE)
				->where("ESTADO",  $ESTADO)
				->orderBy("operacion.IDNRO", "DESC");
		} else {
			if ($BUSCADO != "") {
				$operac = $operac->join("deudor", "deudor.IDNRO = operacion.NRO_CLIENTE")
					->select("operacion.*, deudor.CEDULA,concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES")
					->where("ESTADO",  $ESTADO)
					->like('deudor.CEDULA', $BUSCADO)
					->orLike('deudor.NOMBRES', $BUSCADO)
					->orLike('deudor.APELLIDOS', $BUSCADO)
					->orLike('concat(operacion.LETRA, concat("-", operacion.CORRELATIVO))', $BUSCADO)
					->orderBy("operacion.IDNRO", "DESC");
			} else {
				$operac = $operac->join("deudor", "deudor.IDNRO = operacion.NRO_CLIENTE")
					->select("operacion.*, deudor.CEDULA,concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES")
					->where("ESTADO",  $ESTADO)
					->orderBy("operacion.IDNRO", "DESC");
			}
		}



		//Formato de respuest 
		if ($this->getRequestContentType() ==  "json") {
			return $this->response->setJSON($operac->get()->getResult());
		}


		//Formato HTML
		$data = [
			'OPERACION' => $operac->paginate(10),
			'pager' => $operac->pager,
			'ACCION_GRILL' => $acciones
		];
		if ($CLIENTE == "") {
			if ($this->request->isAJAX())
				return view("operacion/index/aprobados/grill/index",  $data);
			else
				return view("operacion/index/aprobados/index",  $data);
		} else
			return view("deudor/operaciones",  array_merge($data,  ['CLIENTE' =>   $CLIENTE]));
	}





	public function cuotas($ID_OPERACION =  NULL)
	{
		$cuotas = (new Cuotas_model())->where("OPERACION", $ID_OPERACION)
			->select("operacion_cuotas.*,
			(SELECT  FORMAT( SUM(operacion_cuotas.MONTO),0, 'de_DE' ) FROM operacion_cuotas where OPERACION=$ID_OPERACION) as TOTAL_MONTO_CUOTA,
			  FORMAT( operacion_cuotas.MONTO, 0,  'de_DE') as MONTO,  
		DATE_FORMAT( VENCIMIENTO, '%d/%m/%Y') AS VENCIMIENTO, 
IF( DATEDIFF(VENCIMIENTO,  CURRENT_DATE)<0, ABS(DATEDIFF(VENCIMIENTO,  CURRENT_DATE)), 0) AS ATRASO,
if( FECHA_PAGO IS NULL, '', DATE_FORMAT( FECHA_PAGO,  '%d/%m/%Y' )   ) AS FECHA_PAGO
");

		if ($this->getRequestContentType() ==  "json")
			return $this->response->setJSON($cuotas->get()->getResult());

		if ($this->getRequestContentType() ==  "html") {

			$data = [
				"cuotas" =>   $cuotas->paginate(25),
				"pager" => $cuotas->pager,
				"OPERACION" => (new Operacion_model())->find($ID_OPERACION)
			];
			if ($this->request->isAJAX())
				return view("operacion/index/aprobados/cuotas/grill",    $data);
			else
				return view("operacion/index/aprobados/cuotas/index",    $data);
		}
	}




	public function generar_codigo_operacion($letra)
	{
		$nuevo_codigo = (new Operacion_model())->where("LETRA",  $letra)
			->select(" if( LETRA is NULL, '$letra', LETRA) AS LETRA, IF(CORRELATIVO IS NULL, 1 , max(CORRELATIVO)+1) AS CORRELATIVO  ")
			->first();
		return $this->response->setJSON($nuevo_codigo);
	}
}
