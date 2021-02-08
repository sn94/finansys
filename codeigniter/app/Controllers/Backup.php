<?php namespace App\Controllers;

use App\Models\Caja_model;
use CodeIgniter\HTTP\Request;
use Exception;

class Backup extends BaseController
{

 //constructor
	public function __construct()
	{  
	 
	}
	

	public function index(){

		$li= $this->listar_();
		echo view("backup/index",   ['lista'=>   $li ]  );
	}
	

	 

	public function db_action( $OPERACION="backup" )
	{
		 
		//getting credentials
		$hostName= $_ENV['database.default.hostname'];
		$user= $_ENV['database.default.username'];
		$passw_db=  $_ENV['database.default.password'];
		$db_name=  $_ENV['database.default.database'];
		//BACKUP
		$fecha= date("d-m-Y");
		$randoms=   round(microtime(true) * 1000);
		//nOMBRE DE ARCHIVO
		$DATOS= $this->request->getJSON();
		$backupFileName= isset($DATOS->backup_name ) ? $DATOS->backup_name :  ("backups/PrestasysBackup$fecha$randoms.sql"); 

		try{  

		//	shell_exec("cd backups");
			//crear copia
			if( $OPERACION== "backup")
			$comando= "mysqldump -h $hostName -u  $user -p$passw_db $db_name >  \"$backupFileName\"";

			if($OPERACION== "restore")
			$comando= "mysql -h $hostName -u  $user -p$passw_db $db_name >  backup\"$backupFileName\"";

			 
			echo shell_exec( $comando);
			//	shell_exec("cd ..");
			//Listar copias de seguridad

		}catch (\Exception $e) { //mostrar mensaje de error
					//mostrar mensaje de operacion exitosa
					echo $e->getMessage();
					die( $e->getMessage() ) ;	 
	}
	}




	private function listar_(){

		$paths= "backups";
		$dir= opendir( $paths);
		$files_list= [];
		while ($elemento = readdir($dir)){
			// Tratamos los elementos . y .. que tienen todas las carpetas
			if( $elemento != "." && $elemento != ".."){
				// Si es una carpeta
				if( is_dir($paths.$elemento) ){
					// Muestro la carpeta
					//echo "<p><strong>CARPETA: ". $elemento ."</strong></p>";
				// Si es un fichero
				} else {
					// Muestro el fichero
				 
					array_push(  $files_list,   ['href'=> base_url($paths)."/$elemento",  'archivo'=> $elemento ]);
				}
			}
		}//End while
		return  $files_list;
	}

  






	public function borrar(){
	 
		$dt= $this->request->getJSON();
	 
		$linkfile=   $dt->linkfile;
	 
		//$res= unlink("backups/$linkfile");
		 
		var_dump( file_exists( "backups/$linkfile" ));
	}

	


}
