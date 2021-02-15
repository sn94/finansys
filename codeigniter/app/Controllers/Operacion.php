<?php

namespace App\Controllers;

use App\Models\Cuotas_model;
use App\Models\Deudor_model;
use App\Models\Empresa_model;
use App\Models\Operacion_model;
use App\Models\Prestamo_model;
use Exception;

class Operacion extends BaseController
{

	//constructor
	public function __construct()
	{
	}


	public function index()
	{
		echo view("operacion/index");
	}






	public function create($IDCLIENTE = null)
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario
			$reg = new Operacion_model();
			$datos = $this->request->getPost();

			$db = \Config\Database::connect();
			$reg->insert($datos);
			return $this->response->setJSON(array("ok" => $db->insertID()));
			//return redirect()->to("index");
		} else {

			$CLIENTE =   (new Deudor_model())->find($IDCLIENTE);
			echo view('operacion/create',  ['CLIENTE' =>  $CLIENTE]);
		}
	}



	public function generar_vencimiento($ID_OPERACION =  NULL)
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario

			$datos = $this->request->getPost();


			$db = \Config\Database::connect();

			$db->transBegin();
			$db->transStart();
			$reg = new Operacion_model();
			$reg->update($datos['IDNRO'],  $datos);

			//Generar las cuotas 
			$DETALLE_ID = 1;
			$DETALLE_MONTO =  $datos['DETALLE_MONTO'];
			$DETALLE_VENCIMIENTO =  $datos['DETALLE_VENCIMIENTO'];
			for ($cuo = 0; $cuo <  sizeof($DETALLE_MONTO); $cuo++) {
				$nva_cuota = new Cuotas_model();
				$nva_cuota->insert([
					'OPERACION' => $datos['IDNRO'],
					'NUMERO' => $DETALLE_ID,
					'MONTO' => $DETALLE_MONTO[$cuo],
					'VENCIMIENTO' => $DETALLE_VENCIMIENTO[$cuo],
					'ESTADO' => "P"
				]);
				$DETALLE_ID++;
			}
			$db->transCommit();
			$db->transComplete();

			return $this->response->setJSON(array("ok" => $datos['IDNRO']));


			//return redirect()->to("index");
		} else {
			if (is_null($ID_OPERACION))
				echo view('operacion/vencimiento/index');
			else {
				$operacion = (new Operacion_model())
					->join("deudor", "deudor.IDNRO =  operacion.NRO_CLIENTE")
					->select("operacion.*, deudor.CEDULA, concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES")
					->where("operacion.IDNRO", $ID_OPERACION)->first();

				echo view('operacion/vencimiento/create', ['OPERACION' =>  $operacion]);
			}
		}
	}

	public function edit($id = NULL)
	{
		if ($this->request->getMethod() === 'post') {
			//Datos del formulario
			$reg = new Empresa_model();
			$datos =  $this->request->getPost();
			if ($reg->update($datos['IDNRO'], $datos))
				return redirect()->to("index");
			else
				echo view('plantillas/error', ['titulo' => "ERROR", 'mensaje' => "NO SE PUDO ACTUALIZAR"]);
		} else {
			// Create a shared instance of the model 
			$reg = new Empresa_model();
			$registro = $reg->find($id);
			echo view('empresa/edit', ['dato' => $registro]);
		}
	}


	public function view($id)
	{
		$reg = new Empresa_model();
		$registro = $reg->find($id);
		echo view("empresa/view", array("dato" => $registro, "vista" => true));
	}



	public function delete($id)
	{
		$reg = new Empresa_model();

		if ($reg->delete($id))
			echo json_encode(['id' => $id]);
		else
			echo json_encode(['error' => "ERROR AL BORRAR"]);
	}





	public function  list($IDCLIENTE = NULL)
	{
		//LETRA CORRE FACTURA RAZONS DEUDAT CREDITO

		//RECOGER PARAMETROS
		$CLIENTE = $IDCLIENTE;
		$OTROS_FILTROS = array_diff_key($this->request->getPost(), ['BUSCADO' => '']);


		$operac = (new Operacion_model());

		//jOIN CLIENTE
		$operac = $operac->join("deudor", "deudor.IDNRO = operacion.NRO_CLIENTE")
			->select("operacion.*, concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES");

		//FILTRO CLIENTE
		if (!is_null($CLIENTE))
			$operac =   $operac->where("NRO_CLIENTE", $IDCLIENTE);
		//Otros filtros
		if (sizeof($OTROS_FILTROS)  > 0)
			$operac =   $operac->where($OTROS_FILTROS);

		//busqueda LIKE %
		$FILTRO_NOMBRE =  $this->request->getPost("BUSCADO");
		if (!is_null($FILTRO_NOMBRE))
			$operac =   $operac->like('deudor.CEDULA', $FILTRO_NOMBRE)
				->orLike('deudor.NOMBRES', $FILTRO_NOMBRE)
				->orLike('deudor.APELLIDOS', $FILTRO_NOMBRE);


		//Formato de respuest
		$cabecera_formato = $this->request->getHeader("formato");
		$formato = is_null($cabecera_formato) ? "" :  $cabecera_formato->getValue();

		if ($formato == "json") {
			return $this->response->setJSON($operac->get()->getResult());
		}


		//Formato HTML
		$data = [
			'OPERACION' => $operac->paginate(10),
			'pager' => $operac->pager
		];
		if (is_null($CLIENTE)) {
			if ($this->request->isAJAX())
				return view("operacion/vencimiento/grill",  $data);
			else
				return view("operacion/vencimiento/index",  $data);
		} else
			return view("operacion/operaciones_cliente",  array_merge($data,  ['CLIENTE' =>   $CLIENTE]));
	}


	public function ver_vencimientos($ID_OPERACION =  NULL)
	{
		$cuotas = (new Cuotas_model())->where("OPERACION", $ID_OPERACION);
		$data = [
			"cuotas" =>   $cuotas->paginate(10),
			"pager" => $cuotas->pager,
			"OPERACION"=> (new Operacion_model())->find( $ID_OPERACION)
		];
		return view("operacion/cuotas/index",    $data);
	}
}
