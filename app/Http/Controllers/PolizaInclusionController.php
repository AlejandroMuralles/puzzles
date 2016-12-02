<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session, Variable;

use App\App\Entities\PolizaInclusion;
use App\App\Repositories\PolizaInclusionRepo;
use App\App\Managers\PolizaInclusionManager;

use App\App\Repositories\PolizaRepo;
use App\App\Repositories\VehiculoRepo;
use App\App\Repositories\PolizaVehiculoRepo;
use App\App\Repositories\PolizaCoberturaRepo;
use App\App\Repositories\PolizaCoberturaVehiculoRepo;

use App\App\Repositories\ImpuestoRepo;

use App\App\Repositories\PorcentajeFraccionamientoGeneralRepo;
use App\App\Repositories\PorcentajeFraccionamientoAseguradoraRepo;

class PolizaInclusionController extends BaseController {

	protected $polizaInclusionRepo;
	protected $polizaVehiculoRepo;
	protected $polizaCoberturaRepo;
	protected $polizaCoberturaVehiculoRepo;
	protected $vehiculoRepo;
	protected $polizaRepo;
	protected $impuestoRepo;
	protected $pfgRepo;
	protected $pfaRepo;

	public function __construct(PolizaInclusionRepo $polizaInclusionRepo, PolizavehiculoRepo $polizaVehiculoRepo, PolizaCoberturaRepo $polizaCoberturaRepo,PolizaCoberturaVehiculoRepo $polizaCoberturaVehiculoRepo, PolizaRepo $polizaRepo, ImpuestoRepo $impuestoRepo, VehiculoRepo $vehiculoRepo, PorcentajeFraccionamientoGeneralRepo $pfgRepo, PorcentajeFraccionamientoAseguradoraRepo $pfaRepo)
	{
		$this->polizaInclusionRepo = $polizaInclusionRepo;
		$this->polizaVehiculoRepo = $polizaVehiculoRepo; 
		$this->polizaCoberturaRepo = $polizaCoberturaRepo; 
		$this->polizaCoberturaVehiculoRepo = $polizaCoberturaVehiculoRepo;
		$this->vehiculoRepo = $vehiculoRepo;
		$this->polizaRepo = $polizaRepo;
		$this->impuestoRepo = $impuestoRepo;
		$this->pfgRepo = $pfgRepo;
		$this->pfaRepo = $pfaRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function agregar($polizaId)
	{
		$data = Input::all();
		$data['poliza_id'] = $polizaId;
		$data['estado'] = 'S';
		$data['fecha_solicitud'] = date('Y-m-d H:i:s');
		$manager = new PolizaInclusionManager(new PolizaInclusion(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la solicitud de inclusión con éxito.');
		$url = route('ver_poliza',$polizaId) . '#inclusiones';
		return Redirect::to($url);
	}

	public function mostrarVer($polizaInclusionId){
		$polizaInclusion = $this->polizaInclusionRepo->find($polizaInclusionId);
		$vehiculos = $this->polizaVehiculoRepo->getByInclusion($polizaInclusion->id);
		$coberturas = $this->polizaCoberturaRepo->getByInclusion($polizaInclusion->id);
		$coberturasParticulares = $this->polizaCoberturaVehiculoRepo->getByInclusion($polizaInclusion->id);
		return View::make('administracion/poliza_inclusiones/ver', compact('polizaInclusion','vehiculos','coberturas','coberturasParticulares'));
	}

	public function mostrarAgregarVehiculo($polizaInclusionId){
		$polizaInclusion = $this->polizaInclusionRepo->find($polizaInclusionId);
		$vehiculos = $this->polizaVehiculoRepo->getVehiculosNotInPoliza($polizaInclusion->poliza_id)->lists('placa','id')->toArray();
		return View::make('administracion/poliza_inclusiones/agregar_vehiculo', compact('polizaInclusion','vehiculos'));
	}

	public function agregarVehiculo($polizaInclusionId)
	{
		$polizaInclusion = $this->polizaInclusionRepo->find($polizaInclusionId);
		$data = Input::all();
		$data['suma_asegurada'] = round($data['suma_asegurada'],2);
		$data['suma_asegurada_blindaje'] = round($data['suma_asegurada_blindaje'],2);
		$data['prima_neta'] = round($data['prima_neta'],2);

		$prima_neta = $data['prima_neta'];

		$pct_fraccionamiento = $polizaInclusion->poliza->pct_fraccionamiento;
		$pct_emision = $polizaInclusion->poliza->pct_emision;
		$pct_iva =  $polizaInclusion->poliza->pct_iva;

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
		$data['poliza_id'] = $polizaInclusion->poliza_id;
		$data['estado'] = 'P';
		$data['fecha_inclusion'] = date('Y-m-d H:i:s');
		$data['poliza_inclusion_id'] = $polizaInclusionId;


		$manager = new PolizaInclusionManager(null, $data);
		$manager->agregarVehiculo($polizaInclusionId);
		Session::flash('success', 'Se agregó el vehículo a la solicitud de inclusión con éxito.');
		$url = route('ver_poliza',$polizaInclusion->poliza_id) . '#inclusiones';
		return Redirect::to($url);
	}

	public function mostrarAgregarCobertura($polizaInclusionId){
		$polizaInclusion = $this->polizaInclusionRepo->find($polizaInclusionId);
		$coberturas = $this->polizaCoberturaRepo->getCoberturasNotInPoliza($polizaInclusion->poliza_id)->lists('nombre','id')->toArray();
		return View::make('administracion/poliza_inclusiones/agregar_cobertura', compact('polizaInclusion','coberturas'));
	}

	public function agregarCobertura($polizaInclusionId)
	{
		$polizaInclusion = $this->polizaInclusionRepo->find($polizaInclusionId);
		$data = Input::all();
		$data['suma_asegurada'] = round($data['suma_asegurada'],2);
		$data['poliza_id'] = $polizaInclusion->poliza_id;
		$data['estado'] = 'P';
		$data['fecha_inclusion'] = date('Y-m-d H:i:s');
		$data['poliza_inclusion_id'] = $polizaInclusionId;
		$manager = new PolizaInclusionManager(null, $data);
		$manager->agregarCobertura($polizaInclusionId);
		Session::flash('success', 'Se agregó la cobertura a la solicitud de inclusión con éxito.');
		$url = route('ver_poliza',$polizaInclusion->poliza_id) . '#inclusiones';
		return Redirect::to($url);
	}


	public function mostrarAgregarCoberturaVehiculo($polizaInclusionId, $vehiculoId)
	{
		$polizaInclusion = $this->polizaInclusionRepo->find($polizaInclusionId);
		$vehiculos = $this->polizaVehiculoRepo->getByPolizaByEstado($polizaInclusion->poliza_id, ['V','P'])->lists('vehiculo.placa','id')->toArray();
		$coberturas = $this->polizaCoberturaRepo->getCoberturasNotInPoliza($polizaInclusion->poliza_id)->lists('nombre','id')->toArray();
		return View::make('administracion/poliza_inclusiones/agregar_cobertura_vehiculo', compact('polizaInclusion','vehiculoId','vehiculos','coberturas'));		
	}

	public function agregarCoberturaVehiculo($polizaInclusionId, $vehiculoId)
	{
		$data = Input::all();
		$polizaInclusion = $this->polizaInclusionRepo->find($polizaInclusionId);
		$polizaVehiculo = $this->polizaVehiculoRepo->find($data['vehiculo_id']);
		$data['vehiculo_id'] = $polizaVehiculo->vehiculo_id;
		$data['poliza_vehiculo_id'] = $polizaVehiculo->id;
		$data['poliza_id'] = $polizaInclusion->poliza_id;
		$data['poliza_inclusion_id'] = $polizaInclusion->id;
		$data['fecha_inclusion'] = date('Y-m-d H:i:s');
		$data['estado'] = 'P';
		$manager = new PolizaInclusionManager(null, $data);
		$manager->agregarCoberturaVehiculo($polizaInclusionId);
		Session::flash('success', 'Se agregó la cobertura particular a la solicitud de inclusión con éxito.');
		$url = route('ver_poliza',$polizaInclusion->poliza_id) . '#inclusiones';
		return Redirect::to($url);
	}

	public function mostrarAprobarSolicitud($inclusionId)
	{
		$inclusion = $this->polizaInclusionRepo->find($inclusionId);

		if($inclusion->estado != 'S')
		{
			Session::flash('error', 'La solicitud de inclusión ya fue procesada. Estado actual: ' . $inclusion->descripcion_estado);
			return Redirect::route('ver_poliza',$inclusion->poliza_id);
		}
		return View::make('administracion/poliza_inclusiones/aprobar_solicitud', compact('inclusion'));
	}

	public function aprobarSolicitud($inclusionId)
	{
		$inclusion = $this->polizaInclusionRepo->find($inclusionId);

		if($inclusion->estado != 'S')
		{
			Session::flash('error', 'La solicitud de inclusión ya fue procesada. Estado actual: ' . $inclusion->descripcion_estado);
			return Redirect::route('ver_poliza',$inclusion->poliza_id);
		}
		$inclusion->estado = 'V';
		$inclusion->fecha_aprobada = date('Y-m-d H:i:s');
		$vehiculos = $this->polizaVehiculoRepo->getByInclusion($inclusionId);
		$coberturasGenerales = $this->polizaCoberturaRepo->getByInclusion($inclusionId);
		$coberturasParticulares = $this->polizaCoberturaVehiculoRepo->getByInclusion($inclusionId);;
		$manager = new PolizaInclusionManager($inclusion, Input::all());
		$manager->aprobarSolicitud($vehiculos, $coberturasGenerales, $coberturasParticulares);
		Session::flash('success', 'Se aprobó la inclusion con éxito.');
		$url = route('ver_poliza',$inclusion->poliza_id) . '#inclusiones';
		return Redirect::to($url);
	}
}

