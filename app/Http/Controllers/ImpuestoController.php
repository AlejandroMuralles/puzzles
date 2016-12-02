<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\Impuesto;
use App\App\Repositories\ImpuestoRepo;
use App\App\Managers\ImpuestoManager;

class ImpuestoController extends BaseController {

	protected $impuestoRepo;
	protected $departamentoRepo;

	public function __construct(ImpuestoRepo $impuestoRepo)
	{
		$this->impuestoRepo = $impuestoRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$impuestos = $this->impuestoRepo->all('nombre');
		return View::make('administracion/impuestos/index', compact('impuestos'));
	}

	public function mostrarAgregar(){
		return View::make('administracion/impuestos/agregar');
	}

	public function agregar()
	{
		$manager = new ImpuestoManager(new Impuesto(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó el impuesto con éxito.');
		return Redirect::route('impuestos');
	}

	public function mostrarEditar($id){
		$impuesto = $this->impuestoRepo->find($id);
		return View::make('administracion/impuestos/editar', compact('impuesto'));
	}

	public function editar($id)
	{
		$impuesto = $this->impuestoRepo->find($id);
		$manager = new ImpuestoManager($impuesto, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el impuesto con éxito.');
		return Redirect::route('impuestos');
	}
}
