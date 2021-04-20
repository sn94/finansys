<?php

namespace App\Controllers;

use App\Models\Empresa_model;
use App\Models\Prestamo_model;
use Exception;

class Empresa extends BaseController
{

	//constructor
	public function __construct()
	{
	}


	public function index()
	{
		try {
			$reg = new Empresa_model();
			$lista = $reg->findAll();

			if( $this->request->isAJAX())
			return view(
				"empresa/grill",
				array("lista" => $lista)
			);
			else 
		return view(
				"empresa/index",
				array("lista" => $lista)
			);
		} catch (\Exception $e) { //mostrar mensaje de error
			//mostrar mensaje de operacion exitosa
			die($e->getMessage());
		}
	}





	public function create()
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario
			$reg = new Empresa_model();
			$datos = $this->request->getPost();
			$reg->insert($datos);
			return redirect()->to("index");
		} else {
			echo view('empresa/create');
		}
	}




	public function edit($id = NULL)
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario
			$reg = new Empresa_model();
			$datos =  $this->request->getPost();
			if ($reg->update($datos['IDNRO'], $datos))
				return $this->response->setJSON(["ok" => "Guardado"]);
			else
				return $this->response->setJSON(["error" =>   "NO SE PUDO ACTUALIZAR"]);
		} else {
			// Create a shared instance of the model 
			$reg = new Empresa_model();
			$registro = $reg->find($id);
			echo view('empresa/create', ['dato' => $registro]);
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




	public function  gen_numero_operacion($id = NULL)
	{
		$reg = new Empresa_model();
		$registro = $reg->find($id);
		$letras =  $registro->LETRAS;
		//buscar en tabla creditos prestamos
		$creds = (new Prestamo_model())
			->where("EMPRESA", $id)
			->get()->getResult();
		return  $letras . (sizeof($creds)   + 1);
	}
}
