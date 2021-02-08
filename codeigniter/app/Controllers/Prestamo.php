<?php namespace App\Controllers;

use App\Helpers\NumeroALetras;
use App\Helpers\Utilidades;
use App\Libraries\pdf_gen\PDF;
use App\Models\Cat_monto_model;
use App\Models\Cobro_model;
use App\Models\Cuotas_model;
use App\Models\Deudor_model;
use App\Models\Garante_model;
use App\Models\Prestamo_model;
use App\Models\Recibo_model;
use Exception;

class Prestamo extends BaseController
{

	//constructor
	public function __construct()
	{  
	 helper("form");
	}
	
	
	public function index()
	{
		try{ 
		 
		$reg= new Prestamo_model();
		$builder = $reg->builder();
		$builder 
		->select("deudor.IDNRO as DEUDORID,CONCAT(deudor.NOMBRES,CONCAT(' ',deudor.APELLIDOS)) AS DEUDOR,
		if( (SELECT COUNT(cuotas_prestamo.IDNRO) FROM cuotas_prestamo WHERE IDPRESTAMO=prestamo.IDNRO) =0,
		'-', (SELECT COUNT(cuotas_prestamo.IDNRO) FROM cuotas_prestamo WHERE IDPRESTAMO=prestamo.IDNRO) ) AS TOTCUOTAS,
		(SELECT COUNT(detalle_cobro.IDNRO) FROM cobro,detalle_cobro WHERE cobro.IDNRO=detalle_cobro.IDCOBRO 
		 AND cobro.IDPRESTAMO=prestamo.IDNRO) AS PAGADAS,
		prestamo.IDNRO,FECHA_SOLICI,MONTO_APROBADO,MONTO_SOLICI, ESTADO")
		->join('deudor', 'deudor.IDNRO = prestamo.DEUDOR', "left") 
		->join('categoria_monto', 'categoria_monto.IDNRO = prestamo.CAT_MONTO')
		->orderBy("prestamo.created_at");
		$query = $builder->get();
		$lista= $query->getResult();  //recoge todas las filas
		 
		echo view("prestamo/index/index", array("lista"=> $lista ));
		
		}catch (\Exception $e) { //mostrar mensaje de error
					//mostrar mensaje de operacion exitosa
					die( $e->getMessage() ) ;	 
			}
	}


 
 
	//vista directa para cobros
	
	public function cobros()
	{
		ini_set('display_errors', '1');
		try{ 
		 
		$reg= new Prestamo_model();
		$builder = $reg->builder();
		$builder 
		->select("deudor.IDNRO as DEUDORID,CONCAT(deudor.NOMBRES,CONCAT(' ',deudor.APELLIDOS)) AS DEUDOR,
		(SELECT COUNT(cuotas_prestamo.IDNRO) FROM cuotas_prestamo WHERE IDPRESTAMO=prestamo.IDNRO) AS TOTCUOTAS,
		(SELECT COUNT(detalle_cobro.IDNRO) FROM cobro,detalle_cobro WHERE cobro.IDNRO=detalle_cobro.IDCOBRO 
		 AND cobro.IDPRESTAMO=prestamo.IDNRO) AS PAGADAS,
		prestamo.IDNRO,FECHA_SOLICI,MONTO_APROBADO, ESTADO")
		->join('deudor', 'deudor.IDNRO = prestamo.DEUDOR', "left") 
		->join('categoria_monto', 'categoria_monto.IDNRO = prestamo.CAT_MONTO')
		->where('ESTADO','A')
		->orderBy("prestamo.created_at");
		$query = $builder->get();
		$lista= $query->getResult();  //recoge todas las filas
		 
		echo view("prestamo/index/index", array("lista"=> $lista, 'titulo'=>'COBRANZAS' ));
		
		}catch (\Exception $e) { //mostrar mensaje de error
					//mostrar mensaje de operacion exitosa
					die( $e->getMessage() ) ;	 
			}
	}


 
	public function create(){
		$model = new Prestamo_model();

		if ($this->request->getMethod() === 'post' )
		{
			$DatosPRESTAMO=  $this->request->getPost();
			$categoria_monto=  $DatosPRESTAMO['CAT_MONTO'];
			$catemodelo= new Cat_monto_model();
			$categoria_dat= $catemodelo->find(  $categoria_monto);
			$montoCate=  $categoria_dat->MONTO;
			$DatosPRESTAMO['MONTO_SOLICI']=  $montoCate;
			 //Datos del formulario 
			$model->save($DatosPRESTAMO);
			if( $this->request->isAJAX())
			{$db = \Config\Database::connect();
			echo json_encode( array("IDNRO"=> $db->insertID(),  "MENSAJE"=>"PRESTAMO REGISTRADO"    ));}
			else
			return redirect()->to( base_url("prestamo/index/index"));
		}
		else {  	
			helper("form");
				/***Montos */
		$catm= new Cat_monto_model();
		$montos= $catm->list_dropdown(); 
		/**** */
	 
			/**** */
			echo view('prestamo/create', ['montos'=> $montos , 'OPERACION'=> 'A']);  	
		}
	}




	public function edit( $id= NULL){
		$model = new Prestamo_model();

		if ($this->request->getMethod() === 'post' )
		{
			 //Datos del formulario 
			 $datos= $datos= $this->request->getPost();
			if($model->update($datos["IDNRO"] , $datos  ))
			{

				if( $this->request->isAJAX())
				echo json_encode( array( "IDNRO"=> $datos["IDNRO"], "MENSAJE"=>"INFORMACIÓN DE PRESTAMO ACTUALIZADO" )  );
				else 
				return redirect()->to( base_url("prestamo/index/index"));
			}
			else
			echo view('plantillas/error', ['titulo'=>"ERROR", 'mensaje'=> "NO SE PUDO ACTUALIZAR" ]);  		
					
		}
		else {  
			helper("form");
			$reg= new Prestamo_model();
			$builder = $reg->builder();
			$builder= $builder 
			->select("deudor.IDNRO as DEUDORID,deudor.CEDULA as DEUDORCI,CONCAT(deudor.NOMBRES,CONCAT(' ',deudor.APELLIDOS)) AS DEUDORNOM,
			 garante.IDNRO as GARANTEID, garante.CEDULA AS GARANTECI,CONCAT(garante.NOMBRES,CONCAT(' ',garante.APELLIDOS)) as GARANTENOM,
			prestamo.*")
			->join('deudor', 'deudor.IDNRO = prestamo.DEUDOR')
			->join('garante', 'garante.IDNRO = prestamo.GARANTE', "left")
			->join('categoria_monto', 'categoria_monto.IDNRO = prestamo.CAT_MONTO')
			->where( "prestamo.IDNRO", $id);
			$query = $builder->get();
			$prestamo= $query->getRow(); 
			//Datos del deudor
			$deu= new Deudor_model();
			$deudor= $deu->find($prestamo->DEUDORID);
			//Parametros
			$params=  [];
			//Datos del garante
			if( $prestamo->GARANTEID != ""){
				$garan= new Garante_model();
				$garante= $garan->find($prestamo->GARANTEID);
				$params=   [ "garante_dato"=> $garante];
			}
		
			/***Montos */ 
			$catm= new Cat_monto_model();
			$montos= $catm->list_dropdown(); 
			/**** */
			
			//COncatenar parametros
			$ViewParams=[  "montos" => $montos,  'OPERACION'=> 'M', "prestamo_dato"=> $prestamo, 
			"deudor_dato"=> $deudor ];

			echo view('prestamo/edit', array_merge( $params, $ViewParams) );
		  	}
	}




	

	public function view( $id){
		helper("form");
		$reg= new Prestamo_model();
		$builder = $reg->builder();
		$builder 
		->select("deudor.IDNRO as DEUDORID,deudor.CEDULA as DEUDORCI,CONCAT(deudor.NOMBRES,CONCAT(' ',deudor.APELLIDOS)) AS DEUDORNOM,
		 garante.IDNRO as GARANTEID, garante.CEDULA AS GARANTECI,CONCAT(garante.NOMBRES,CONCAT(' ',garante.APELLIDOS)) as GARANTENOM,
		prestamo.*")
		->join('deudor', 'deudor.IDNRO = prestamo.DEUDOR')
		->join('garante', 'garante.IDNRO = prestamo.GARANTE', "left")
		->join('categoria_monto', 'categoria_monto.IDNRO = prestamo.CAT_MONTO')
		->where( "prestamo.IDNRO", $id);
		$query = $builder->get();
		$prestamo= $query->getRow(); 
		//Datos del deudor
		$deu= new Deudor_model();
		$deudor= $deu->find($prestamo->DEUDORID);
		
		//Parametros
		$params=  [];
		//Datos del garante
		if( $prestamo->GARANTEID != ""){
			$garan= new Garante_model();
			$garante= $garan->find($prestamo->GARANTEID);
			$params=   [ "garante_dato"=> $garante];
		}
	 
		/***Montos */
		$catm= new Cat_monto_model();
		$montos= $catm->list_dropdown(); 
		/**** */
	 
		$ViewParams=  array( "montos" => $montos, "prestamo_dato"=> $prestamo, "deudor_dato"=> $deudor , "OPERACION"=> "V" );

		echo view("prestamo/view", array_merge($params,  $ViewParams )  );
	}
	 


	public function delete( $id){
		$funcio= new Prestamo_model(); 
		if( $funcio->delete( $id) )
		echo json_encode([ 'id'=> $id]   );
		else 
		echo json_encode( ['error' => "ERROR AL BORRAR"] );
	}




/**
 * 
 * APROBACION RECHAZO
 */
	public function aprobar( $id_prestamo =""){

		if ($this->request->getMethod() === 'post' )
		{

			//Actualizar estado de prestamo a Aprobado
				//Generar las cuotas
			$prestamo_m= new Prestamo_model(); 
			$id_prestamo= $this->request->getPost("IDNRO");
			$prestamo= $prestamo_m->find($id_prestamo);
			//Verificar si ya se aprobo
			if( $prestamo_m->ESTADO == "A" ){
				return redirect()->to(base_url("prestamo/index/index"));
			}else{
				$prestamo_m->aprobar(); 	 
				return redirect()->to( base_url("prestamo/index/index"));
			}
		}
		else{
			$prestamo_m= new Prestamo_model();
			//Prestamo
			$prestamo= $prestamo_m->find($id_prestamo);
			if( $prestamo->ESTADO == "A" ){
				return redirect()->to( base_url("prestamo/index/index") );
			}else{
				//Cliente deudor
				$ID_deudor= $prestamo->DEUDOR;
				$deudor_m= new Deudor_model();
				$deudor= $deudor_m->find( $ID_deudor); 
				//Categoria monto
				$catem= new Cat_monto_model();
				$catemonto= $catem->find(  $prestamo->CAT_MONTO);

				helper("form"); 
						/***Montos */
				$catm= new Cat_monto_model();
				$montos= $catm->list_dropdown(); 
				/**** */

				echo view("prestamo/aprobar",
				["deudor"=>$deudor, "prestamo"=>$prestamo, "monto"=> $catemonto, "montos"=> $montos]);	
			} 
		}
	}



	public function rechazar(  $id_prestamo){

		$prestamo= new Prestamo_model();
		if(  $prestamo->update(  $id_prestamo, ['ESTADO'=> 'R', 'FECHA_RECHAZO'=> date("Y-m-d"), 'FUNCIONARIO_RECHA'=> session("ID")] ) )
		echo json_encode( ['IDNRO'=> $id_prestamo, 'MENSAJE'=>'LA SOLICITUD DE PRESTAMO HA SIDO RECHAZADA']);
		else
		$this->error_alert();
	}



	private function generar_recibo( $id_cobro){

		$cobro= $this->request->getPost("CABECERA"); 
		$TOTAL_IMPORTE=  intval($cobro['EFECTIVO_T']) + intval($cobro['TARJE_IMPO']) + intval($cobro['CHEQUE_IMPO']);
		$DEUDOR= $cobro['DEUDOR'];
		//CAT MONTO
		$objPrestamo= (new Prestamo_model())->find( $cobro['IDPRESTAMO'] );
		$categoria= (new Cat_monto_model())->find( $objPrestamo->CAT_MONTO );

		$CONCEPTO= "PAGO DE CUOTA DEL CREDITO DE ".Utilidades::number_f($categoria->MONTO)."(".Utilidades::number_f($categoria->CUOTA)."X".$categoria->NRO_CUOTAS.")";
		$FECHA_L= Utilidades::fechaDescriptiva( $cobro['FECHA'] );
		$datos= ['IMPORTE'=> $TOTAL_IMPORTE, 'DEUDOR'=>$DEUDOR, 'IDCOBRO'=>$id_cobro,
		 'CONCEPTO'=>$CONCEPTO,'FECHA_L'=> $FECHA_L ];
		$recibo= new Recibo_model();
		$recibo->insert($datos);
		$db = \Config\Database::connect();
		$id_recibo= $db->insertID();
		return $id_recibo;
	}


	public function mostrarRecibo( $id_recibo){
		$ReciboObj= new Recibo_model();
        $recibo= $ReciboObj->find( $id_recibo);
      
			$IMPORTE=  $recibo->IMPORTE;
			$deudor= (new Deudor_model())->find( $recibo->DEUDOR );
            $TITULAR= $deudor->NOMBRES." ".$deudor->APELLIDOS;
            $IMPORTEL= (new NumeroALetras())->toWords( $IMPORTE);
            $CONCEPTO= $recibo->CONCEPTO;
            $FECHAL=  $recibo->FECHA_L;
            
			echo  view("prestamo/recibo",
			[ 'NRORECIBO'=> $id_recibo, 'IMPORTE'=> $IMPORTE, 'IMPORTE_LETRAS'=>$IMPORTEL, "CLIENTE"=> $TITULAR , 
           "FECHA_LETRAS"=>$FECHAL, "CONCEPTO"=>$CONCEPTO]);     
        
       
    }



	private function mostrarEstadoCtaPostCobro( $id_recibo){
		 
		//Mostrar estado de cuenta de cliente y un link para imprimir recibo
		$opc_deudor= new Deudor();
		$todo= $this->request->getPost("CABECERA"); 
		$idCliente= $todo['DEUDOR'];
		$data_estado_cta=  $opc_deudor->calc_sumas_saldos(  $idCliente);
		echo view("deudor/sumas_saldos", array_merge([ 'id_recibo'=>$id_recibo],  $data_estado_cta) );
		//**************** */
	}



	public function cobro( $id_prestamo =""){

		if ($this->request->getMethod() === 'post' )
		{
			$cobro= $this->request->getPost("CABECERA"); 
		
			//Actualizar estado de prestamo a Aprobado
			//Generar las cuotas
			$db = \Config\Database::connect();

			//COD de recibo
			$id_recibo= NULL;


			$cobr= new Cobro_model(); 
			$db->transStart();
			$id_cobro= $cobr->cobrar(); 
			//generar recibo

				$id_recibo=  $this->generar_recibo( $id_cobro);
				
				//echo json_encode( array("print"=> $id_recibo )  );

			//**************** */ 
			$db->transComplete();	
			 
			if(  $db->transStatus())
			{
			//Mostrar estado de cuenta de cliente y un link para imprimir recibo
			$this->mostrarEstadoCtaPostCobro( $id_recibo);
		
			}
			else 
			return redirect()->to( base_url('/prestamo/error_alert')); //algun mensaje de error
		}
		else{
 
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$uri = $request->uri;

			if(  !$session->has("CAJA")  &&  (sizeof(  $uri->getSegments())>0  &&  $uri->getSegment(1) == "prestamo" && $uri->getSegment(2)== "cobro" ) )
			return redirect()->to(  base_url("apeciecaja/aviso_pedir_apertura"));
			else{
				$prestamo_m= new Prestamo_model();
				//Prestamo
				$prestamo= $prestamo_m->find($id_prestamo);
				//Cliente deudor
				$ID_deudor= $prestamo->DEUDOR;
				$deudor_m= new Deudor_model();
				$deudor= $deudor_m->find( $ID_deudor); 
				//Categoria monto
				$catem= new Cat_monto_model();
				$catemonto= $catem->find(  $prestamo->CAT_MONTO);
		
				helper("form");   
				/***Cuotas */
				$cuotas= $prestamo_m->obtener_cuotas(  $id_prestamo); 
			 
				echo view("prestamo/cobro/cobro",
				 ["deudor"=>$deudor, "prestamo_dato"=>$prestamo, "monto"=> $catemonto, "cuotas"=>$cuotas]);
			}
				
		}
	}






	public function  total_cobrados_por_dia(){
		$cob=  new Cobro_model();
		
		$resu = $cob->select("DATE_FORMAT( date( cobro.FECHA ) , '%d / %m /  %Y' ) as FECHA,(SELECT SUM(EFECTIVO_T) from cobro) AS EFECTIVO, (SELECT SUM(CHEQUE_IMPO) from cobro) AS CHEQUE,
		 (SELECT SUM(TARJE_IMPO) from cobro) AS TARJETA")
		 ->limit(0, 5)
		 ->groupBy("cobro.FECHA")
		->get()->getResultObject(); 
		return $this->response->setJSON($resu); 
	}



	public function error_alert(){
		echo json_encode( ['error'=> "Ocurrió un error en el servidor, no se han concretado las transacciones"]);
	}




	/**
	 * I N F O R M E S
	 */
//COBROS REALIZADOS
	public function informes_cobros( $FORMATO= "HTML"){
		//HTML
		//JSON
		//PDF
		$cobro= NULL;

		if($FORMATO=="HTML")
		$cobro= new Cobro_model();

		if($FORMATO=="PDF" || $FORMATO=="JSON")
		{
			$db      = \Config\Database::connect();
			$cobro = $db->table('cobro');
		}

		$cobro= $cobro->select("FECHA, (EFECTIVO_T+CHEQUE_IMPO+TARJE_IMPO) AS TOTAL, CONCAT(deudor.NOMBRES,CONCAT(' ', deudor.APELLIDOS)) AS CLIENTE,
		CONCAT(funcionario.NOMBRES,CONCAT(' ', funcionario.APELLIDOS)) AS CAJERO,  
		EFECTIVO_T AS EFECTIVO, CHEQUE_IMPO AS CHEQUE,TARJE_IMPO AS TARJETA, CAJA")
		->join('deudor', 'deudor.IDNRO = cobro.DEUDOR')
		->join('funcionario', 'funcionario.IDNRO = cobro.CAJERO');

		//VERIFICAR NIVEL DE USUARIO
		if( session("NIVEL") != "A"){
			$cobro->where("CAJERO", session("ID") );
		}
		if ($this->request->getMethod() === 'post' )
		{
			$desde= $this->request->getPost("Desde"); 
			$hasta= $this->request->getPost("Hasta"); 
			if( $desde !=""  &&  $hasta != "")
			$cobro->where("DATE(FECHA) >=", $desde)->where("DATE(FECHA) <=", $hasta);
			
 

			if( $this->request->isAJAX()) 
			{
				if( $FORMATO == "HTML")
				{$pager= $cobro->paginate(15); 
				echo view("prestamo/informes/informes_cobro_grilla", ['lista'=>  $pager, 'enlaces'=> $cobro->pager]);}
				if($FORMATO=="JSON")
				echo json_encode(  $cobro->get()->getResultArray() );
			}
			else
			{ 
				if( $FORMATO == "PDF")
				$this->generar_pdf( $cobro->get()->getResultObject() );
				if( $FORMATO == "HTML")
				{
					$pager= $cobro->paginate(15); 
					echo view("prestamo/informes/informes_cobro", ['lista'=>  $pager, 'enlaces'=> $cobro->pager]);
				}
				
			}
		}
		else{

			$pager= $cobro->paginate(15); 
			echo view("prestamo/informes/informes_cobro", ['lista'=>  $pager, 'enlaces'=> $cobro->pager]);
		}
	}





	//CUOTAS ATRASADAS
	public function informes_cuotas( $FORMATO= "HTML"){
		//HTML
		//JSON
		//PDF
		$cobro= NULL;

		if($FORMATO=="HTML")
		$cobro= new Cuotas_model();

		if($FORMATO=="PDF" || $FORMATO=="JSON")
		{
			$db      = \Config\Database::connect();
			$cobro = $db->table('cuotas_prestamo');
		}

		$cobro= $cobro->select("MONTO_APROBADO AS CAPITAL, NUMERO, MONTO AS CUOTA, VENCIMIENTO,
		 IF(  FECHA_PAGO IS NULL, '', FECHA_PAGO) AS FECHA_PAGO  , CONCAT(deudor.NOMBRES,CONCAT(' ', deudor.APELLIDOS)) AS CLIENTE,
		IF( DATEDIFF(VENCIMIENTO,NOW() )>0  , concat('Faltan ',  concat( DATEDIFF(VENCIMIENTO,NOW() )  , ' dia(s)')  )     ,  IF( DATEDIFF(VENCIMIENTO,NOW() ) = 0, 'VENCE HOY', concat( abs( DATEDIFF(VENCIMIENTO,NOW() )) ,  ' dias de atraso'))    )  AS ESTADO,
		(MONTO-(select IFNULL(sum(IMPORTE),0) from detalle_cobro where detalle_cobro.IDCUOTA=cuotas_prestamo.IDNRO)) AS SALDO")
		->join('cobro', 'cuotas_prestamo.IDPRESTAMO = cobro.IDNRO')
		->join('prestamo', 'prestamo.IDNRO = cuotas_prestamo.IDPRESTAMO')
		->join('deudor', 'deudor.IDNRO = cobro.DEUDOR')
		->join('funcionario', 'funcionario.IDNRO = cobro.CAJERO');

		//VERIFICAR NIVEL DE USUARIO
		if( session("NIVEL") != "A"){
			$cobro->where("cobro.CAJERO", session("ID") );
		}
		if ($this->request->getMethod() === 'post' )
		{
				//Filtro 1 por fecha de vencimiento
			$desde= $this->request->getPost("Desde"); 
			$hasta= $this->request->getPost("Hasta"); 
			if( $desde !=""  &&  $hasta != "")
			{
				$cobro= $cobro->where("VENCIMIENTO >=", $desde)->where("VENCIMIENTO <=", $hasta);
				$cobro= $cobro->orderBy("VENCIMIENTO");
			}
			//Filtro 2 por fecha de pago
			$pagodesde= $this->request->getPost("DesdePago"); 
			$pagohasta= $this->request->getPost("HastaPago"); 
			if( $pagodesde !=""  &&  $pagohasta != "")
			{
				$cobro= $cobro->where("FECHA_PAGO >=", $pagodesde)->where("FECHA_PAGO <=", $pagohasta);
				$cobro= $cobro->orderBy("FECHA_PAGO");
			}

			//Filtro 3 por estado de vencimiento
			//situacion de cuota: todas T, vencidas S, no vencidas N
			$modo= $this->request->getPost("vencidas"); 
			if(   $modo=="N")
			$cobro= $cobro->where("DATEDIFF(VENCIMIENTO, NOW()) >", 0);
			if( $modo=="S")
			$cobro= $cobro->where("DATEDIFF(VENCIMIENTO, NOW()) <=", 0);

			//Filtro 4 por estado de pago
			$cobradas= $this->request->getPost("cobradas"); 
			if(  $pagodesde ==""  &&  $pagohasta == ""){
				if(   $cobradas=="PA") //pagadas
				$cobro= $cobro->where("cuotas_prestamo.ESTADO", "C");
				if( $cobradas=="PE") //pendientes
				$cobro= $cobro->where("cuotas_prestamo.ESTADO", "P");
			}
			


			if( $this->request->isAJAX()) 
			{
				if( $FORMATO == "HTML")
				{$pager= $cobro->paginate(15); 
				echo view("prestamo/informes/cuotas_grilla", ['lista'=>  $pager, 'enlaces'=> $cobro->pager]);}
				if($FORMATO=="JSON")
				echo json_encode(  $cobro->get()->getResultArray() );
			}
			else
			{ 
				if( $FORMATO == "PDF")
				$this->generar_pdf( $cobro->get()->getResultObject() , "CUOTAS ");
				if( $FORMATO == "HTML")
				{
					$pager= $cobro->paginate(15); 
					echo view("prestamo/informes/cuotas", ['lista'=>  $pager, 'enlaces'=> $cobro->pager]);
				}
				
			}
		}
		else{

			$pager= $cobro->paginate(15); 
			echo view("prestamo/informes/cuotas", ['lista'=>  $pager, 'enlaces'=> $cobro->pager]);
		}
	}


/*
select categoria_monto.MONTO AS CAPITAL,categoria_monto.NRO_CUOTAS,categoria_monto.CUOTA,
 (categoria_monto.CUOTA*categoria_monto.NRO_CUOTAS) as 'CAPITAL FINAL',
  ( (categoria_monto.CUOTA*categoria_monto.NRO_CUOTAS) - categoria_monto.MONTO) as TOT_INTERES,
   ( SELECT SUM(IMPORTE) from detalle_cobro,cobro where cobro.IDNRO=detalle_cobro.IDCOBRO AND 
   cobro.IDPRESTAMO=prestamo.IDNRO ) AS IMPORTE,
	( (categoria_monto.CUOTA*categoria_monto.NRO_CUOTAS) - ( SELECT SUM(IMPORTE) from detalle_cobro,cobro where cobro.IDNRO=detalle_cobro.IDCOBRO AND cobro.IDPRESTAMO=prestamo.IDNRO )) AS SALDO
	 FROM cobro cobr JOIN prestamo on prestamo.IDNRO=cobr.IDPRESTAMO join categoria_monto on categoria_monto.IDNRO=prestamo.CAT_MONTO
	  GROUP by prestamo.IDNRO */

//totalizar lo cobrado en cuotas, y calcular el interes
	public function informes_capital_interes( $FORMATO="HTML"){
		//HTML
		//JSON
		//PDF
		$cobro= NULL;

		if($FORMATO=="HTML")
		$cobro= new Deudor_model();

		if($FORMATO=="PDF" || $FORMATO=="JSON")
		{
			$db      = \Config\Database::connect();
			$cobro = $db->table('deudor');
		}

		$cobro= $cobro->select("CONCAT(deudor.NOMBRES, IF(deudor.APELLIDOS is null, '', CONCAT(' ', deudor.APELLIDOS))   ) AS CLIENTE,
		categoria_monto.MONTO AS CAPITAL,categoria_monto.NRO_CUOTAS,categoria_monto.CUOTA,(categoria_monto.CUOTA*categoria_monto.NRO_CUOTAS) as 'CAPITAL_FINAL',
		 ( (categoria_monto.CUOTA*categoria_monto.NRO_CUOTAS) - categoria_monto.MONTO) as TOT_INTERES,
		  ( SELECT SUM(IMPORTE) from detalle_cobro,cobro where cobro.IDNRO=detalle_cobro.IDCOBRO AND 
		  cobro.IDPRESTAMO=prestamo.IDNRO ) AS 'TOT_PAGADO',
		   ( (categoria_monto.CUOTA*categoria_monto.NRO_CUOTAS) - 
		   ( SELECT SUM(IMPORTE) from detalle_cobro,cobro where cobro.IDNRO=detalle_cobro.IDCOBRO AND cobro.IDPRESTAMO=prestamo.IDNRO )) AS SALDO")
	
		
		
		->join('cobro', 'deudor.IDNRO = cobro.DEUDOR')
		->join('prestamo', 'prestamo.IDNRO = cobro.IDPRESTAMO')
		->join('categoria_monto', 'categoria_monto.IDNRO=prestamo.CAT_MONTO')
		->join('funcionario', 'funcionario.IDNRO = cobro.CAJERO')
		->groupBy("deudor.IDNRO");

		//VERIFICAR NIVEL DE USUARIO
		if( session("NIVEL") != "A"){
			$cobro->where("cobro.CAJERO", session("ID") );
		}
		if ($this->request->getMethod() === 'post' )
		{
			//Filtro 1 por fecha  
			$desde= $this->request->getPost("Desde"); 
			$hasta= $this->request->getPost("Hasta"); 
			if( $desde !=""  &&  $hasta != "")
			$cobro= $cobro->where("FECHA >=", $desde)->where("FECHA <=", $hasta);
			
			if( $this->request->isAJAX()) 
			{
				if( $FORMATO == "HTML")
				{$pager= $cobro->paginate(15); 
				echo view("prestamo/informes/informes_capi_saldos_grilla", ['lista'=>  $pager, 'enlaces'=> $cobro->pager]);}
				if($FORMATO=="JSON")
				echo json_encode(  $cobro->get()->getResultArray() );
			}
			else
			{ 
				if( $FORMATO == "PDF")
				$this->generar_pdf( $cobro->get()->getResultObject() , "CAPITAL & INTERÉS ");
				if( $FORMATO == "HTML")
				{
					$pager= $cobro->paginate(15); 
					echo view("prestamo/informes/informes_capi_saldos", ['lista'=>  $pager, 'enlaces'=> $cobro->pager]);
				}
				
			}
		}
		else{//Request Get
			if( $FORMATO == "JSON")
			echo json_encode(  $cobro->get()->getResultObject()  );
			else
			{
				$pager= $cobro->paginate(15); 
				echo view("prestamo/informes/informes_capi_saldos", ['lista'=>  $pager, 'enlaces'=> $cobro->pager]);
			}
		}

	}




	//conducta crediticia
	public function informes_conducta_pago( $FORMATO= "HTML"){
		//HTML
		//JSON
		//PDF
		$cobro= NULL;

		if($FORMATO=="HTML")
		$cobro= new Deudor_model();

		if($FORMATO=="PDF" || $FORMATO=="JSON")
		{
			$db      = \Config\Database::connect();
			$cobro = $db->table('deudor');
		}

		$cobro= $cobro->select("if(RUC is null, CEDULA, RUC) AS 'CI/RUC',  if( RUC is not null, NOMBRES, CONCAT(deudor.NOMBRES,CONCAT(' ', deudor.APELLIDOS)) ) AS CLIENTE,
	   (select count(cuotas_prestamo.IDNRO) from cuotas_prestamo where cuotas_prestamo.IDPRESTAMO= prestamo.IDNRO
	    AND DATEDIFF(cuotas_prestamo.VENCIMIENTO, cuotas_prestamo.FECHA_PAGO) > 0 ) AS PAGO_REGULAR,
		(select count(cuotas_prestamo.IDNRO) from cuotas_prestamo where cuotas_prestamo.IDPRESTAMO= prestamo.IDNRO
	    AND DATEDIFF(cuotas_prestamo.VENCIMIENTO, cuotas_prestamo.FECHA_PAGO) <= 0 ) AS PAGO_ATRASADO
		")
		->join('prestamo', 'deudor.IDNRO = prestamo.DEUDOR');

		//VERIFICAR NIVEL DE USUARIO
		if( session("NIVEL") != "A"){
			$cobro->where("prestamo.FUNCIONARIO", session("ID") );
		}
		if ($this->request->getMethod() === 'post' )
		{
			$desde= $this->request->getPost("Desde"); 
			$hasta= $this->request->getPost("Hasta"); 
			if( $desde !=""  &&  $hasta != "")
			$cobro->where("DATE(FECHA) >=", $desde)->where("DATE(FECHA) <=", $hasta);
			
 

			if( $this->request->isAJAX()) 
			{
				if( $FORMATO == "HTML")
				{$pager= $cobro->paginate(15); 
				echo view("prestamo/informes/informes_conducta_pago_grilla", ['lista'=>  $pager, 'enlaces'=> $cobro->pager]);}
				if($FORMATO=="JSON")
				echo json_encode(  $cobro->get()->getResultArray() );
			}
			else
			{ 
				if( $FORMATO == "PDF")
				$this->generar_pdf( $cobro->get()->getResultObject() );
				if( $FORMATO == "HTML")
				{
					$pager= $cobro->paginate(15); 
					echo view("prestamo/informes/informes_conducta_pago", ['lista'=>  $pager, 'enlaces'=> $cobro->pager]);
				}
				
			}
		}
		else{

			$pager= $cobro->paginate(15); 
			echo view("prestamo/informes/informes_conducta_pago", ['lista'=>  $pager, 'enlaces'=> $cobro->pager]);
		}
	}



	public function generar_html( $lista, $TITULO= "COBROS " ){
		$html= <<<EOF
		<style> 
			.numero{
				width: 60px;
				text-align: center;
			}
			.nro_cuotas{
				text-align: center;
			}
			.cuota, .capital,.saldo,.tot_interes,.tot_pagado,.capital_final{
				width: 70px;
				text-align: right;
			}
			.vencimiento,.fecha_pago{
				width: 70px;
				text-align: center
			}
			.fecha{
				width:48px;
			}
			.total,.efectivo,.cheque,.tarjeta,.caja{
				width:60px;
				text-align: right;
			}
			.cliente, .cajero{ 
				width: 125px; 
				text-align: left;
			} 
			.caja{
				width: 40px;
			}
			tr.cabecera{
				font-size: 6pt;
				background-color: #c2fcca;
				font-weight: bold;
			} 
			tr.cuerpo{
				color: #363636;
				font-size: 6pt;
				font-weight: bold;
			}
		 
		</style>
		<h6>$TITULO</h6>
		<table class="tabla">
		<thead>
		EOF;
		//CABECERA
		foreach( $lista as $ite){
			$html.="<tr class=\"cabecera\">";
			foreach( $ite as  $clave=> $valor)
			{ 
				$clav= strtolower($clave);
				$html.="<th class=\"$clav\">$clave</th>";
			}
			$html.="</tr></thead><tbody>";break;
		}

		foreach( $lista as $ite){
			$html.="<tr class=\"cuerpo\">";
			foreach( $ite as  $clave=> $valor)
			{ 
				$clav= strtolower($clave);
				$nuevo_valor= $valor;
				if(  $clave=="TOTAL" || $clave=="SALDO"  || $clave=="EFECTIVO" || $clave=="CHEQUE" || $clave=="TARJETA" || $clave=="CUOTA"  || $clave=="CAPITAL")
				$nuevo_valor= Utilidades::number_f($valor);
				if($clave=="FECHA" || $clave=="VENCIMIENTO"  )
				$nuevo_valor= Utilidades::fecha_f($valor);

				$html.="<td class=\"$clav\">$nuevo_valor</td>";
			}
			$html.="</tr>";
		}
		$html.= "</tbody></table>";
		return $html;
	}



	public function generar_pdf( $lista, $TITULO="COBROS - " ){
			$html= $this->generar_html($lista , $TITULO);
			$tituloDocumento= $TITULO.(date("d")."-".date("m")."-".date("yy"))."-".rand();
			//echo $html;
			$pdf = new PDF();
			//$pdf = new PDF(); 
			$pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
			$pdf->generarHtml( $html);
			$pdf->generar();
	}


	public function test(){

		var_dump( $this->request->getPost("nome"));
	}
}
