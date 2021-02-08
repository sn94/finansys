<?php namespace App\Controllers;

use App\Models\Permisos_model;
use App\Models\Usuario_model;
use CodeIgniter\Commands\Help;
use Exception;

class Usuario extends BaseController
{

	//constructor
	public function __construct()
	{  
	 
	}
	
	
	public function index()
	{
		try{ 
		$Usuario= new Usuario_model();
		$lista =$Usuario->findAll(); //recoge todas las filas

		echo view("usuario/index", array("lista"=> $lista ));
		
		}catch (\Exception $e) { //mostrar mensaje de error
					//mostrar mensaje de operacion exitosa
					die( $e->getMessage() ) ;	 
			}
	}




public static function get($cedula){
		// Create a shared instance of the model
		$funcio= new Usuario_model();
		$registro= $funcio->where('CEDULA',  $cedula)->first();
		if( is_null($registro))
		echo view("usuario/form", [ "OPERACION"=> "A" , "ADICIONAL"=>"CI° NO REGISTRADO"] );
		else
			echo view("usuario/form", array("usuario_dato"=> $registro , "OPERACION"=>"M"));
}
 


	public function create(){
		$model = new Usuario_model();

		if ($this->request->getMethod() === 'post' )
		{

			$db = \Config\Database::connect();

			$params=$this->request->getPost() ;
			if( isset(  $params["PASS"]))
			$params["PASS"]=  password_hash( $params["PASS"],  PASSWORD_BCRYPT);//hashear
			 //Datos del formulario
			 $db->transStart();
			$datos= new Usuario_model();
			$datos->insert( $params );
			//Permisos
			if( isset($params['PERMISO']) ){
				$cod_permisos= $params['PERMISO']; 
				$created_at= date("Y-m-d H:i:s");
				$id_user= $db->insertID();
	
				foreach( $cod_permisos as $codigo ):
					$db->query("insert into permisos_asigna(IDPERMISO,IDUSUARIO,created_at) VALUES($codigo,$id_user,'$created_at')");
				endforeach;
			}
			/** end permisos */

			$db->transComplete();

			if($this->request->isAJAX())
			{ 
				if( $db->transStatus())
				echo json_encode(array("IDNRO"=> $db->insertID() )  ) ;
				else
				echo json_encode(array("error"=> "Transacción no completada")  ) ;
			}
			else
			return redirect()->to(  base_url("usuario/index"));
		}
		else {  	
			helper("form");
			//LIStar permisos
			$permi_model= new Permisos_model();
			$permisos=  $permi_model->findAll();

			if($this->request->isAJAX())
			echo view('usuario/form',  ['OPERACION'=>"A", 'permisos'=> $permisos]);  
			else
			echo view('usuario/create', ['OPERACION'=>"A", 'permisos'=> $permisos ]);  	}
	}




	public function edit( $id= NULL){
		$model = new Usuario_model();

		if ($this->request->getMethod() === 'post' )
		{
			 //Datos del formulario
			$datos=  $this->request->getPost();  
			if( isset(  $params["PASS"]))
			$datos["PASS"]=  password_hash( $datos["PASS"],  PASSWORD_BCRYPT);//hashear
			if($model->update($datos["IDNRO"] , $datos ))
			{
				if( $this->request->isAJAX())
				echo json_encode( array( "IDNRO"=> $datos["IDNRO"] )  );
				else 
				return redirect()->to(  base_url("usuario/index"));
			}
			else
			echo view('plantillas/error', ['titulo'=>"ERROR", 'mensaje'=> "NO SE PUDO ACTUALIZAR" ]);  		
					
		}
		else {  
			helper("form");
			// Create a shared instance of the model
			$funcio= new Usuario_model();
			$registro= $funcio->find( $id ); 
			echo view('usuario/edit', ['usuario_dato'=> $registro, "OPERACION"=> "M" ]);  	}
	}


	public function view( $id){
		$funcio= new Usuario_model();
		$registro= $funcio->find( $id );
		helper("form");
		if( $this->request->isAJAX()) {	 	
		echo view("usuario/form", array("dato"=> $registro)  );}
		else {	  echo view("usuario/view", array("usuario_dato"=> $registro, "OPERACION"=> "V" )  );}
	}
	 


	public function delete( $id){
		$funcio= new Usuario_model(); 
		if( $funcio->delete( $id) )
		echo json_encode([ 'id'=> $id]   );
		else 
		echo json_encode( ['error' => "ERROR AL BORRAR"] );
	}



	public function sign_in(){

		helper("form");
		if ($this->request->getMethod() === 'post' )
		{

			$userdata= $this->request->getPost();
			$usermodel=  new Usuario_model();
			$user= $usermodel->where("NICK", $userdata['NICK']  )->first();
			if(  is_null( $user )  ){
				//NO EXISTE
				echo view("usuario/sign_in", ['MENSAJE'=>"ESTE NICK DE USUARIO NO EXISTE"]);
			}else{
				if( password_verify($userdata['PASS'],   $user->PASS )){
					//CORRECTA
					$session = \Config\Services::session();
					$newdata = [ 'ID'=>$user->IDNRO, 'NICK'  => $user->NICK, 'NIVEL'     => $user->ROL ];
					$session->set($newdata);
					
					return redirect()->to( base_url());
				}else{
					echo view("usuario/sign_in", ['MENSAJE'=>"CONTRASEÑA INCORRECTA"]);
				}

			}
		}else{
			echo view("usuario/sign_in");
		}
		
	}

	public function sign_out(){
		$session = \Config\Services::session();
		$session->destroy();
		return redirect()->to( base_url('/usuario/sign_in'));
	}
}
