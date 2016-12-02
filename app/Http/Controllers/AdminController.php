<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Repositories\ColaboradorRepo;

class AdminController extends BaseController {

	protected $colaboradorRepo;

	public function __construct(ColaboradorRepo $colaboradorRepo)
	{
		$this->colaboradorRepo = $colaboradorRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function mostrarDashboard()
	{
		$colaboradores = $this->colaboradorRepo->all('nombres');
		$nColaboradores = count($colaboradores);
		return View::make('administracion/dashboard', compact('nColaboradores'));
	}

}
