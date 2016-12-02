<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\Area;
use App\App\Repositories\AreaRepo;
use App\App\Managers\AreaManager;

class AreaController extends BaseController {

	protected $areaRepo;

	public function __construct(AreaRepo $areaRepo)
	{
		$this->areaRepo = $areaRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$areas = $this->areaRepo->all('nombre');
		return View::make('administracion/areas/index', compact('areas'));
	}

	public function mostrarAgregar(){
		return View::make('administracion/areas/agregar');
	}

	public function agregar()
	{
		$manager = new AreaManager(new Area(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó el area con éxito.');
		return Redirect::route('areas');
	}

	public function mostrarEditar($id){
		$area = $this->areaRepo->find($id);
		return View::make('administracion/areas/editar', compact('area'));
	}

	public function editar($id)
	{
		$area = $this->areaRepo->find($id);
		$manager = new AreaManager($area, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el area con éxito.');
		return Redirect::route('areas');
	}
}
