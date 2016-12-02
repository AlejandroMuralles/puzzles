<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\Consorcio;
use App\App\Repositories\ConsorcioRepo;
use App\App\Managers\ConsorcioManager;

class ConsorcioController extends BaseController {

	protected $consorcioRepo;
	protected $departamentoRepo;

	public function __construct(ConsorcioRepo $consorcioRepo)
	{
		$this->consorcioRepo = $consorcioRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$consorcios = $this->consorcioRepo->all('nombre');
		return View::make('administracion/consorcios/index', compact('consorcios'));
	}

	public function mostrarAgregar(){
		return View::make('administracion/consorcios/agregar');
	}

	public function agregar()
	{
		$manager = new ConsorcioManager(new Consorcio(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó el consorcio con éxito.');
		return Redirect::route('consorcios');
	}

	public function mostrarEditar($id){
		$consorcio = $this->consorcioRepo->find($id);
		return View::make('administracion/consorcios/editar', compact('consorcio'));
	}

	public function editar($id)
	{
		$consorcio = $this->consorcioRepo->find($id);
		$manager = new ConsorcioManager($consorcio, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el consorcio con éxito.');
		return Redirect::route('consorcios');
	}
}
