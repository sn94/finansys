<?php namespace App\Controllers;

use App\Models\Deudor_model;
use App\Libraries\pdf_gen\PDF;
use App\Models\Prestamo_model;
use Exception;

class Deudor extends BaseController
{

	//constructor
	public function __construct()
	{  
	 
	}
	
	
	public function index()
	{
		//$pager = \Config\Services::pager();
		try{ 
		$Deudor= new Deudor_model();
		$lista =$Deudor->info_creditos_de_deudores(); //recoge todas las filas

		echo view("deudor/index", array("lista"=> $lista ));
		
		}catch (\Exception $e) { //mostrar mensaje de error
					//mostrar mensaje de operacion exitosa
					die( $e->getMessage() ) ;	 
			}
	}






public function get_empty_view( $tipo){
	if($tipo== "F"){ 	return view("deudor/persona_fisica");
	}else 	return view("deudor/persona_juridica");
}


 


public function existeCliente( $identi){
	$funcio= new Deudor_model();
		$registro= $funcio->where('CEDULA',  $identi)
		->orWhere('RUC', $identi)
		->first();
	return ! is_null($registro );
}


public  function get($field,$cedula,$modo= "V"){
		// Create a shared instance of the model
		$funcio= new Deudor_model();
		$registro= $funcio->where( $field,  $cedula) 
		->first();
		if( $this->request->isAJAX()){
			if( is_null($registro))
			echo view("deudor/forms/form", [ "OPERACION"=> $modo , "ADICIONAL"=>"CI°/RUC NO REGISTRADO"] );
			else
			echo view("deudor/forms/form", array("deudor_dato"=> $registro , "OPERACION"=> $modo ));
		}else{
			if( is_null($registro))
			echo view("deudor/view", [ "OPERACION"=> $modo , "ADICIONAL"=>"CI°/RUC NO REGISTRADO"] );
			else
			echo view("deudor/view", array("deudor_dato"=> $registro , "OPERACION"=> $modo ));
		}
	
}
 

private function gestionar_fotos(){
/*********** FOTO  *********************/
$datos= $this->request->getPost();
	$FOTO_ = $this->request->getFile('CEDU_ANVERSO');
	$FOTO2_ = $this->request->getFile('CEDU_REVERSO');
	if( $FOTO_->getPath() !=  "" ){//Solo si se ha proporcionado foto
		//Borrar archivo anterior
		$deudo_reg= new Deudor_model();
		$REG=$deudo_reg->find( $this->request->getPost("IDNRO") ); 
		try{
			$path_delete=  $REG->CEDU_ANVERSO ;
		if( $path_delete != "") unlink( substr( $path_delete, 1) );
		}catch (Exception $e) { }
		//fin borrado
	
	/** Substituir fotos */
	$Extension=$FOTO_->getClientExtension();
	if ($FOTO_->isValid() &&  !$FOTO_->hasMoved()){	
		$NombreFoto =$this->request->getPost("CEDULA")."-ANVERSO-".date("j-m-Y").".$Extension";
		$datos['CEDU_ANVERSO']= "/deudores/$NombreFoto" ;
		$FOTO_->move( 'deudores', $NombreFoto  ); 
		}// End reemplazo
	}


	if( $FOTO2_->getPath() !=  "" ){//Solo si se ha proporcionado foto
		//Borrar archivo anterior SEGUNDO
		try{
			$path_delete2= ! is_null( $REG)? $REG->CEDU_REVERSO : "";
			if( $path_delete2 != "") unlink( substr( $path_delete2, 1) );
		}catch (Exception $e) { }
		//fin borrado 2
		$Extension2=$FOTO2_->getClientExtension();
		if ($FOTO2_->isValid() &&  !$FOTO2_->hasMoved()){	 
			$NombreFoto2 =$this->request->getPost("CEDULA")."-REVERSO-".date("j-m-Y").".$Extension2";
			$datos['CEDU_REVERSO']= "/deudores/$NombreFoto2" ; 
			$FOTO2_->move( 'deudores', $NombreFoto2  );
			}// End reemplazo
		}
	return $datos;
}


	public function create(){
		$model = new Deudor_model();

		if ($this->request->getMethod() === 'post' )
		{
			 //Datos del formulario
			 //Verificar redundacia de CI O RUC
			 $datosRecibidos= $this->request->getPost();
			$identificador=  isset( $datosRecibidos['CEDULA']) ? $datosRecibidos['CEDULA']: $datosRecibidos['RUC'];
			if( !$this->existeCliente( $identificador))
			{
				$datos=$this->gestionar_fotos(); 
				$model->save($datos );
				if($this->request->isAJAX())
				{
				$db = \Config\Database::connect();
				echo json_encode(array("IDNRO"=> $db->insertID() )  ) ;
				}
				else
				return redirect()->to( base_url("deudor/index"));
			}else{
				//existe CI o RUC 
				echo json_encode(array("error"=> "EL NUMERO DE(CEDULA|RUC) ya existe")  ) ;
			}
		
		}
		else {
			helper("form");  	
			if($this->request->isAJAX())
			echo view('deudor/forms/form',  ['OPERACION'=>"A"]);  
			else
			echo view('deudor/create', ['OPERACION'=>"A"]);  	}
	}




