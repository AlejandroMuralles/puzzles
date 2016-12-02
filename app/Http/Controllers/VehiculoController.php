<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session, Variable;

use App\App\Entities\Vehiculo;
use App\App\Repositories\VehiculoRepo;
use App\App\Managers\VehiculoManager;

use App\App\Repositories\MarcaVehiculoRepo;
use App\App\Repositories\TipoVehiculoRepo;

class VehiculoController extends BaseController {

	protected $vehiculoRepo;
	protected $marcaVehiculoRepo;
	protected $tipoVehiculoRepo;

	public function __construct(VehiculoRepo $vehiculoRepo, MarcaVehiculoRepo $marcaVehiculoRepo, TipoVehiculoRepo $tipoVehiculoRepo)
	{
		$this->vehiculoRepo = $vehiculoRepo;
		$this->marcaVehiculoRepo = $marcaVehiculoRepo;
		$this->tipoVehiculoRepo = $tipoVehiculoRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$vehiculos = $this->vehiculoRepo->all('placa');
		return View::make('administracion/vehiculos/index', compact('vehiculos'));
	}

	public function mostrarAgregar(){
		$marcas = $this->marcaVehiculoRepo->lists('nombre','id');
		$tiposVehiculo = $this->tipoVehiculoRepo->lists('nombre','id');
		$tiposPlaca = Variable::getTiposPlaca();
		return View::make('administracion/vehiculos/agregar',compact('marcas','tiposPlaca','tiposVehiculo'));
	}

	public function agregar()
	{
		$manager = new VehiculoManager(new Vehiculo(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó el vehiculo con éxito.');
		return Redirect::route('vehiculos');
	}

	public function mostrarEditar($id){
		$vehiculo = $this->vehiculoRepo->find($id);
		$marcas = $this->marcaVehiculoRepo->lists('nombre','id');
		$tiposVehiculo = $this->tipoVehiculoRepo->lists('nombre','id');
		$tiposPlaca = Variable::getTiposPlaca();
		return View::make('administracion/vehiculos/editar', compact('vehiculo','marcas','tiposPlaca','tiposVehiculo'));
	}

	public function editar($id)
	{
		$vehiculo = $this->vehiculoRepo->find($id);
		$manager = new VehiculoManager($vehiculo, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el vehiculo con éxito.');
		return Redirect::route('vehiculos');
	}

	public function mostrarVer($id){
		$vehiculo = $this->vehiculoRepo->find($id);
		return View::make('administracion/vehiculos/ver', compact('vehiculo'));
	}

}
