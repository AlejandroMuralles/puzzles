<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\Modulo;
use App\App\Repositories\ModuloRepo;
use App\App\Managers\ModuloManager;

class ModuloController extends BaseController {

	protected $moduloRepo;
	protected $departamentoRepo;

	public function __construct(ModuloRepo $moduloRepo)
	{
		$this->moduloRepo = $moduloRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$modulos = $this->moduloRepo->all('nombre');
		return View::make('administracion/modulos/index', compact('modulos'));
	}

	public function mostrarAgregar(){
		return View::make('administracion/modulos/agregar');
	}

	public function agregar()
	{
		$manager = new ModuloManager(new Modulo(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó el modulo con éxito.');
		return Redirect::route('modulos');
	}

	public function mostrarEditar($id){
		$modulo = $this->moduloRepo->find($id);
		return View::make('administracion/modulos/editar', compact('modulo'));
	}

	public function editar($id)
	{
		$modulo = $this->moduloRepo->find($id);
		$manager = new ModuloManager($modulo, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el modulo con éxito.');
		return Redirect::route('modulos');
	}
}
