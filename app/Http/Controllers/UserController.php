<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Managers\UserManager;
use App\App\Entities\User;
use App\App\Repositories\UserRepo;

use App\App\Repositories\ColaboradorRepo;
use App\App\Repositories\PerfilRepo;

class UserController extends BaseController {

	protected $userRepo;
	protected $colaboradorRepo;
	protected $perfilRepo;

	public function __construct(UserRepo $userRepo, ColaboradorRepo $colaboradorRepo, PerfilRepo $perfilRepo)
	{
		$this->userRepo = $userRepo;
		$this->colaboradorRepo = $colaboradorRepo;
		$this->perfilRepo = $perfilRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function mostrarUsuarios()
	{
		$usuarios = $this->userRepo->all('username');
		return View::make('administracion/usuarios/index', compact('usuarios'));
	}

	public function mostrarAgregar()
	{
		$colaboradores = $this->colaboradorRepo->getListSinUsuario()->lists('nombre','id')->toArray();
		$perfiles = $this->perfilRepo->all('nombre')->lists('nombre','id')->toArray();
		return View::make('administracion/usuarios/agregar', compact('perfiles','colaboradores'));
	}

	public function agregar()
	{
		$manager = new UserManager(new User(), Input::all());
		$manager->save();
		return Redirect::route('usuarios');
	}

	public function mostrarEditar($id)
	{
		$usuario = $this->userRepo->find($id);
		$perfiles = $this->perfilRepo->all('nombre')->lists('nombre','id')->toArray();
		return View::make('administracion/usuarios/editar', compact('perfiles','usuario'));
	}

	public function editar($id)
	{
		$usuario = $this->userRepo->find($id);
		$manager = new UserManager($usuario, Input::all());
		$manager->update();
		return Redirect::route('usuarios');
	}

	public function mostrarCambiarPassword()
	{
		return View::make('administracion/usuarios/cambiar_password');
	}

	public function cambiarPassword()
	{
		$manager = new UserManager(Auth::user(), Input::all());
		$manager->cambiarPassword(Auth::user(), Input::all());
		return Redirect::route('dashboard');
	}
}
