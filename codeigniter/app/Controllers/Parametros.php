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


 




	public function create()
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario
			$reg = new Parametros_model();

			$datos = $this->request->getPost();
			//modificar?
			$yaExiste= (new Parametros_model())->first();
			if (  is_null( $yaExiste)) {
				$db = \Config\Database::connect();
				$reg->insert($datos);
				return $this->response->setJSON(array("ok" =>  $db->insertID()));
			}else{
				$datadata= array_diff_key(  $datos,  ['IDNRO'=> ""] );
				$reg->update(  $datos['IDNRO'],  $datadata);
				return $this->response->setJSON(array("ok" =>  $datos['IDNRO']  ));
			}
			//return redirect()->to( "index");
		} else {
			$param=  (new Parametros_model())->
			select("parametros.*, format( BCP_INTERES, 4, 'de_DE') as BCP_INTERES,  format( GAST_ADM_PORCE, 4, 'de_DE') AS GAST_ADM_PORCE,
			format( IVA, 4, 'de_DE') AS IVA,  format( SALARIO_MIN, 0, 'de_DE')  AS SALARIO_MIN,  format( JORNAL_MIN, 0, 'de_DE') AS JORNAL_MIN")
			->first();
			echo view('parametros/index',  ['dato'=>   $param]);
		}
	}




 


	public function  get(){
		$param=   (new Parametros_model())->select("parametros.*,FORMAT( parametros.BCP_INTERES,4, 'de_DE') AS BCP_INTERES,
		FORMAT( parametros.IVA,4, 'de_DE') AS IVA
		")
		->first() ;
		 return  $this->response->setJSON( $param );
	}
 
}
