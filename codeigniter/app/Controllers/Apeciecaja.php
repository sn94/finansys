<?php namespace App\Controllers;

use App\Helpers\Utilidades;
use App\Models\Ape_cierre_caja_model;
use App\Models\Caja_model;
use App\Models\Cat_monto_model;
use App\Models\Cobro_model;
use App\Models\Cuotas_model;
use App\Models\Deudor_model;
use App\Models\Garante_model;
use App\Models\Prestamo_model;
use Exception;

class Apeciecaja extends BaseController
{

	//constructor
	public function __construct()
	{  
	 helper("form");
	}
	
	
	 

 
	private function caja_abierta( $caja_id="" ){
		$caja= new Caja_model();
		$caja_= $caja->where("ESTADO", "ABIERTA")
		->where("IDNRO", $caja_id)
		->get()->getRow();
		return !is_null(  $caja_ ); 
	}
 
	private function recuperar_sesion_caja( $caja_id){
		$caja= new Ape_cierre_caja_model();
		$caja_= $caja->where("CAJA", $caja_id) 
		->where("CIERRE", NULL)
		->get()->getRow();
		if( !is_null($caja_) ){
			$apecieid= $caja_->IDNRO;
			$session= \Config\Services::session();
			$session->set("CAJA", $caja_id);
			$session->set("APECAJA", $apecieid );
		} 
	}


 
public function xx(){  echo  session("CAJA"); }
	public function apertura(){
		
		$session= \Config\Services::session();

		if( $session->has("CAJA") &&  $session->has("APECAJA")  )
		return view("apeciecaja/caja_ya_abierta", [  'MENSAJE'=>"YA HA ABIERTO UNA CAJA"]);

		/*if(  $this->caja_abierta( $DATOS['CAJA'])){
				$this->recuperar_sesion_caja( $DATOS['CAJA'] );
				return view("apeciecaja/caja_ya_abierta", [  'MENSAJE'=>"LA CAJA N° {$DATOS['CAJA']} YA ESTÁ ABIERTA"]);
			}*/


		$model = new Ape_cierre_caja_model();

		if ($this->request->getMethod() === 'post' )
		{
			 //Datos del formulario 
			$DATOS= $this->request->getPost();
			$DATOS['SALDO_INI']=   preg_replace("/(\.+)|(,+)/", "",  $DATOS['SALDO_INI']);
			$DATOS['CAJERO']= session("ID"); 

			$db= \Config\Database::connect();
			$db->transStart();
			$model->save(  $DATOS )  ;
			$db = \Config\Database::connect();
			$APECAJA= $db->insertID();
			$session->set('CAJA',   $DATOS['CAJA'] );
			$session->set('APECAJA',  $APECAJA );
				//Abrir caja
			$caja_mo= new Caja_model(); 
			$caja_mo->update(  $DATOS['CAJA'], ['ESTADO'=>  'ABIERTA']); 
			 
			$db->transComplete();
			if(  $db->transStatus() ) return redirect()->to( base_url("prestamo/index"));
			else echo "Error al abrir caja";
		}
		else {  
			//CAJA
			$db = \Config\Database::connect();
			$reg= $db->query('select IDNRO,NOMBRE from caja');
			$cajas= $reg->getResultArray();//getResultArray(); 
			$resu=   Utilidades::dropdown($cajas);
	   
			if(  $this->request->isAJAX())
			echo view('apeciecaja/apertura_ajax', ['cajas'=> $resu]);  
			else
			echo view('apeciecaja/apertura', ['cajas'=> $resu]);  	
		}
	}


	public function  aviso_pedir_apertura(){
		echo view('apeciecaja/aviso', ['MENSAJE'=> "REALICE LA APERTURA DE CAJA ANTES DE PROCEDER AL COBRO"]); 
	}


 

	public function arqueo_cierre(){
		$model = new Ape_cierre_caja_model();

		if ($this->request->getMethod() === 'post' )
		{
			 //Datos del formulario 
			$DATOS= $this->request->getPost();
			$DATOS['T_EFECTIVO']=   preg_replace("/(\.+)|(,+)/", "",  $DATOS['T_EFECTIVO']);
			$DATOS['T_CHEQUE']=   preg_replace("/(\.+)|(,+)/", "",  $DATOS['T_CHEQUE']);
			$DATOS['T_TARJETA']=   preg_replace("/(\.+)|(,+)/", "",  $DATOS['T_TARJETA']);
		
			$db= \Config\Database::connect();
			$db->transStart();
			$model->update(  session("APECAJA"),  $DATOS ) ;
				$session= \Config\Services::session();
				$session->remove('CAJA' );
				$session->remove('APECAJA' );
			$db->transComplete();
			if( $db->transStatus()) return redirect()->to( base_url());
			else  	echo "Error al cerrar caja";

		}
		else {  	 
			$session= \Config\Services::session();
			$request = \Config\Services::request();
			$uri = $request->uri;
			if(  !$session->has("CAJA") && !$session->has("APECAJA") &&  (sizeof(  $uri->getSegments())>0  &&  $uri->getSegment(1) == "apeciecaja" && $uri->getSegment(2)== "arqueo_cierre" ) )
			echo view('apeciecaja/aviso_plain', ['MENSAJE'=> "OPERACION NO PERMITIDA. NO HA ABIERTO NINGUNA CAJA"]); 
			else 
			{
				if( $this->request->isAJAX())
				echo view('apeciecaja/arqueo_cierre_ajax');  
				else	
				echo view('apeciecaja/arqueo_cierre');  
			}
		}
	}



	 



}
