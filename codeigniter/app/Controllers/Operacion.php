<?php

namespace App\Controllers;

use App\Models\Deudor_model;
use App\Models\Empresa_model;
use App\Models\Operacion_model;
use App\Models\Prestamo_model;
use Exception;

class Operacion extends BaseController
{

	//constructor
	public function __construct()
	{
	}


	public function index()
	{
		echo view("operacion/index");
	/*	try {
			$lista = (new Operacion_model())
				->join("deudor", "deudor.IDNRO=operacion.NRO_CLIENTE")
				->select("operacion.*,  concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES");

			$data = [
				'lista' => $lista->paginate(10),
				'pager' => $lista->pager,
			];
			echo view("operacion/index", 	$data);
		} catch (\Exception $e) { //mostrar mensaje de error
			//mostrar mensaje de operacion exitosa
			die($e->getMessage());
		}*/
	}





	
	public function create(  $IDCLIENTE= null)
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario
			$reg = new Operacion_model();
			$datos = $this->request->getPost();
			
			$db = \Config\Database::connect();
			$reg->insert($datos);
			return $this->response->setJSON(array("ok" => $db->insertID()   ));
			//return redirect()->to("index");
		} else {

			$CLIENTE=   (new Deudor_model())
			->join("prestamo","prestamo.DEUDOR = deudor.IDNRO")
			->select("deudor.*,  prestamo.TIPO_CREDITO")
			->where("deudor.IDNRO",   $IDCLIENTE )
			->first( );
		 
			echo view('operacion/create',  ['CLIENTE'=>  $CLIENTE] );
		}
	}




	public function edit($id = NULL)
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario
			$reg = new Empresa_model();
			$datos =  $this->request->getPost();
			if ($reg->update($datos['IDNRO'], $datos))
				return redirect()->to("index");
			else
				echo view('plantillas/error', ['titulo' => "ERROR", 'mensaje' => "NO SE PUDO ACTUALIZAR"]);
		} else {
			// Create a shared instance of the model 
			$reg = new Empresa_model();
			$registro = $reg->find($id);
			echo view('empresa/edit', ['dato' => $registro]);
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
		$reg = new Empresa_model();

		if ($reg->delete($id))
			echo json_encode(['id' => $id]);
		else
			echo json_encode(['error' => "ERROR AL BORRAR"]);
	}





	public function  list($IDCLIENTE){
		//LETRA CORRE FACTURA RAZONS DEUDAT CREDITO

		$operac= (new Operacion_model()) 
		->where( "NRO_CLIENTE", $IDCLIENTE);

		$cliente= (new Deudor_model())->find(  $IDCLIENTE);
		

		$data = [
			'OPERACION' => $operac->paginate(10),
			'pager' => $operac->pager,
			'CLIENTE'=>  $cliente
		];

 
		return view("operacion/operaciones_cliente",  $data ); 
	}

	 
}
