<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\FrecuenciaPago;
use App\App\Repositories\FrecuenciaPagoRepo;
use App\App\Managers\FrecuenciaPagoManager;

class FrecuenciaPagoController extends BaseController {

	protected $frecuenciaPagoRepo;

	public function __construct(FrecuenciaPagoRepo $frecuenciaPagoRepo)
	{
		$this->frecuenciaPagoRepo = $frecuenciaPagoRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$frecuencias = $this->frecuenciaPagoRepo->all('nombre');
		return View::make('administracion/frecuencias_pagos/index', compact('frecuencias'));
	}

	public function mostrarAgregar(){
		return View::make('administracion/frecuencias_pagos/agregar');
	}

	public function agregar()
	{
		$manager = new FrecuenciaPagoManager(new FrecuenciaPago(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó la frecuencia de pago con éxito.');
		return Redirect::route('frecuencias_pagos');
	}

	public function mostrarEditar($id){
		$frecuenciaPago = $this->frecuenciaPagoRepo->find($id);
		return View::make('administracion/frecuencias_pagos/editar', compact('frecuenciaPago'));
	}

	public function editar($id)
	{
		$frecuenciaPago = $this->frecuenciaPagoRepo->find($id);
		$manager = new FrecuenciaPagoManager($frecuenciaPago, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó la frecuencia de pago con éxito.');
		return Redirect::route('frecuencias_pagos');
	}
}
