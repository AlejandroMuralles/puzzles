<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session, Variable;

use App\App\Entities\ServicioPago;
use App\App\Repositories\ServicioPagoRepo;
use App\App\Managers\ServicioPagoManager;


class ServicioPagoController extends BaseController {

	protected $servicioPagoRepo;

	public function __construct(ServicioPagoRepo $servicioPagoRepo)
	{
		$this->servicioPagoRepo = $servicioPagoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$servicios = $this->servicioPagoRepo->all('fecha_inicio');
		return View::make('administracion/servicios_pagos/index', compact('servicios'));
	}

	public function pendientes()
	{
		$servicios = $this->servicioPagoRepo->getByEstado(['N']);
		return View::make('administracion/servicios_pagos/pendientes', compact('servicios'));
	}

	public function mostrarEditar($id){
		$servicio = $this->servicioPagoRepo->find($id);
		return View::make('administracion/servicios_pagos/editar', compact('servicio'));
	}

	public function editar($id)
	{
		$servicio = $this->servicioPagoRepo->find($id);
		$manager = new ServicioManager($servicio, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el pago de servicio con éxito.');
		return Redirect::route('servicios_pagos');
	}
}
