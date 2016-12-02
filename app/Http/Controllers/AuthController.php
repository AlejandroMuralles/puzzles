<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Repositories\PermisoRepo;


class AuthController extends BaseController {


	public function mostrarLogin()
	{
		return View::make('administracion/login');
	}

	public function login()
	{
		$data = Input::only('username','password','remember');


		$credentials = [
			'username' => $data['username'],
			'password' => $data['password']
		];

		
		if(Auth::attempt($credentials))
		{
			$permisoRepo = new PermisoRepo();
			$menuPublico = $permisoRepo->getMenu(Auth::user()->perfil_id, 0);
			Session::set('menuPublico',$menuPublico);
			$menuAdmin = $permisoRepo->getMenu(Auth::user()->perfil_id, 1);
			Session::set('menuAdmin',$menuAdmin);


			if(Auth::user()->primera_vez){
				return Redirect::route('cambiar_password');
			}
			return Redirect::route('dashboard');
		}
		
		return Redirect::back()->with('login-error',1);
	}

	public function logout()
	{
		Auth::logout();
		return Redirect::route('login');
	}

}