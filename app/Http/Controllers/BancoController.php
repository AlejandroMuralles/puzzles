<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\Banco;
use App\App\Repositories\BancoRepo;
use App\App\Managers\BancoManager;

use App\App\Repositories\AreaRepo;

class BancoController extends BaseController {

	protected $bancoRepo;
	protected $areaRepo;

	public function __construct(BancoRepo $bancoRepo, AreaRepo $areaRepo)
	{
		$this->bancoRepo = $bancoRepo;
		$this->areaRepo = $areaRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$bancos = $this->bancoRepo->all('nombre');
		return View::make('administracion/bancos/index', compact('bancos'));
	}

	public function mostrarAgregar(){
		$areas = $this->areaRepo->all('nombre')->lists('nombre','id')->toArray();
		return View::make('administracion/bancos/agregar', compact('areas'));
	}

	public function agregar()
	{
		$manager = new BancoManager(new Banco(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó el banco con éxito.');
		return Redirect::route('bancos');
	}

	public function mostrarEditar($id){
		$areas = $this->areaRepo->all('nombre')->lists('nombre','id')->toArray();
		$banco = $this->bancoRepo->find($id);
		return View::make('administracion/bancos/editar', compact('banco', 'areas'));
	}

	public function editar($id)
	{
		$banco = $this->bancoRepo->find($id);
		$manager = new BancoManager($banco, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el banco con éxito.');
		return Redirect::route('bancos');
	}
}
