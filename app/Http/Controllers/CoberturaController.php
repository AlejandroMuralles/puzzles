<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\Cobertura;
use App\App\Repositories\CoberturaRepo;
use App\App\Managers\CoberturaManager;

class CoberturaController extends BaseController {

	protected $coberturaRepo;

	public function __construct(CoberturaRepo $coberturaRepo)
	{
		$this->coberturaRepo = $coberturaRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$coberturas = $this->coberturaRepo->all('nombre');
		return View::make('administracion/coberturas/index', compact('coberturas'));
	}

	public function mostrarAgregar(){
		return View::make('administracion/coberturas/agregar');
	}

	public function agregar()
	{
		$manager = new CoberturaManager(new Cobertura(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó la cobertura con éxito.');
		return Redirect::route('coberturas');
	}

	public function mostrarEditar($id){
		$cobertura = $this->coberturaRepo->find($id);
		return View::make('administracion/coberturas/editar', compact('cobertura'));
	}

	public function editar($id)
	{
		$cobertura = $this->coberturaRepo->find($id);
		$manager = new CoberturaManager($cobertura, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó la cobertura con éxito.');
		return Redirect::route('coberturas');
	}
}
