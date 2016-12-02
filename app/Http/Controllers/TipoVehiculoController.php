<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\TipoVehiculo;
use App\App\Repositories\TipoVehiculoRepo;
use App\App\Managers\TipoVehiculoManager;

class TipoVehiculoController extends BaseController {

	protected $tipoVehiculoRepo;

	public function __construct(TipoVehiculoRepo $tipoVehiculoRepo)
	{
		$this->tipoVehiculoRepo = $tipoVehiculoRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$tipos = $this->tipoVehiculoRepo->all('nombre');
		return View::make('administracion/tipos_vehiculos/index', compact('tipos'));
	}

	public function mostrarAgregar(){
		return View::make('administracion/tipos_vehiculos/agregar');
	}

	public function agregar()
	{
		$manager = new TipoVehiculoManager(new TipoVehiculo(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó el tipo de vehículo con éxito.');
		return Redirect::route('tipos_vehiculos');
	}

	public function mostrarEditar($id){
		$tipoVehiculo = $this->tipoVehiculoRepo->find($id);
		return View::make('administracion/tipos_vehiculos/editar', compact('tipoVehiculo'));
	}

	public function editar($id)
	{
		$tipoVehiculo = $this->tipoVehiculoRepo->find($id);
		$manager = new TipoVehiculoManager($tipoVehiculo, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el tipo de vehiculo con éxito.');
		return Redirect::route('tipos_vehiculos');
	}
}
