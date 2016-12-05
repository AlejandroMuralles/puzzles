<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session, Variable;

use App\App\Entities\Servicio;
use App\App\Repositories\ServicioRepo;
use App\App\Managers\ServicioManager;

use App\App\Repositories\ClienteRepo;

class ServicioController extends BaseController {

	protected $servicioRepo;
	protected $clienteRepo;

	public function __construct(ServicioRepo $servicioRepo, clienteRepo $clienteRepo)
	{
		$this->servicioRepo = $servicioRepo;
		$this->clienteRepo = $clienteRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$servicios = $this->servicioRepo->all('descripcion');
		return View::make('administracion/servicios/index', compact('servicios'));
	}

	public function mostrarAgregar(){
		$clientes = $this->clienteRepo->getByEstado(['A'])->lists('nombre','id')->toArray();
		$frecuencias = Variable::getFrecuenciasPago();
		return View::make('administracion/servicios/agregar', compact('clientes','frecuencias'));
	}

	public function agregar()
	{
		$data = Input::all();
		$data['estado'] = 'A';
		$manager = new ServicioManager(new Servicio(), $data);
		$manager->agregar();
		Session::flash('success', 'Se agregó el servicio con éxito.');
		return Redirect::route('servicios');
	}

	public function mostrarEditar($id){
		$servicio = $this->servicioRepo->find($id);
		return View::make('administracion/servicios/editar', compact('servicio'));
	}

	public function editar($id)
	{
		$servicio = $this->servicioRepo->find($id);
		$manager = new ServicioManager($servicio, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el servicio con éxito.');
		return Redirect::route('servicios');
	}
}
