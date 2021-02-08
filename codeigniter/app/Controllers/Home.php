<?php namespace App\Controllers;

use App\Models\Deudor_model;
use App\Models\Prestamo_model;

class Home extends BaseController
{
	public function index()
	{

	/*	//Calcular totales
		//total clientes
		$deu= new Deudor_model();
		$NumeroClientes= $deu->countAllResults();
		//Total SOLICITUDES DE CREDITO PENDIENTES
		$pres= new Prestamo_model();
		$NumeroPendientes= $pres->where("ESTADO", "P")->countAllResults();
		//TOTAL PRESTAMOS APROBADOS
		$NumeroAprobados= $pres->where("ESTADO", "A")->countAllResults();
		//TOTAL PRESTAMOS RECHAZADOS
		$NumeroRechazados= $pres->where("ESTADO", "R")->countAllResults();
		//TOTAL PRESTAMOS LIQUIDADOS
		$NumeroLiquidados= $pres->where("ESTADO", "L")->countAllResults();

		$request= \Config\Services::request();
		$uri= $request->uri; 

		return view('index', ['clientes'=>$NumeroClientes, 'pendientes'=>$NumeroPendientes,
		 'aprobados'=>$NumeroAprobados, 'rechazados'=>$NumeroRechazados, 'liquidados'=>$NumeroLiquidados]);
*/
		 return view('index');
	}

	//--------------------------------------------------------------------




	public function denegado(){
		return view('denegado');
	}







}
