<?php

namespace App\Controllers;

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


	public function index($FORMATODEFAULT =  "html")
	{
		//$pager = \Config\Services::pager();
		$Deudor = new Deudor_model();

		$cabecera_formato = $this->request->getHeader("formato");
		$formato = is_null($cabecera_formato) ? "" :  $cabecera_formato->getValue();

		if ($formato == "json") {
			return $this->response->setJSON($Deudor->get()->getResult());
		}
		//Caso contrario Se solicito HTML
		try {

			/**Parametros post  */
			$BUSCADO =  is_null($this->request->getPost("BUSCADO")) ? "" : $this->request->getPost("BUSCADO");
			$LIMITE =   is_null($this->request->getPost("LIMITE")) ? "" :  $this->request->getPost("LIMITE");

			$lista = (new Deudor_model())
				->select(" deudor.IDNRO, deudor.CEDULA,concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES, deudor.TELEFONO, DATE(deudor.updated_at) as ULT_ACT,
			IF((select FECHA_SOLICI from prestamo order by created_at limit 1) IS NULL, '', (select DATE(FECHA_SOLICI )from prestamo order by created_at limit 1) ) AS FECHA_SOLICI,
			IF((select TIPO_CREDITO from prestamo order by created_at limit 1) IS NULL, '', (select TIPO_CREDITO from prestamo order by created_at limit 1) ) AS TIPO_CREDITO
			  ")
				->like('deudor.CEDULA', $BUSCADO)
				->orLike('deudor.NOMBRES', $BUSCADO)
				->orLike('deudor.APELLIDOS', $BUSCADO);

			if ($LIMITE != "")  $lista =  $lista->limit($LIMITE);
			$lista = $lista->groupBy("deudor.updated_at", "DESC");
			$resultado = null;
			//paginar
			$data = [];
			if ($formato ==  "json"  ||  $formato == "pdf") {
				$resultado = $lista->get()->getResultObject();
				$data = [
					'lista' => $resultado
				];
			} else {
				$resultado =  $lista->paginate(10);
				$data = [
					'lista' => $resultado,
					'pager' =>  $lista->pager
				];
			}




			$formato = $this->request->getHeader("formato");
			$formato =  is_null($formato)  ?  $FORMATODEFAULT :  $formato->getValue();
			if ($formato == "json")
				return $this->response->setJSON($resultado);
			if ($formato == "pdf") {
				$html = $this->generar_html($resultado);
				$tituloDocumento = "clientes-" . date("d") . "-" . date("m") . "-" . date("yy") . "-" . rand();
				//echo $html;
				$pdf = new PDF();
				//$pdf = new PDF(); 
				$pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, "");
				$pdf->generarHtml($html);
				$pdf->generar();
			}


			if ($this->request->isAJAX())
				echo view("deudor/index/grill/index",  $data);
			else
				echo view("deudor/index/index",  $data);
		} catch (\Exception $e) { //mostrar mensaje de error
			//mostrar mensaje de operacion exitosa
			die($e->getMessage());
		}
	}






	public function get_empty_view($tipo)
	{
		if ($tipo == "F") {
			return view("deudor/persona_fisica");
		} else 	return view("deudor/persona_juridica");
	}





	public function existeCliente($identi)
	{
		$funcio = new Deudor_model();
		$registro = $funcio->where('CEDULA',  $identi)
			->first();
		return !is_null($registro);
	}


	public  function get($id =  null)
	{
		// Create a shared instance of the model
		$funcio = new Deudor_model();
		$registro = $funcio->find($id);

		//Definir formato de los datos 
		$cabecera_formato = $this->request->getHeader("formato");
		$formato = is_null($cabecera_formato) ? "" :  $cabecera_formato->getValue();

		if ($formato ==  "json")
			return $this->response->setJSON($registro);
		else {

			if ($this->request->isAJAX()) {
				if (is_null($registro))
					echo view("deudor/forms/form", ["OPERACION" => "V", "ADICIONAL" => "CI°/RUC NO REGISTRADO"]);
				else {
					//html-v vista    o      html-m edicion
					echo view("deudor/forms/form", array("deudor_dato" => $registro, "OPERACION" => "V"));
				}
			} else {
				if (is_null($registro))
					echo view("deudor/view", ["OPERACION" => "V", "ADICIONAL" => "CI°/RUC NO REGISTRADO"]);
				else
					echo view("deudor/view", array("deudor_dato" => $registro, "OPERACION" => "V"));
			}
		}
	}


	private function gestionar_fotos()
	{
		/*********** FOTO  *********************/
		$datos = $this->request->getPost();
		$FOTO_ = $this->request->getFile('CEDU_ANVERSO');
		$FOTO2_ = $this->request->getFile('CEDU_REVERSO');
		if ($FOTO_->getPath() !=  "") { //Solo si se ha proporcionado foto
			//Borrar archivo anterior
			$deudo_reg = new Deudor_model();
			$REG = $deudo_reg->find($this->request->getPost("IDNRO"));
			try {
				$path_delete =  $REG->CEDU_ANVERSO;
				if ($path_delete != "") unlink(substr($path_delete, 1));
			} catch (Exception $e) {
			}
			//fin borrado

			/** Substituir fotos */
			$Extension = $FOTO_->getClientExtension();
			if ($FOTO_->isValid() &&  !$FOTO_->hasMoved()) {
				$NombreFoto = $this->request->getPost("CEDULA") . "-ANVERSO-" . date("j-m-Y") . ".$Extension";
				$datos['CEDU_ANVERSO'] = "/deudores/$NombreFoto";
				$FOTO_->move('deudores', $NombreFoto);
			} // End reemplazo
		}


		if ($FOTO2_->getPath() !=  "") { //Solo si se ha proporcionado foto
			//Borrar archivo anterior SEGUNDO
			try {
				$path_delete2 = !is_null($REG) ? $REG->CEDU_REVERSO : "";
				if ($path_delete2 != "") unlink(substr($path_delete2, 1));
			} catch (Exception $e) {
			}
			//fin borrado 2
			$Extension2 = $FOTO2_->getClientExtension();
			if ($FOTO2_->isValid() &&  !$FOTO2_->hasMoved()) {
				$NombreFoto2 = $this->request->getPost("CEDULA") . "-REVERSO-" . date("j-m-Y") . ".$Extension2";
				$datos['CEDU_REVERSO'] = "/deudores/$NombreFoto2";
				$FOTO2_->move('deudores', $NombreFoto2);
			} // End reemplazo
		}
		return $datos;
	}


	public function create()
	{
		$model = new Deudor_model();

		if ($this->request->getMethod() === 'post') {
			//Datos del formulario
			//Verificar redundacia de CI O RUC
			$datos = $this->request->getPost();

			//Validacion de Numero de cedula
			if (array_key_exists("CEDULA",    $datos)) {
				$identificador =   $datos['CEDULA'];
				if ($this->existeCliente($identificador)) { //existe CI o RUC 
					$test_redun =  (new Deudor_model())->where("CEDULA", $identificador)->first();
					if ($datos['CEDULA'] == $test_redun->CEDULA  && $datos['IDNRO']  ==  "")
						return $this->response->setJSON(array("error" => "EL NUMERO DE(CEDULA|RUC) --> $identificador ya existe"));
				}
			}



			//insert o update
			if ($datos['IDNRO']  !=  "") {
				$model->update($datos['IDNRO'],    $datos);
				return $this->response->setJSON(array("ok" => $datos['IDNRO']));
			} else {
				$db = \Config\Database::connect();
				$model->save($datos);
				return $this->response->setJSON(array("ok" => $db->insertID()));
			}
		} else {
			helper("form");
			if ($this->request->isAJAX())
				echo view('deudor/forms/form',  ['OPERACION' => "A"]);
			else
				echo view('deudor/create', ['OPERACION' => "A"]);
		}
	}





	public  function  edit($id = null)
	{
		$deudor = (new Deudor_model())->find($id);
		if (is_null($deudor))
			echo "CLIENTE CON ID  $id NO EXISTE";

		$parametros =  ['deudor_dato' =>   $deudor];
		//Datos de la ultima solicitud
		$solicitudes = (new Prestamo_model())->where("DEUDOR",   $id)->orderBy("created_at", "DESC")->first();
		if (!is_null($solicitudes))
			$parametros = array_merge($parametros,  ['prestamo_dato' =>  $solicitudes]);

		echo view('deudor/create',   $parametros);
	}




	public function delete($id)
	{
		$funcio = new Deudor_model();

		$db = \Config\Database::connect();
		$db->transStart();

		$funcio->delete($id); //borrar ficha
		(new Prestamo_model())->where("DEUDOR", $id)->delete(); //borrar solicitudes

		$db->transComplete();
		if ($db->transStatus())
			return $this->response->setJSON(['id' => $id]);
		else
			return $this->response->setJSON(['error' => "No se pudo borrar"]);
	}



	//Informacion de saldos
	//Estado de cuenta del cliente
	public function calc_sumas_saldos($idcliente)
	{
		$db = \Config\Database::connect();
		$data = $db->table("prestamo")

			->join("deudor", "deudor.IDNRO=prestamo.DEUDOR")
			->join("categoria_monto", "categoria_monto.IDNRO=prestamo.CAT_MONTO")
			->select("deudor.IDNRO, if(deudor.TIPO_PERSONA='F', CEDULA, RUC) AS CI_RUC, concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES, categoria_monto.MONTO AS DEUDA_TOTAL, categoria_monto.NRO_CUOTAS,
		(select count(*) from cuotas_prestamo where cuotas_prestamo.IDPRESTAMO=prestamo.IDNRO and cuotas_prestamo.ESTADO='C') as PAGADAS,
		(select count(*) from cuotas_prestamo where cuotas_prestamo.IDPRESTAMO=prestamo.IDNRO and cuotas_prestamo.ESTADO='P') as PENDIENTES")
			->where("prestamo.DEUDOR", $idcliente)
			->get()->getRowArray();
		return  $data;
	}

	public function  sumas_saldos($idcliente)
	{
		$data =  $this->calc_sumas_saldos($idcliente);
		if ($this->request->isAJAX())
			return view("deudor/sumas_saldos_ajax", $data);
		else
			return view("deudor/sumas_saldos", $data);
	}


	//nUMERO DE CREDITOS REALIZADOS A NOMBRE DE CIERTO CLIENTE
	public function num_credi_reg()
	{
		$prestamo = new Deudor_model;
		$DATOS = $prestamo->info_creditos_de_deudores();
		foreach ($DATOS as $T) {
			echo $T->creditos;
		}
	}


	public function buscar_por_palabra()
	{

		if ($this->request->getMethod(false) == "post") {

			$param = $this->request->getJSON();
			$buscame = $param->buscado;
			$deudor =  new Deudor_model();
			$resultado = $deudor->like("CEDULA", $buscame)
				->select("IDNRO, IF(RUC is null, CEDULA , RUC) AS ID, CONCAT(NOMBRES,CONCAT(' ',APELLIDOS)) as NOMBRES")
				->orLike('RUC', $buscame)
				->orLike("CONCAT(NOMBRES,CONCAT(' ',APELLIDOS))", $buscame)
				->orLike('NOMBRES', $buscame)
				->get()->getResultObject();
			echo json_encode($resultado);
		} else {
			echo view("deudor/buscador", ['lista' =>  []]);
		}
	}
	public function list($tipo)
	{
		$Deudor = new Deudor_model();
		$lista = $Deudor->info_creditos_de_deudores(); //recoge todas las filas
		if ($tipo == "json")
			echo json_encode($lista);
		else {
			$html = $this->generar_html($lista);
			$tituloDocumento = "clientes-" . date("d") . "-" . date("m") . "-" . date("yy") . "-" . rand();
			//echo $html;
			$pdf = new PDF();
			//$pdf = new PDF(); 
			$pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, "");
			$pdf->generarHtml($html);
			$pdf->generar();
		}
	}


	public function generar_html($lista)
	{
		$html = <<<EOF
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
		foreach ($lista as $ite) {
			$html .= "<tr class=\"cabecera\">";
			foreach ($ite as  $clave => $valor) {
				if ($clave == "IDNRO") continue;
				if ($clave == "TELEFONO") continue;
				$clav = strtolower($clave);
				$th = $clave;
				if ($clav == "CEDULA")  $th = "CI°/RUC";
				if ($clav == "NOMBRES")  $th = "NOMBRES/RAZÓN SOCIAL";
				$html .= "<th class=\"$clav\">$th</th>";
			}
			$html .= "</tr></thead><tbody>";
			break;
		}

		foreach ($lista as $ite) {
			$html .= "<tr class=\"cuerpo\">";
			foreach ($ite as  $clave => $valor) {
				if ($clave == "IDNRO") continue;
				if ($clave == "TELEFONO") continue;
				$clav = strtolower($clave);
				$html .= "<td class=\"$clav\">$valor</td>";
			}
			$html .= "</tr>";
		}
		$html .= "</tbody></table>";
		return  $html;
	}
}
