<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\Permiso;
use App\App\Repositories\PermisoRepo;
use App\App\Managers\PermisoManager;

use App\App\Repositories\PerfilRepo;

class PermisoController extends BaseController {

	protected $permisoRepo;
	protected $tipoUsuarioRepo;

	public function __construct(PermisoRepo $permisoRepo, PerfilRepo $perfilRepo)
	{
		$this->permisoRepo = $permisoRepo;
		$this->perfilRepo = $perfilRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function permisos($id)
	{
		$perfil = $this->perfilRepo->find($id);
		$modulos = $this->permisoRepo->getPermisos($id);
		return View::make('administracion/perfiles/permisos', compact('modulos', 'perfil'));
	}

	public function editar($perfilId)
	{
		$perfil = $this->perfilRepo->find($perfilId);
		$data = Input::all();
		$data['vistas'] = array_where($data['vistas'], function($key, $value)
		{
		    return isset($value['checked']);
		});
		$manager = new PermisoManager($perfil, $data);
		$manager->save();
		Session::flash('success', 'Se agregaron los permisos con éxito.');
		return Redirect::route('perfiles');
	}

}
