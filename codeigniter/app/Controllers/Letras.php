<?php

namespace App\Controllers;

use App\Models\Letras_model;
use Exception;

class Letras extends BaseController
{

	//constructor
	public function __construct()
	{
	}


	public function index()
	{
		try {
			$reg = new Letras_model();
			 $data= [
				"lista"=> $reg->paginate(10),
				"pager"=> $reg->pager
			 ];

			if ($this->request->isAJAX())
				echo view("letras/grill", $data );
			else
				echo view("letras/index");
		} catch (\Exception $e) { //mostrar mensaje de error
			//mostrar mensaje de operacion exitosa
			die($e->getMessage());
		}
	}





	public function create()
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario
			$reg = new Letras_model();

			$datos = $this->request->getPost();
		 
			$db = \Config\Database::connect();
			$reg->insert($datos);
			return $this->response->setJSON(array("ok" =>  $db->insertID()));
			//return redirect()->to( "index");
		} else {
			echo view('letras/create');
		}
	}




	public function edit($id = NULL)
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario
			$reg = new Letras_model();
			$datos =  $this->request->getPost();
			 

			if ($reg->update($datos['IDNRO'], $datos))
			return $this->response->setJSON(array("ok" => $datos['IDNRO']  ));
			//	return redirect()->to("index");
			else
			return $this->response->setJSON(array("error" =>  "Error al actualizar" ));
			//	echo view('plantillas/error', ['titulo' => "ERROR", 'mensaje' => "NO SE PUDO ACTUALIZAR"]);
		} else {
			// Create a shared instance of the model 
			$reg = new Letras_model();
			$registro = $reg->find($id);
			echo view('letras/edit', ['dato' => $registro]);
		}
	}


	public function view($id)
	{
		$reg = new Letras_model();
		$registro = $reg->find($id);
		echo view("letras/view", array("dato" => $registro, "vista" => true));
	}



	public function delete($id)
	{
		$reg = new Letras_model();

		if ($reg->delete($id))
		return $this->response->setJSON(array("ok" => $id)); 
		else
		return $this->response->setJSON(array("error" =>  "ERROR AL BORRAR" )); 
	}
}
