<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session, Variable;

use App\App\Entities\PolizaExclusion;
use App\App\Repositories\PolizaExclusionRepo;
use App\App\Managers\PolizaExclusionManager;

use App\App\Repositories\PolizaRepo;
use App\App\Repositories\PolizaVehiculoRepo;
use App\App\Repositories\PolizaCoberturaRepo;
use App\App\Repositories\PolizaCoberturaVehiculoRepo;

class PolizaExclusionController extends BaseController {

	protected $polizaExclusionRepo;
	protected $polizaVehiculoRepo;
	protected $polizaCoberturaRepo;
	protected $polizaCoberturaVehiculoRepo;
	protected $polizaRepo;
	protected $impuestoRepo;
	protected $pfgRepo;
	protected $pfaRepo;

	public function __construct(PolizaExclusionRepo $polizaExclusionRepo, PolizaRepo $polizaRepo, PolizaVehiculoRepo $polizaVehiculoRepo, PolizaCoberturaRepo $polizaCoberturaRepo, PolizaCoberturaVehiculoRepo $polizaCoberturaVehiculoRepo)
	{
		$this->polizaExclusionRepo = $polizaExclusionRepo;
		$this->polizaVehiculoRepo = $polizaVehiculoRepo;
		$this->polizaCoberturaRepo = $polizaCoberturaRepo;
		$this->polizaCoberturaVehiculoRepo = $polizaCoberturaVehiculoRepo;
		$this->polizaRepo = $polizaRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function agregar($polizaId)
	{
		$data = Input::all();
		$data['poliza_id'] = $polizaId;
		$data['estado'] = 'S';
		$data['fecha_solicitud'] = date('Y-m-d H:i:s');
		$manager = new PolizaExclusionManager(new PolizaExclusion(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la solicitud de exclusion con éxito.');
		$url = route('ver_poliza',$polizaId) . '#exclusiones';
		return Redirect::to($url);
	}

	public function mostrarVer($polizaExclusionId){
		$polizaExclusion = $this->polizaExclusionRepo->find($polizaExclusionId);
		$vehiculos = $this->polizaVehiculoRepo->getByExclusion($polizaExclusion->id);
		$coberturas = $this->polizaCoberturaRepo->getByExclusion($polizaExclusion->id);
		$coberturasParticulares = $this->polizaCoberturaVehiculoRepo->getByExclusion($polizaExclusion->id);
		return View::make('administracion/poliza_exclusiones/ver', compact('polizaExclusion','vehiculos','coberturas','coberturasParticulares'));
	}

	public function mostrarAgregarVehiculo($polizaExclusionId){
		$polizaExclusion = $this->polizaExclusionRepo->find($polizaExclusionId);
		$vehiculos = $this->polizaVehiculoRepo->getByPolizaByEstado($polizaExclusion->poliza_id, ['V'])->lists('vehiculo.placa','id')->toArray();
		return View::make('administracion/poliza_exclusiones/agregar_vehiculo', compact('polizaExclusion','vehiculos'));
	}

	public function agregarVehiculo($polizaExclusionId)
	{
		$polizaExclusion = $this->polizaExclusionRepo->find($polizaExclusionId);
		$data = Input::all();
		$vehiculo = $this->polizaVehiculoRepo->find($data['vehiculo_id']);
		$coberturasVehiculo = $this->polizaCoberturaVehiculoRepo->getCoberturasByPolizaByVehiculoByEstado($polizaExclusion->poliza_id, $vehiculo->vehiculo->id, ['V']);
		$manager = new PolizaExclusionManager(null, null);
		$manager->agregarVehiculo($polizaExclusionId, $vehiculo, $coberturasVehiculo);
		Session::flash('success', 'Se agregó el vehiculo a la solicitud de exclusion con éxito.');
		$url = route('ver_poliza',$polizaExclusion->poliza_id) . '#exclusiones';
		return Redirect::to($url);
	}

	public function eliminarVehiculo($polizaExclusionId)
	{
		$polizaExclusion = $this->polizaExclusionRepo->find($polizaExclusionId);
		$data = Input::all();
		$vehiculo = $this->polizaVehiculoRepo->find($data['vehiculo_id']);
		$coberturasVehiculo = $this->polizaCoberturaVehiculoRepo->getByExclusionByVehiculoByEstado($polizaExclusion->id, $vehiculo->vehiculo->id,['SE']);
		$manager = new PolizaExclusionManager(null, null);
		$manager->eliminarVehiculo($polizaExclusionId, $vehiculo, $coberturasVehiculo);
		Session::flash('success', 'Se eliminó el vehiculo de la solicitud de exclusión con éxito.');
		return Redirect::route('ver_poliza_exclusion',$polizaExclusion->id);
	}

	public function mostrarAgregarCobertura($polizaExclusionId){
		$polizaExclusion = $this->polizaExclusionRepo->find($polizaExclusionId);
		$coberturas = $this->polizaCoberturaRepo->getByPolizaByEstado($polizaExclusion->poliza_id, ['V'])->lists('cobertura.nombre','id')->toArray();
		return View::make('administracion/poliza_exclusiones/agregar_cobertura', compact('polizaExclusion','coberturas'));
	}

	public function agregarCobertura($polizaExclusionId)
	{
		$polizaExclusion = $this->polizaExclusionRepo->find($polizaExclusionId);
		$data = Input::all();
		$cobertura = $this->polizaCoberturaRepo->find($data['cobertura_id']);
		$manager = new PolizaExclusionManager(null, null);
		$manager->agregarCobertura($polizaExclusionId, $cobertura);
		Session::flash('success', 'Se agregó la cobertura a la solicitud de exclusion con éxito.');
		$url = route('ver_poliza',$polizaExclusion->poliza_id) . '#exclusiones';
		return Redirect::to($url);
	}

	public function eliminarCobertura($polizaExclusionId)
	{
		$polizaExclusion = $this->polizaExclusionRepo->find($polizaExclusionId);
		$data = Input::all();
		$cobertura = $this->polizaCoberturaRepo->find($data['cobertura_id']);
		$manager = new PolizaExclusionManager(null, null);
		$manager->eliminarCobertura($polizaExclusionId, $cobertura);
		Session::flash('success', 'Se eliminó la cobertura de la solicitud de exclusión con éxito.');
		return Redirect::route('ver_poliza_exclusion',$polizaExclusion->id);
	}

	public function mostrarAgregarCoberturaVehiculo($polizaExclusionId, $vehiculoId)
	{
		$polizaExclusion = $this->polizaExclusionRepo->find($polizaExclusionId);
		$vehiculos = $this->polizaCoberturaVehiculoRepo->getVehiculosByPolizaByEstado($polizaExclusion->poliza_id,['V'])->lists('vehiculo.placa','id')->toArray();
		$coberturas = $this->polizaCoberturaVehiculoRepo->getCoberturasByPolizaByVehiculoByEstado($polizaExclusion->poliza_id, $vehiculoId, ['V'])->lists('cobertura.nombre','id')->toArray();
		return View::make('administracion/poliza_exclusiones/agregar_cobertura_vehiculo', compact('polizaExclusion','vehiculoId','vehiculos','coberturas'));		
	}

	public function agregarCoberturaVehiculo($polizaExclusionId, $vehiculoId)
	{
		$data = Input::all();
		$polizaExclusion = $this->polizaExclusionRepo->find($polizaExclusionId);
		$polizaCoberturaVehiculo = $this->polizaCoberturaVehiculoRepo->find($data['cobertura_id']);
		$manager = new PolizaExclusionManager(null, $data);
		$manager->agregarCoberturaVehiculo($polizaExclusionId, $polizaCoberturaVehiculo);
		Session::flash('success', 'Se agregó la cobertura particular a la solicitud de exclusión con éxito.');
		$url = route('ver_poliza',$polizaExclusion->poliza_id) . '#exclusiones';
		return Redirect::to($url);
	}

	public function mostrarAprobarSolicitud($exclusionId)
	{
		$exclusion = $this->polizaExclusionRepo->find($exclusionId);

		if($exclusion->estado != 'S')
		{
			Session::flash('error', 'La solicitud de exclusión ya fue procesada. Estado actual: ' . $exclusion->descripcion_estado);
			$url = route('ver_poliza',$exclusion->poliza_id) . '#exclusiones';
			return Redirect::to($url);
		}
		return View::make('administracion/poliza_exclusiones/aprobar_solicitud', compact('exclusion'));
	}

	public function aprobarSolicitud($exclusionId)
	{
		$exclusion = $this->polizaExclusionRepo->find($exclusionId);

		if($exclusion->estado != 'S')
		{
			Session::flash('error', 'La solicitud de exclusión ya fue procesada. Estado actual: ' . $exclusion->descripcion_estado);
			return Redirect::route('ver_poliza',$exclusion->poliza_id);
		}
		$exclusion->estado = 'V';
		$exclusion->fecha_aprobada = date('Y-m-d H:i:s');
		$vehiculos = $this->polizaVehiculoRepo->getByExclusion($exclusionId);
		$coberturasGenerales = $this->polizaCoberturaRepo->getByExclusion($exclusionId);
		$coberturasParticulares = $this->polizaCoberturaVehiculoRepo->getByExclusion($exclusionId);
		$manager = new PolizaExclusionManager($exclusion, Input::all());
		$manager->aprobarSolicitud($vehiculos, $coberturasGenerales, $coberturasParticulares);
		Session::flash('success', 'Se aprobó la exclusion con éxito.');
		$url = route('ver_poliza',$exclusion->poliza_id) . '#exclusiones';
		return Redirect::to($url);
	}
}
