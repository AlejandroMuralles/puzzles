<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\Vista;
use App\App\Repositories\VistaRepo;
use App\App\Managers\VistaManager;

use App\App\Repositories\ModuloRepo;

class VistaController extends BaseController {

	protected $vistaRepo;
	protected $moduloRepo;

	public function __construct(VistaRepo $vistaRepo, ModuloRepo $moduloRepo)
	{
		$this->vistaRepo = $vistaRepo;
		$this->moduloRepo = $moduloRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$vistas = $this->vistaRepo->all('nombre');
		return View::make('administracion/vistas/index', compact('vistas'));
	}

	public function mostrarAgregar(){
		$modulos = $this->moduloRepo->lists('nombre','id');
		return View::make('administracion/vistas/agregar', compact('modulos'));
	}

	public function agregar()
	{
		$manager = new VistaManager(new Vista(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó la vista con éxito.');
		return Redirect::route('vistas');
	}

	public function mostrarEditar($id){
		$vista = $this->vistaRepo->find($id);
		$modulos = $this->moduloRepo->lists('nombre','id');
		return View::make('administracion/vistas/editar', compact('vista','modulos'));
	}

	public function editar($id)
	{
		$vista = $this->vistaRepo->find($id);
		$manager = new VistaManager($vista, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó la vista con éxito.');
		return Redirect::route('vistas');
	}
}
