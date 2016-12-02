<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\MarcaVehiculo;
use App\App\Repositories\MarcaVehiculoRepo;
use App\App\Managers\MarcaVehiculoManager;

class MarcaVehiculoController extends BaseController {

	protected $marcaVehiculoRepo;

	public function __construct(MarcaVehiculoRepo $marcaVehiculoRepo)
	{
		$this->marcaVehiculoRepo = $marcaVehiculoRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$marcas = $this->marcaVehiculoRepo->all('nombre');
		return View::make('administracion/marcas_vehiculos/index', compact('marcas'));
	}

	public function mostrarAgregar(){
		return View::make('administracion/marcas_vehiculos/agregar');
	}

	public function agregar()
	{
		$manager = new MarcaVehiculoManager(new MarcaVehiculo(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó el marca de vehículo con éxito.');
		return Redirect::route('marcas_vehiculos');
	}

	public function mostrarEditar($id){
		$marcaVehiculo = $this->marcaVehiculoRepo->find($id);
		return View::make('administracion/marcas_vehiculos/editar', compact('marcaVehiculo'));
	}

	public function editar($id)
	{
		$marcaVehiculo = $this->marcaVehiculoRepo->find($id);
		$manager = new MarcaVehiculoManager($marcaVehiculo, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el marca de vehiculo con éxito.');
		return Redirect::route('marcas_vehiculos');
	}
}
