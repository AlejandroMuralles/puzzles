<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\MotivoAnulacion;
use App\App\Repositories\MotivoAnulacionRepo;
use App\App\Managers\MotivoAnulacionManager;

class MotivoAnulacionController extends BaseController {

	protected $motivoAnulacionRepo;

	public function __construct(MotivoAnulacionRepo $motivoAnulacionRepo)
	{
		$this->motivoAnulacionRepo = $motivoAnulacionRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$motivos = $this->motivoAnulacionRepo->all('nombre');
		return View::make('administracion/motivos_anulaciones/index', compact('motivos'));
	}

	public function mostrarAgregar(){
		return View::make('administracion/motivos_anulaciones/agregar');
	}

	public function agregar()
	{
		$manager = new MotivoAnulacionManager(new MotivoAnulacion(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó el motivo de vehículo con éxito.');
		return Redirect::route('motivos_anulacion');
	}

	public function mostrarEditar($id){
		$motivo = $this->motivoAnulacionRepo->find($id);
		return View::make('administracion/motivos_anulaciones/editar', compact('motivo'));
	}

	public function editar($id)
	{
		$motivoAnulacion = $this->motivoAnulacionRepo->find($id);
		$manager = new MotivoAnulacionManager($motivoAnulacion, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el motivo de anulacion con éxito.');
		return Redirect::route('motivos_anulacion');
	}
}
