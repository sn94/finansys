<?php namespace App\Controllers;

use App\Models\Caja_model; 
use Exception;

class Caja extends BaseController
{

 //constructor
	public function __construct()
	{  
	 helper("form");
	}
	
	
	public function index( )
	{
		try{ 
		$reg= new Caja_model();
		$lista =$reg->findAll();  
		echo view("caja/index", 
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
			$reg= new Caja_model();
			$datos=$this->request->getPost(); 
			$reg->insert($datos);
			return redirect()->to( "index");
		}
		else {  	echo view('caja/create');  	}
	}




	public function edit(   $id= NULL){ 
		if ($this->request->getMethod() === 'post' )
		{
			 //Datos del formulario
			 $reg= new Caja_model();
			$datos=  $this->request->getPost(); 
			if($reg->update( $datos['IDNRO'], $datos))
			return redirect()->to( "index");
			else
			echo view('plantillas/error', ['titulo'=>"ERROR", 'mensaje'=> "NO SE PUDO ACTUALIZAR" ]);  		
					
		}
		else {  
			// Create a shared instance of the model 
			$reg= new Caja_model();
			$registro= $reg->find( $id );  
			echo view('caja/edit', ['dato'=> $registro ]);  	}
	}


	public function view(   $id){
		$reg= new Caja_model();
		$registro= $reg->find( $id );  
		echo view("caja/view", array("dato"=> $registro, "vista"=> true )  );
	}
	 


	public function delete(  $id){
		$reg= new Caja_model();
	
		if( $reg->delete( $id))
		echo json_encode([ 'id'=> $id]   );
		else 
		echo json_encode( ['error' => "ERROR AL BORRAR"] );
	}

}
