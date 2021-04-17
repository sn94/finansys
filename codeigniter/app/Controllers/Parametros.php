<?php

namespace App\Controllers;

use App\Models\Parametros_model;
use Exception;

class Parametros extends BaseController
{

	//constructor
	public function __construct()
	{
	}





	public function index()
	{

		$params = (new Parametros_model())->select(
			"parametros.*,FORMAT( parametros.BCP_INTERES,4, 'de_DE') AS BCP_INTERES,
	FORMAT( parametros.IVA,4, 'de_DE') AS INTERES_IVA_PORCE
	"
		)->get()->getResult();



		if ($this->request->isAJAX())
			return view("parametros/grill",  ['parametros' => $params]);
		else
			return view("parametros/index",  ['parametros' => $params]);
	}



	public function create()
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario
			$reg = new Parametros_model();

			$datos = $this->request->getPost();
			//modificar?
			if (array_key_exists("IDNRO",  $datos)) {
				$datadata = array_diff_key($datos,  ['IDNRO' => ""]);
				$reg->update($datos['IDNRO'],  $datadata);
				return $this->response->setJSON(array("ok" =>  $datos['IDNRO']));
			} else {
				//crear
				$db = \Config\Database::connect();
				$reg->insert($datos);
				return $this->response->setJSON(array("ok" =>  $db->insertID()));
			}
		} else {
				$param =  (new Parametros_model())->select("parametros.*,
				
				 format( BCP_INTERES, 4, 'de_DE') as BCP_INTERES,
			format( IVA, 4, 'de_DE') AS INTERES_IVA_PORCE, 
			 format( SALARIO_MIN, 0, 'de_DE')  AS SALARIO_MIN,
			   format( JORNAL_MIN, 0, 'de_DE') AS JORNAL_MIN ")
				->first();
			
				
			return view('parametros/create', 	 ['dato' =>   $param] );
		}
	}







	public function  get()
	{

		//verificar como se piden los parametros
		$headerFormat = $this->request->getHeader("formato");

		$param = [];
		if (is_null($headerFormat)) {
			$param =   (new Parametros_model())->select(
				"parametros.*,FORMAT( parametros.BCP_INTERES,4, 'de_DE') AS BCP_INTERES,
		FORMAT( parametros.IVA,4, 'de_DE') AS INTERES_IVA_PORCE
		"
			)->first();
		} else {
			if ($headerFormat->getValue() ==  "json-raw")
				$param =   (new Parametros_model())
				->select(
					"parametros.*,  parametros.BCP_INTERES AS BCP_INTERES,
			parametros.IVA AS INTERES_IVA_PORCE
			"
				)
				->first();
		}
		return  $this->response->setJSON($param);
	}
}
