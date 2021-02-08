<?php namespace App\Controllers;

use App\Helpers\Utilidades;
use App\Models\Cargo_model;
use App\Models\Funcionario_model;
use Exception;

class Funcionario extends BaseController
{

	//constructor
	public function __construct()
	{  
		//instanciar el modelo 
		$this->em= new Funcionario_model(); 

	}
	
	
	public function index()
	{
		try{ 
			$funcionarios= new Funcionario_model();
			$funcionarios->select("funcionario.IDNRO,CEDULA,NOMBRES,APELLIDOS,CIUDAD,cargo.DESCR as CARGO")
			->join('cargo', 'cargo.IDNRO = funcionario.CARGO');
		$listafuncionario= $funcionarios->get()->getResultObject(); //recoge todas las filas

		echo view("funcionario/index", array("lista"=> $listafuncionario ));
		
		}catch (\Exception $e) { //mostrar mensaje de error
					//mostrar mensaje de operacion exitosa
					die( $e->getMessage() ) ;	 
			}
	}


	public function list(){
		try{
			//un template de tabla
		$table = new \CodeIgniter\View\Table();

		$template = [
				'table_open' => '<table cellpadding="2" cellspacing="1" class="table table-bordered table-striped">'
		];
		
		$table->setTemplate($template);
		//cabecera de la tabla
		$table->setHeading('ID','Sucursal','Cargo', 'Zona', 'Ciudad', 'Turno','Nombre','Apellido','Cedula','Direccion','Email');
		$listafuncionario= $this->em->findAll();
		$tabla= $table->generate($listafuncionario);
		echo view("funcionario/list", array("lista"=> $tabla ));

	}catch (\Exception $e) { //mostrar mensaje de error
				//mostrar mensaje de operacion exitosa
				die( $e->getMessage() ) ;	 
		}
	}


	public function create(){
		$model = new funcionario_model();
		helper("form");
		if ($this->request->getMethod() === 'post' )
		{
			 //Datos del formulario
			$datos= $this->request->getPost();
			/** FOTO  */
			$FOTO_ = $this->request->getFile('FOTO');
			$Extension=$FOTO_->getClientExtension();
			if ($FOTO_->isValid() &&  !$FOTO_->hasMoved()){	
				$NombreFoto =$this->request->getPost("CEDULA").date("j-m-Y").".$Extension";
				$datos['FOTO']= "/funcionarios/$NombreFoto" ;
				$FOTO_->move( 'funcionarios', $NombreFoto  );
			}
			/******** */ 
			$model->save($datos);
			return redirect()->to( base_url("funcionario/index"));
		}
		else {  
			$db = \Config\Database::connect();
			$reg= $db->query('select * from cargo');
			$cargos= $reg->getResultArray();//getResultArray(); 
			$resu=   Utilidades::dropdown($cargos);
 
			echo view('funcionario/create', ['cargos'=> $resu]);  	}
	}




	public function edit( $id= NULL){
		$model = new funcionario_model();

		if ($this->request->getMethod() === 'post' )
		{
			 //Datos del formulario
			$datos= $this->request->getPost();
			
			/*********** FOTO  *********************/
			
				$FOTO_ = $this->request->getFile('FOTO');
				if( $FOTO_->getPath() !=  "" ){//Solo si se ha proporcionado foto
					//Borrar archivo anterior
					$funcio_reg= new funcionario_model();
					$path_delete=$funcio_reg->find( $this->request->getPost("IDNRO") )->FOTO;
					try{
					if( $path_delete != "") unlink( substr( $path_delete, 1) );
					}catch (Exception $e) {
						
					}
					//fin borrado
					$Extension=$FOTO_->getClientExtension();//Obtener extension de archivo
					//Ubicar el nuevo archivo
					if ($FOTO_->isValid() &&  !$FOTO_->hasMoved()){	
						$NombreFoto =$this->request->getPost("CEDULA").date("j-m-Y").".$Extension";
						$datos['FOTO']= "/funcionarios/$NombreFoto";
						$FOTO_->move(  'funcionarios', $NombreFoto  );//WRITEPATH
					}
				}
				/******** */ 
				if($model->update($datos["IDNRO"] , $datos ))
				return redirect()->to( base_url("funcionario/index"));
				else
				echo view('plantillas/error', ['titulo'=>"ERROR", 'mensaje'=> $e->getMessage() ]);  
					
		}
		else {  
			$db = \Config\Database::connect();
			$reg= $db->query('select IDNRO,DESCR from cargo');
			$cargos= $reg->getResultArray();//getResultArray(); 
			$resu=   Utilidades::dropdown($cargos);
 
			// Create a shared instance of the model
			$funcio= new funcionario_model();
			$registro= $funcio->find( $id ); 

			echo view('funcionario/edit', ['dato'=> $registro, 'cargos'=>$resu ]);  	}
	}


	public function view( $id){
		$funcio= new funcionario_model();
		$registro= $funcio->find( $id );
		//cargos list
		$db = \Config\Database::connect();
		$reg= $db->query('select IDNRO,DESCR from cargo');
		$cargos= $reg->getResultArray();//getResultArray(); 
		$resucargos=   Utilidades::dropdown($cargos);
		echo view("funcionario/view", array("dato"=> $registro, "cargos"=> $resucargos, "vista"=> true )  );
	}
	 

	public function buscar_por_palabra(){

		if( $this->request->getMethod(false) == "post"){
			 
			$param = $this->request->getJSON();
			$buscame= $param->buscado; 
			$deudor=  new Funcionario_model();
			$resultado= $deudor->like("CEDULA", $buscame )
			->select("IDNRO, CEDULA, CONCAT(NOMBRES,CONCAT(' ',APELLIDOS)) as NOMBRES")
			->orLike("CONCAT(NOMBRES,CONCAT(' ',APELLIDOS))", $buscame)
			->get()->getResultObject();
			echo json_encode(  $resultado );
		}else{
			 echo view("funcionario/buscador", ['lista'=>  [] ] );
		}
	}


	public  function getJSON($field,$cedula){
		// Create a shared instance of the model
		$funcio= new Funcionario_model();
		$registro= $funcio->where( $field,  $cedula) 
		->first(); 
			if( is_null($registro))
			echo json_encode([]);
			else
			echo json_encode(   $registro);	 
}



	public  function get($field,$cedula,$modo= "V"){
		// Create a shared instance of the model
		$funcio= new Funcionario_model();
		$registro= $funcio->where( $field,  $cedula) 
		->first();
		if( $this->request->isAJAX()){
			if( is_null($registro))
			echo view("funcionario/form", [ "OPERACION"=> $modo , "ADICIONAL"=>"CI°/RUC NO REGISTRADO"] );
			else
			echo view("funcionario/form", array("funcionario_dato"=> $registro , "OPERACION"=> $modo ));
		}else{
			if( is_null($registro))
			echo view("funcionario/view", [ "OPERACION"=> $modo , "ADICIONAL"=>"CI°/RUC NO REGISTRADO"] );
			else
			echo view("funcionario/view", array("funcionario_dato"=> $registro , "OPERACION"=> $modo ));
		}
}


	public function delete( $id){
		$funcio= new funcionario_model(); 
		if( $funcio->delete( $id) )
		echo json_encode([ 'id'=> $id]   );
		else 
		echo json_encode( ['error' => "ERROR AL BORRAR"] );
	}

}
