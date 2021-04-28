<?php

namespace App\Controllers;

use App\Models\Productos_finan_model;

class Producto_finan extends BaseController
{

	//constructor
	public function __construct()
	{
	}





	public function index()
	{

		//verificar como se piden los parametros
		$headerFormat = $this->request->getHeader("formato");
		$formato = "html";

		if (!is_null($headerFormat))  $formato =  $headerFormat->getValue();

		if ($formato == "json") {
			$productos_financieros = (new Productos_finan_model())->get()->getResult();
			return $this->response->setJSON($productos_financieros);
		}

		$params = (new Productos_finan_model())
			->select("productos_finan.*,
				
			format( SEGURO_CANCEL, 0, 'de_DE') as SEGURO_CANCEL,
			format( SEGURO_3ROS, 0, 'de_DE') as SEGURO_3ROS,
			format( INTERES_PORCE, 4, 'de_DE') as INTERES_PORCE,
				 format( GAST_ADM_PORCE, 4, 'de_DE') as GAST_ADM_PORCE,
				 format( MORA_PORCE, 4, 'de_DE') as MORA_PORCE,
				 format( PUNITORIO_PORCE, 4, 'de_DE') as PUNITORIO_PORCE
			  ")
			->get()->getResult();

		if ($this->request->isAJAX())
			return view("producto_finan/grill",  ['producto_finan' => $params]);
		else
			return view("producto_finan/index",  ['producto_finan' => $params]);
	}



	public function  codigo_producto_redundante($codigo, $object = NULL)
	{

		$objectRef = (new Productos_finan_model())->where("CODIGO_PRODUCTO", $codigo)->first();

		if (is_null($objectRef))    return false;
		else {
			if (is_null($object))  return  true;
			else !($object->CODIGO_PRODUCTO ==  $codigo);
		}
	}

	public function create()
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario
			$reg = new Productos_finan_model();

			$datos = $this->request->getPost();
			if ($this->codigo_producto_redundante($datos['CODIGO_PRODUCTO']))
				return $this->response->setJSON(array("error" => "EL CÓDIGO {$datos['CODIGO_PRODUCTO']}  ya existe"));

			//crear
			$db = \Config\Database::connect();
			$reg->insert($datos);
			return $this->response->setJSON(array("ok" =>  $db->insertID()));
		} else {
			return view('producto_finan/create');
		}
	}




	public function edit($IDPROD = NULL)
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario
			$reg = new Productos_finan_model();
			$datos = $this->request->getPost();
			$reg->update($datos['IDNRO'],  $datos);
			return $this->response->setJSON(array("ok" =>  $datos['IDNRO']));
		} else {


			$param =  (new Productos_finan_model())->select("productos_finan.*,
				
			format( SEGURO_CANCEL, 0, 'de_DE') as SEGURO_CANCEL,
			format( INTERES_PORCE, 4, 'de_DE') as INTERES_PORCE,
				 format( GAST_ADM_PORCE, 4, 'de_DE') as GAST_ADM_PORCE,
				 format( MORA_PORCE, 4, 'de_DE') as MORA_PORCE,
				 format( PUNITORIO_PORCE, 4, 'de_DE') as PUNITORIO_PORCE
			  ")
				->find($IDPROD);
			return view('producto_finan/create', ['dato' =>  $param]);
		}
	}




	public function  get($IDPROD)
	{

		//verificar como se piden los parametros
		$headerFormat = $this->request->getHeader("formato");

		$param = [];
		if (is_null($headerFormat)) {
			$param =   (new Productos_finan_model())
				->select(
					"productos_finan.*,
		format(MORA_PORCE,  4,  'de_DE' ) AS MORA_PORCE  , FORMAT(PUNITORIO_PORCE, 4, 'de_DE' ) as PUNITORIO_PORCE,
		 format(GAST_ADM_PORCE,  4,  'de_DE' ) AS GAST_ADM_PORCE ,
		 format(INTERES_PORCE,  4,  'de_DE' )  AS INTERES_PORCE
		"
				)
				->find($IDPROD);
		} else {
			if ($headerFormat->getValue() ==  "json-raw")
				$param =   (new Productos_finan_model())
					->select(
						"productos_finan.*,
		MORA_PORCE  AS MORA_PORCE  ,  PUNITORIO_PORCE as PUNITORIO_PORCE,
		 GAST_ADM_PORCE  AS GAST_ADM_PORCE ,
		  INTERES_PORCE   AS INTERES_PORCE
		"
					)
					->find($IDPROD);
		}
		return  $this->response->setJSON($param);
	}



	public function delete($IDPROD)
	{
		$reg = new Productos_finan_model();

		if ($reg->delete($IDPROD))
			return $this->response->setJSON(array("ok" => $IDPROD));
		else
			return $this->response->setJSON(array("error" =>  "ERROR AL BORRAR"));
	}
}
