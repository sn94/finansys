<?php namespace App\Controllers;

use App\Models\Porcentaje_model;  
use Exception;

class Porcentaje extends BaseController
{

 //constructor
	public function __construct()
	{  
	 
	}
	
	
	public function index( )
	{
		try{ 
		$reg= new Porcentaje_model();
		$lista =$reg->findAll();  
		echo view("porcentaje/index", 
		array("lista"=> $lista));
		
		}catch (\Exception $e) { //mostrar mensaje de error
					//mostrar mensaje de operacion exitosa
					die( $e->getMessage() ) ;	 
			}
	}


  


	public function create( ){ 
		if ($this->request->getMethod() === 'post' )
		{
			 //Datos del formulario
			$reg= new Porcentaje_model();

			$datos=$this->request->getPost(); 
			//QUITAR PUNTOS
			$PORCENTAJE= preg_replace("/(\.+)/", "",  $datos['PORCENTAJE']);
			//REEMPLAZAR COMA POR PUNTO
			$PORCENTAJE=  preg_replace("/(,+)/", ".",  $PORCENTAJE) ;
			$datos['PORCENTAJE'] =   $PORCENTAJE;

			$reg->insert($datos);
			return redirect()->to( "index");
		}
		else {  	echo view('porcentaje/create');  	}
	}




	public function edit(   $id= NULL){ 
		if ($this->request->getMethod() === 'post' )
		{
			 //Datos del formulario
			 $reg= new Porcentaje_model();
			$datos=  $this->request->getPost(); 
			//QUITAR PUNTOS
			$PORCENTAJE= preg_replace("/(\.+)/", "",  $datos['PORCENTAJE']);
			//REEMPLAZAR COMA POR PUNTO
			$PORCENTAJE=  preg_replace("/(,+)/", ".",  $PORCENTAJE) ;
			$datos['PORCENTAJE'] =   $PORCENTAJE;

			if($reg->update( $datos['IDNRO'], $datos))
			return redirect()->to( "index");
			else
			echo view('plantillas/error', ['titulo'=>"ERROR", 'mensaje'=> "NO SE PUDO ACTUALIZAR" ]);  		
					
		}
		else {  
			// Create a shared instance of the model 
			$reg= new Porcentaje_model();
			$registro= $reg->find( $id );  
			echo view('porcentaje/edit', ['dato'=> $registro ]);  	}
	}


	public function view(   $id){
		$reg= new Porcentaje_model();
		$registro= $reg->find( $id );  
		echo view("porcentaje/view", array("dato"=> $registro, "vista"=> true )  );
	}
	 


	public function delete(  $id){
		$reg= new Porcentaje_model();
	
		if( $reg->delete( $id))
		echo json_encode([ 'id'=> $id]   );
		else 
		echo json_encode( ['error' => "ERROR AL BORRAR"] );
	}

}
