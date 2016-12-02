<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\Pais;
use App\App\Repositories\PaisRepo;
use App\App\Managers\PaisManager;

class PaisController extends BaseController {

	protected $paisRepo;

	public function __construct(PaisRepo $paisRepo)
	{
		$this->paisRepo = $paisRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$paises = $this->paisRepo->all('nombre');
		return View::make('administracion/paises/index', compact('paises'));
	}

	public function mostrarAgregar(){
		return View::make('administracion/paises/agregar');
	}

	public function agregar()
	{
		$manager = new PaisManager(new Pais(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó el pais con éxito.');
		return Redirect::route('paises');
	}

	public function mostrarEditar($id){
		$pais = $this->paisRepo->find($id);
		return View::make('administracion/paises/editar', compact('pais'));
	}

	public function editar($id)
	{
		$pais = $this->paisRepo->find($id);
		$manager = new PaisManager($pais, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el pais con éxito.');
		return Redirect::route('paises');
	}
}
