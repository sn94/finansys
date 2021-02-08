<?php namespace App\Controllers;

use App\Models\Cat_monto_model;  
use Exception;

class Categoria_monto extends BaseController
{

 //constructor
	public function __construct()
	{  
	 
		helper("form");
	}
	
	
	public function index( )
	{
		try{ 
		$reg= new Cat_monto_model();
		$lista =$reg->findAll();  
		if( $this->request->isAJAX())
		echo view("categoria_monto/index", 	array("lista"=> $lista));
		else
		echo view("categoria_monto/index", 	array("lista"=> $lista));
		}catch (\Exception $e) { //mostrar mensaje de error
					//mostrar mensaje de operacion exitosa
					die( $e->getMessage() ) ;	 
			}
	}


  


	public function create( ){ 
		if ($this->request->getMethod() === 'post' )
		{
			 //Datos del formulario
			$reg= new Cat_monto_model();
			$datos=$this->request->getPost(); 
			//limpiar los formatos
			$datos['MONTO']=   preg_replace("/(\.+)|(,+)/", "",  $datos['MONTO']);
			$datos['NRO_CUOTAS']=   preg_replace("/(\.+)|(,+)/", "",  $datos['NRO_CUOTAS']);
			$datos['CUOTA']=   preg_replace("/(\.+)|(,+)/", "",  $datos['CUOTA']);

			$reg->insert($datos);
			return redirect()->to( "index");
		}
		else {  	echo view('categoria_monto/create');  	}
	}




	public function edit(   $id= NULL){ 
		if ($this->request->getMethod() === 'post' )
		{
			 //Datos del formulario
			 $reg= new Cat_monto_model();
			$datos=  $this->request->getPost();
			//limpiar los formatos
			$datos['MONTO']=   preg_replace("/(\.+)|(,+)/", "",  $datos['MONTO']);
			$datos['NRO_CUOTAS']=   preg_replace("/(\.+)|(,+)/", "",  $datos['NRO_CUOTAS']);
			$datos['CUOTA']=   preg_replace("/(\.+)|(,+)/", "",  $datos['CUOTA']);
 
			if($reg->update( $datos['IDNRO'], $datos))
			return redirect()->to( "index");
			else
			echo view('plantillas/error', ['titulo'=>"ERROR", 'mensaje'=> "NO SE PUDO ACTUALIZAR" ]);  		
					
		}
		else {  
			// Create a shared instance of the model 
			$reg= new Cat_monto_model();
			$registro= $reg->find( $id );  
			echo view('categoria_monto/edit', ['dato'=> $registro ]);  	}
	}


	public function view(   $id){
		$reg= new Cat_monto_model();
		$registro= $reg->find( $id );  
		echo view("categoria_monto/view", array("dato"=> $registro, "vista"=> true )  );
	}
	 
	public function get(   $id){
		$reg= new Cat_monto_model();
		$registro= $reg->find( $id );    
		echo json_encode( $registro );
	}



	public function delete(  $id){
		$reg= new Cat_monto_model();
	
		if( $reg->delete( $id))
		echo json_encode([ 'id'=> $id]   );
		else 
		echo json_encode( ['error' => "ERROR AL BORRAR"] );
	}

}