	public function edit( $id= NULL){
		$model = new Deudor_model();

		if ($this->request->getMethod() === 'post' )
		{
			 //Datos del formulario
			$datos=  $this->gestionar_fotos();
			/******** */ 
			if($model->update($datos["IDNRO"] , $datos ))
			{
				if( $this->request->isAJAX())
				echo json_encode( array( "IDNRO"=> $datos["IDNRO"] )  );
				else 
				return redirect()->to(  base_url("deudor/index"));
			}
			else
			echo view('plantillas/error', ['titulo'=>"ERROR", 'mensaje'=> "NO SE PUDO ACTUALIZAR" ]);  		
					
		}
		else {  
			helper("form");
			// Create a shared instance of the model
			$funcio= new Deudor_model();
			$registro= $funcio->find( $id ); 
			echo view('deudor/edit', ['deudor_dato'=> $registro, "OPERACION"=> "M" ]);  	}
	}


 
	 


	public function delete( $id){
		$funcio= new Deudor_model(); 
		if( $funcio->delete( $id) )
		echo json_encode([ 'id'=> $id]   );
		else 
		echo json_encode( ['error' => "ERROR AL BORRAR"] );
	}



	//Informacion de saldos
	//Estado de cuenta del cliente
	public function calc_sumas_saldos($idcliente){
		$db= \Config\Database::connect();
		$data= $db->table("prestamo")

		->join("deudor", "deudor.IDNRO=prestamo.DEUDOR")
		->join("categoria_monto", "categoria_monto.IDNRO=prestamo.CAT_MONTO")
		->select("deudor.IDNRO, if(deudor.TIPO_PERSONA='F', CEDULA, RUC) AS CI_RUC, concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES, categoria_monto.MONTO AS DEUDA_TOTAL, categoria_monto.NRO_CUOTAS,
		(select count(*) from cuotas_prestamo where cuotas_prestamo.IDPRESTAMO=prestamo.IDNRO and cuotas_prestamo.ESTADO='C') as PAGADAS,
		(select count(*) from cuotas_prestamo where cuotas_prestamo.IDPRESTAMO=prestamo.IDNRO and cuotas_prestamo.ESTADO='P') as PENDIENTES")
		->where("prestamo.DEUDOR", $idcliente)
	   ->get()->getRowArray();
	   return  $data;
	}

	public function  sumas_saldos( $idcliente){
	   $data=  $this->calc_sumas_saldos($idcliente);
	   if(  $this->request->isAJAX())
	   return view("deudor/sumas_saldos_ajax", $data );
	   else
       return view("deudor/sumas_saldos", $data );
	}


//nUMERO DE CREDITOS REALIZADOS A NOMBRE DE CIERTO CLIENTE
	public function num_credi_reg(){
		$prestamo= new Deudor_model;
		$DATOS= $prestamo->info_creditos_de_deudores();
		foreach ( $DATOS AS $T){
			echo $T->creditos;
		}
	}


	public function buscar_por_palabra(){

		if( $this->request->getMethod(false) == "post"){
			 
			$param = $this->request->getJSON();
			$buscame= $param->buscado; 
			$deudor=  new Deudor_model();
			$resultado= $deudor->like("CEDULA", $buscame )
			->select("IDNRO, IF(RUC is null, CEDULA , RUC) AS ID, CONCAT(NOMBRES,CONCAT(' ',APELLIDOS)) as NOMBRES")
			->orLike('RUC', $buscame)
			->orLike("CONCAT(NOMBRES,CONCAT(' ',APELLIDOS))", $buscame)
			->orLike('NOMBRES', $buscame)
			->get()->getResultObject();
			echo json_encode(  $resultado );
		}else{
			 echo view("deudor/buscador", ['lista'=>  [] ] );
		}
	}
	public function list( $tipo ){
		$Deudor= new Deudor_model();
		$lista =$Deudor->info_creditos_de_deudores(); //recoge todas las filas
		if( $tipo == "json")
		echo json_encode(   $lista );
		else 
		{
			$html= $this->generar_html($lista);
			$tituloDocumento= "clientes-".date("d")."-".date("m")."-".date("yy")."-".rand();
			//echo $html;
			$pdf = new PDF();
			//$pdf = new PDF(); 
			$pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
			$pdf->generarHtml( $html);
			$pdf->generar();
		}

	}


	public function generar_html( $lista){
		$html= <<<EOF
		<style> 
			.cedula{
				width:90px;
			}
			.nombres{ 
				width: 200px;
			} 
			tr.cabecera{
				font-size: 7pt;
				background-color: #c2fcca;
				font-weight: bold;
			}
			table.tabla{ 
				border-top: 1px solid #606060;
				border-bottom: 1px solid #606060;
			}
			tr.cuerpo{
				color: #363636;
				font-size: 8px;
				font-weight: bold;
			}
		 
		</style>
		<h6>CLIENTES</h6>
		<table class="tabla">
		<thead>
		EOF;
		//CABECERA
		foreach( $lista as $ite){
			$html.="<tr class=\"cabecera\">";
			foreach( $ite as  $clave=> $valor)
			{
				if( $clave=="IDNRO") continue;
				if( $clave=="TELEFONO") continue;
				$clav= strtolower($clave);
				$th= $clave;
				if( $clav == "cedula")  $th="CI°/RUC";
				if( $clav == "nombres")  $th="NOMBRES/RAZÓN SOCIAL";
				$html.="<th class=\"$clav\">$th</th>";
			}
			$html.="</tr></thead><tbody>";break;
		}

		foreach( $lista as $ite){
			$html.="<tr class=\"cuerpo\">";
			foreach( $ite as  $clave=> $valor)
			{
				if( $clave=="IDNRO") continue;
				if( $clave=="TELEFONO") continue;
				$clav= strtolower($clave);
				$html.="<td class=\"$clav\">$valor</td>";
			}
			$html.="</tr>";
		}
		$html.= "</tbody></table>";

	}
}

