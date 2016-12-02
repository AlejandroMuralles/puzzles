<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

class AdminController extends BaseController {

	public function __construct()
	{
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function mostrarDashboard()
	{
		return View::make('administracion/dashboard');
	}

}
