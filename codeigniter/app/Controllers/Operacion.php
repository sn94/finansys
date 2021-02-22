<?php

namespace App\Controllers;

use App\Models\Cuotas_model;
use App\Models\Deudor_model;
use App\Models\Empresa_model;
use App\Models\Letras_model;
use App\Models\Operacion_model;
use App\Models\Prestamo_model;
use Exception;

class Operacion extends BaseController
{

	//constructor
	public function __construct()
	{
	}


	public function pendientes()
	{
		//Operaciones pendientes
		$operaciones =  (new Operacion_model())
			->join("deudor", "deudor.IDNRO =  operacion.NRO_CLIENTE")
			->select("operacion.*, deudor.CEDULA, concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES")
			->where("operacion.ESTADO", "APROBADO");
		$data = [
			"lista" =>   $operaciones->paginate(10),
			"pager" => $operaciones->pager
		];

		if(  $this->request->isAJAX())
		echo view("operacion/grill_pendientes",  $data);
		else
		echo view("operacion/index_pendientes",  $data);
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
			->where(  "IDNRO",  $IDCLIENTE)->first();
			echo view('operacion/create',  ['CLIENTE' =>  $CLIENTE]);
		}
	}

 

	public function generar_vencimiento($ID_OPERACION =  NULL)
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario

			$datos = $this->request->getPost();


			$db = \Config\Database::connect();

			$db->transBegin();
			$db->transStart();
			$reg = new Operacion_model();
			$reg->update($datos['IDNRO'],  $datos);

			//Generar las cuotas 
			$DETALLE_ID = 1;
			$DETALLE_MONTO =  $datos['DETALLE_MONTO'];
			$DETALLE_VENCIMIENTO =  $datos['DETALLE_VENCIMIENTO'];
			for ($cuo = 0; $cuo <  sizeof($DETALLE_MONTO); $cuo++) {
				$nva_cuota = new Cuotas_model();
				$nva_cuota->insert([
					'OPERACION' => $datos['IDNRO'],
					'NUMERO' => $DETALLE_ID,
					'MONTO' => $DETALLE_MONTO[$cuo],
					'VENCIMIENTO' => $DETALLE_VENCIMIENTO[$cuo],
					'ESTADO' => "P"
				]);
				$DETALLE_ID++;
			}
			//ACTUALIZAR CORRELATIVO
			(new Letras_model())->where("LETRA", $datos['LETRA'])
			->set( ['ULT_NUMERO'=>   $datos['CORRELATIVO']])
			->update();

			$db->transCommit();
			$db->transComplete();

			return $this->response->setJSON(array("ok" => $datos['IDNRO']));


			//return redirect()->to("index");
		} else {
			if (is_null($ID_OPERACION))
				echo view('vencimiento/index');
			else {
				$operacion = (new Operacion_model())
					->join("deudor", "deudor.IDNRO =  operacion.NRO_CLIENTE")
					->select("operacion.*, deudor.CEDULA, concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES")

					->where("operacion.IDNRO", $ID_OPERACION)->first();

				echo view('vencimiento/create', ['OPERACION' =>  $operacion]);
			}
		}
	}


	
	public function edit($ID_OPERACION = null)
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario
			
			$datos = $this->request->getPost();
 
			$reg =( new Operacion_model())
			->update(  $datos['IDNRO'],   $datos    );

			return $this->response->setJSON(array("ok" =>  $datos['IDNRO'] ));
			//return redirect()->to("index");
		} else {

			$operacion = (new Operacion_model())
					->join("deudor", "deudor.IDNRO =  operacion.NRO_CLIENTE")
					->select("operacion.*,  FORMAT(operacion.CREDITO, 0,'de_DE') AS CREDITO,
					 FORMAT(operacion.CUOTA_IMPORTE, 0,'de_DE') AS CUOTA_IMPORTE,
					 format( deudor.MONTO_SOLICI, 0,'de_DE') as MONTO_SOLICI ,
					 format( operacion.INTERES, 4,'de_DE') as INTERES ,
					 format( operacion.INTERES_FINAL, 4,'de_DE') as INTERES_FINAL , 
					 format( operacion.INTERES_CUOTA,0, 'de_DE') AS INTERES_CUOTA,
					 format( operacion.SEGURO,0, 'de_DE') AS SEGURO,
					 format( operacion.GASTOS_ADM,0, 'de_DE') AS GASTOS_ADM,
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
					->orLike('concat(operacion.LETRA, concat("-", operacion.CORRELATIVO))', $BUSCADO)
					;
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
				return view("vencimiento/grill",  $data);
			else
				return view("vencimiento/index",  $data);
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
		return view("vencimiento/cuotas/index",    $data);
	}
}
