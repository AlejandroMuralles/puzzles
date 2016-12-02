<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\Perfil;
use App\App\Repositories\PerfilRepo;
use App\App\Managers\PerfilManager;

class PerfilController extends BaseController {

	protected $perfilRepo;
	protected $departamentoRepo;

	public function __construct(PerfilRepo $perfilRepo)
	{
		$this->perfilRepo = $perfilRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$perfiles = $this->perfilRepo->all('nombre');
		return View::make('administracion/perfiles/index', compact('perfiles'));
	}

	public function mostrarAgregar(){
		return View::make('administracion/perfiles/agregar');
	}

	public function agregar()
	{
		$manager = new PerfilManager(new Perfil(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó el perfil con éxito.');
		return Redirect::route('perfiles');
	}

	public function mostrarEditar($id){
		$perfil = $this->perfilRepo->find($id);
		return View::make('administracion/perfiles/editar', compact('perfil'));
	}

	public function editar($id)
	{
		$perfil = $this->perfilRepo->find($id);
		$manager = new PerfilManager($perfil, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el perfil con éxito.');
		return Redirect::route('perfiles');
	}
}
