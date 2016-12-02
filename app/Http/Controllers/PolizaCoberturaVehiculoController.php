<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session, Variable;

use App\App\Entities\PolizaCoberturaVehiculo;
use App\App\Repositories\PolizaCoberturaVehiculoRepo;
use App\App\Managers\PolizaCoberturaVehiculoManager;

use App\App\Repositories\PolizaRepo;
use App\App\Repositories\CoberturaRepo;
use App\App\Repositories\PolizaVehiculoRepo;

class PolizaCoberturaVehiculoController extends BaseController {

	protected $polizaCoberturaVehiculoRepo;
	protected $coberturaRepo;
	protected $polizaRepo;
	protected $polizaVehiculoRepo;

	public function __construct(PolizaCoberturaVehiculoRepo $polizaCoberturaVehiculoRepo, PolizaRepo $polizaRepo, CoberturaRepo $coberturaRepo, 
								PolizaVehiculoRepo $polizaVehiculoRepo)
	{
		$this->polizaCoberturaVehiculoRepo = $polizaCoberturaVehiculoRepo;
		$this->coberturaRepo = $coberturaRepo;
		$this->polizaRepo = $polizaRepo;
		$this->polizaVehiculoRepo = $polizaVehiculoRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function mostrarAgregar($polizaVehiculoId){
		$polizaVehiculo = $this->polizaVehiculoRepo->find($polizaVehiculoId);
		$coberturas = $this->polizaCoberturaVehiculoRepo->getCoberturasNotInPolizaVehiculo($polizaVehiculoId)->lists('nombre','id')->toArray();
		return View::make('administracion/poliza_coberturas_vehiculo/agregar', compact('polizaVehiculo','coberturas'));
	}

	public function agregar($polizaVehiculoId)
	{
		$polizaVehiculo = $this->polizaVehiculoRepo->find($polizaVehiculoId);
		$data = Input::all();
		$data['poliza_vehiculo_id'] = $polizaVehiculoId;
		$data['poliza_id'] = $polizaVehiculo->poliza_id;
		$data['vehiculo_id'] = $polizaVehiculo->vehiculo_id;
		$data['estado'] = 'P';
		$data['fecha_inclusion'] = date('Y-m-d');
		$manager = new PolizaCoberturaVehiculoManager(new PolizaCoberturaVehiculo(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la cobertura al vehículo '.$polizaVehiculo->vehiculo->placa.' con éxito.');
		$url = route('ver_solicitud_poliza',$polizaVehiculo->poliza_id) . '#coberturas_particulares';
		return Redirect::to($url);
	}

	public function mostrarEditar($id){
		$coberturaParticular = $this->polizaCoberturaVehiculoRepo->find($id);
		return View::make('administracion/poliza_coberturas_vehiculo/editar', compact('coberturaParticular'));
	}

	public function editar($id)
	{
		$coberturaParticular = $this->polizaCoberturaVehiculoRepo->find($id);
		$data = Input::all();
		$data['poliza_vehiculo_id'] = $coberturaParticular->poliza_vehiculo_id;
		$data['poliza_id'] = $coberturaParticular->poliza_id;
		$data['vehiculo_id'] = $coberturaParticular->vehiculo_id;
		$data['cobertura_id'] = $coberturaParticular->cobertura_id;
		$data['estado'] = $coberturaParticular->estado;
		$data['fecha_inclusion'] = $coberturaParticular->fecha_inclusion;
		$manager = new PolizaCoberturaVehiculoManager($coberturaParticular, $data);
		$manager->save();
		Session::flash('success', 'Se editó la cobertura del vehículo '.$coberturaParticular->vehiculo->placa.' con éxito.');
		$url = route('ver_solicitud_poliza',$coberturaParticular->poliza_id) . '#coberturas_particulares';
		return Redirect::to($url);
	}

	public function eliminar()
	{
		$coberturaParticular = $this->polizaCoberturaVehiculoRepo->find(Input::get('poliza_cobertura_vehiculo_id'));
		$manager = new PolizaCoberturaVehiculoManager($coberturaParticular, null);
		$manager->eliminar();
		Session::flash('success', 'Se eliminó la cobertura particular <b>'.$coberturaParticular->cobertura->nombre.'</b> del vehículo '.$coberturaParticular->vehiculo->placa.' con éxito.');
		$url = route('ver_solicitud_poliza',$coberturaParticular->poliza_id) . '#coberturas_particulares';
		return Redirect::to($url);
	}

}
