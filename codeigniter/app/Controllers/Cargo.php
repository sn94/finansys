<?php namespace App\Controllers;

use App\Models\Cargo_model;  
use Exception;

class Cargo extends BaseController
{

 //constructor
	public function __construct()
	{  
	 
	}
	
	
	public function index( )
	{
		try{ 
		$reg= new Cargo_model();
		$lista =$reg->findAll();  
		echo view("cargo/index", 
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
			$reg= new Cargo_model();
			$datos=$this->request->getPost(); 
			$reg->insert($datos);
			return redirect()->to( "index");
		}
		else {  	echo view('cargo/create');  	}
	}




	public function edit(   $id= NULL){ 
		if ($this->request->getMethod() === 'post' )
		{
			 //Datos del formulario
			 $reg= new Cargo_model();
			$datos=  $this->request->getPost(); 
			if($reg->update( $datos['IDNRO'], $datos))
			return redirect()->to( "index");
			else
			echo view('plantillas/error', ['titulo'=>"ERROR", 'mensaje'=> "NO SE PUDO ACTUALIZAR" ]);  		
					
		}
		else {  
			// Create a shared instance of the model 
			$reg= new Cargo_model();
			$registro= $reg->find( $id );  
			echo view('cargo/edit', ['dato'=> $registro ]);  	}
	}


	public function view(   $id){
		$reg= new Cargo_model();
		$registro= $reg->find( $id );  
		echo view("cargo/view", array("dato"=> $registro, "vista"=> true )  );
	}
	 


	public function delete(  $id){
		$reg= new Cargo_model();
	
		if( $reg->delete( $id))
		echo json_encode([ 'id'=> $id]   );
		else 
		echo json_encode( ['error' => "ERROR AL BORRAR"] );
	}

}
