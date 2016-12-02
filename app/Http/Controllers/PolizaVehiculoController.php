<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session, Variable;

use App\App\Entities\PolizaVehiculo;
use App\App\Repositories\PolizaVehiculoRepo;
use App\App\Managers\PolizaVehiculoManager;

use App\App\Repositories\PolizaRepo;
use App\App\Repositories\VehiculoRepo;
use App\App\Repositories\PolizaCoberturaVehiculoRepo;

use App\App\Repositories\ImpuestoRepo;

use App\App\Repositories\PorcentajeFraccionamientoGeneralRepo;
use App\App\Repositories\PorcentajeFraccionamientoAseguradoraRepo;

class PolizaVehiculoController extends BaseController {

	protected $polizaVehiculoRepo;
	protected $polizaCoberturaVehiculoRepo;
	protected $vehiculoRepo;
	protected $polizaRepo;
	protected $impuestoRepo;
	protected $pfgRepo;
	protected $pfaRepo;

	public function __construct(PolizaVehiculoRepo $polizaVehiculoRepo, PolizaCoberturaVehiculoRepo $polizaCoberturaVehiculoRepo, PolizaRepo $polizaRepo, ImpuestoRepo $impuestoRepo, VehiculoRepo $vehiculoRepo,
		PorcentajeFraccionamientoGeneralRepo $pfgRepo,
		PorcentajeFraccionamientoAseguradoraRepo $pfaRepo)
	{
		$this->polizaVehiculoRepo = $polizaVehiculoRepo;
		$this->polizaCoberturaVehiculoRepo = $polizaCoberturaVehiculoRepo;
		$this->vehiculoRepo = $vehiculoRepo;
		$this->polizaRepo = $polizaRepo;
		$this->impuestoRepo = $impuestoRepo;
		$this->pfgRepo = $pfgRepo;
		$this->pfaRepo = $pfaRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function mostrarAgregar($polizaId){
		$poliza = $this->polizaRepo->find($polizaId);
		$vehiculos = $this->polizaVehiculoRepo->getVehiculosNotInPoliza($polizaId)->lists('placa','id')->toArray();
		return View::make('administracion/poliza_vehiculos/agregar', compact('poliza','vehiculos'));
	}

	public function agregar($polizaId)
	{
		$poliza = $this->polizaRepo->find($polizaId);
		$data = Input::all();
		$data['estado'] = 'P';
		$data['fecha_inclusion'] = date('Y-m-d H:i:s');
		$data['suma_asegurada'] = round($data['suma_asegurada'],2);
		$data['suma_asegurada_blindaje'] = round($data['suma_asegurada_blindaje'],2);
		$data['prima_neta'] = round($data['prima_neta'],2);

		$prima_neta = $data['prima_neta'];

		$pct_fraccionamiento = $poliza->pct_fraccionamiento;
		$pct_emision = $poliza->pct_emision;
		$pct_iva =  $poliza->pct_iva;

		$fraccionamiento = round($prima_neta*$pct_fraccionamiento,2);
		$emision = round($prima_neta * $pct_emision,2);
		$iva = round(($prima_neta + $fraccionamiento + $emision) * $pct_iva,2);
		$prima_total = round($prima_neta + $emision + $fraccionamiento + $iva,2);

		$data['pct_fraccionamiento'] = $pct_fraccionamiento;
		$data['fraccionamiento'] = $fraccionamiento;
		$data['pct_emision'] = $pct_emision;
		$data['emision'] = $emision;
		$data['pct_iva'] = $pct_iva;
		$data['iva'] = $iva;	
		
		$data['prima_total'] = $prima_total;
		$data['poliza_id'] = $polizaId;
		//dd($data);



		$manager = new PolizaVehiculoManager(new PolizaVehiculo(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el vehiculo con éxito.');
		$url = route('ver_solicitud_poliza',$polizaId) . '#coberturas_particulares';
		return Redirect::to($url);
	}

	public function mostrarEditar($id){
		$vehiculo = $this->polizaVehiculoRepo->find($id);
		return View::make('administracion/poliza_vehiculos/editar', compact('vehiculo'));
	}

	public function editar($id)
	{
		$vehiculo = $this->polizaVehiculoRepo->find($id);
		$poliza = $this->polizaRepo->find($vehiculo->poliza_id);
		$data = Input::all();
		$data['estado'] = $vehiculo->estado;
		$data['vehiculo_id'] = $vehiculo->vehiculo_id;
		$data['fecha_inclusion'] = $vehiculo->fecha_inclusion;
		$data['suma_asegurada'] = round($data['suma_asegurada'],2);
		$data['suma_asegurada_blindaje'] = round($data['suma_asegurada_blindaje'],2);
		$data['prima_neta'] = round($data['prima_neta'],2);

		$prima_neta = $data['prima_neta'];

		$pct_fraccionamiento = $poliza->pct_fraccionamiento;
		$pct_emision = $poliza->pct_emision;
		$pct_iva =  $poliza->pct_iva;

		$fraccionamiento = round($prima_neta*$pct_fraccionamiento,2);
		$emision = round($prima_neta * $pct_emision,2);
		$iva = round(($prima_neta + $fraccionamiento + $emision) * $pct_iva,2);
		$prima_total = round($prima_neta + $emision + $fraccionamiento + $iva,2);

		$data['pct_fraccionamiento'] = $pct_fraccionamiento;
		$data['fraccionamiento'] = $fraccionamiento;
		$data['pct_emision'] = $pct_emision;
		$data['emision'] = $emision;
		$data['pct_iva'] = $pct_iva;
		$data['iva'] = $iva;	
		
		$data['prima_total'] = $prima_total;
		$data['poliza_id'] = $vehiculo->poliza_id;
		$manager = new PolizaVehiculoManager($vehiculo, $data);
		$manager->save();
		Session::flash('success', 'Se editó el vehiculo con éxito.');
		$url = route('ver_solicitud_poliza',$vehiculo->poliza_id) . '#coberturas_particulares';
		return Redirect::to($url);
	}

	public function eliminar()
	{
		$id = Input::get('poliza_vehiculo_id');
		$vehiculo = $this->polizaVehiculoRepo->find($id);
		$coberturasVehiculo = $this->polizaCoberturaVehiculoRepo->getByPolizaVehiculo($id);
		$manager = new PolizaVehiculoManager($vehiculo, Input::all());
		$manager->eliminar($vehiculo, $coberturasVehiculo);
		Session::flash('success', 'Se eliminó el vehiculo con éxito.');
		$url = route('ver_solicitud_poliza',$vehiculo->poliza_id) . '#coberturas_particulares';
		return Redirect::to($url);
	}
	
	public function mostrarEditarCertificado($id){
		$vehiculo = $this->polizaVehiculoRepo->find($id);
		return View::make('administracion/poliza_vehiculos/editar_certificado', compact('vehiculo'));
	}

	public function editarCertificado($id)
	{
		$vehiculo = $this->polizaVehiculoRepo->find($id);
		$manager = new PolizaVehiculoManager($vehiculo, Input::all());
		$manager->editarCertificado();
		Session::flash('success', 'Se editó el certificado del vehiculo con éxito.');
		$url = route('ver_poliza',$vehiculo->poliza_id) . '#vehiculos';
		return Redirect::to($url);
	}

	public function mostrarVer($id)
	{
		$vehiculo = $this->polizaVehiculoRepo->find($id);
		$coberturas = $this->polizaCoberturaVehiculoRepo->getByPolizaVehiculo($id);
		return View::make('administracion/poliza_vehiculos/ver', compact('vehiculo','coberturas'));
	}

	public function mostrarBuscar()
	{
		$vehiculo = null;
		return View::make('administracion/poliza_vehiculos/buscar', compact('vehiculo'));
	}

	public function buscar()
	{
		$placa = Input::get('placa');
		$vehiculo = $this->vehiculoRepo->getByPlaca($placa);
		$polizas = [];
		if(!is_null($vehiculo))
			$polizas = $this->polizaVehiculoRepo->getByVehiculo($vehiculo->id);
		return View::make('administracion/poliza_vehiculos/buscar', compact('vehiculo','polizas'));
	}
}
