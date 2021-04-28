<?php

namespace App\Controllers;

use App\Models\Cobro_model;
use App\Models\Cuotas_model;
use App\Models\Detalle_cobro_model;
use App\Models\Deudor_model;
use App\Models\Empresa_model;
use App\Models\Letras_model;
use App\Models\Operacion_model;
use App\Models\Prestamo_model;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Exception;

class Vencimientos extends BaseController
{

	//constructor
	public function __construct()
	{
	}




	//Vista de operaciones procesadas, con cuotas generadas
	public function index()
	{
		$BUSCADO = "";
		if ($this->request->getMethod(TRUE) == "POST") {
			$DATOS =  $this->request->getJSON(TRUE);
			$BUSCADO = $DATOS['BUSCADO'];
		}

		 
		$operaciones =  (new Operacion_model())
			->join("deudor", "deudor.IDNRO =  operacion.NRO_CLIENTE")
			->where("operacion.ESTADO", "APROBADO");
			if(  $BUSCADO != "")
			$operaciones= $operaciones
			->groupStart()
			->like("deudor.CEDULA", "$BUSCADO")
			->orLike("CONCAT(operacion.LETRA,operacion.CORRELATIVO)", "$BUSCADO")
			->orLike("deudor.NOMBRES", "$BUSCADO")
			->groupEnd();
			$operaciones= $operaciones
			->select("operacion.*, deudor.CEDULA, concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES")
			->orderBy("created_at", "DESC");
 
		$data = [
			"OPERACION" =>   $operaciones->paginate(10),
			"pager" => $operaciones->pager
		];

		if ($this->request->isAJAX())
			echo view("vencimientos/index/grill/index",  $data); //boton cobrar  boton ver cuotas
		else
			echo view("vencimientos/index/index",  $data);
	}













	public function cuotas($ID_OPERACION =  NULL)
	{
		$cuotas = (new Cuotas_model())->where("OPERACION", $ID_OPERACION)
			->select("operacion_cuotas.*,
			(SELECT  FORMAT( SUM(operacion_cuotas.MONTO),0, 'de_DE' ) FROM operacion_cuotas where OPERACION=$ID_OPERACION) as TOTAL_MONTO_CUOTA,
			  FORMAT( operacion_cuotas.MONTO, 0,  'de_DE') as MONTO,  
		DATE_FORMAT( VENCIMIENTO, '%d/%m/%Y') AS VENCIMIENTO, 
IF( DATEDIFF(VENCIMIENTO,  CURRENT_DATE)<0, ABS(DATEDIFF(VENCIMIENTO,  CURRENT_DATE)), 0) AS ATRASO,
if( FECHA_PAGO IS NULL, '', DATE_FORMAT( FECHA_PAGO,  '%d/%m/%Y' )   ) AS FECHA_PAGO
");

		if ($this->getRequestContentType() ==  "json")
			return $this->response->setJSON($cuotas->get()->getResult());

		if ($this->getRequestContentType() ==  "html") {

			$data = [
				"cuotas" =>   $cuotas->paginate(25),
				"pager" => $cuotas->pager,
				"OPERACION" => (new Operacion_model())->find($ID_OPERACION)
			];
			if ($this->request->isAJAX())
				return view("vencimientos/cuotas/grill",    $data);
			else
				return view("vencimientos/cuotas/index",    $data);
		}
	}
}
