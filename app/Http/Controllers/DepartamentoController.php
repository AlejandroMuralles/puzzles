<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\Departamento;
use App\App\Repositories\DepartamentoRepo;
use App\App\Managers\DepartamentoManager;

use App\App\Repositories\PaisRepo;

class DepartamentoController extends BaseController {

	protected $departamentoRepo;
	protected $paisRepo;

	public function __construct(DepartamentoRepo $departamentoRepo, PaisRepo $paisRepo)
	{
		$this->departamentoRepo = $departamentoRepo;
		$this->paisRepo = $paisRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado($paisId)
	{
		$pais = $this->paisRepo->find($paisId);
		$departamentos = $this->departamentoRepo->getByPais($paisId);
		return View::make('administracion/departamentos/index', compact('departamentos','pais'));
	}

	public function mostrarAgregar($paisId){
		$pais = $this->paisRepo->find($paisId);
		return View::make('administracion/departamentos/agregar',compact('pais'));
	}

	public function agregar($paisId)
	{
		$data = Input::all();
		$data['pais_id'] = $paisId;
		$manager = new DepartamentoManager(new Departamento(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el departamento con éxito.');
		return Redirect::route('departamentos',$paisId);
	}

	public function mostrarEditar($id){
		$departamento = $this->departamentoRepo->find($id);
		return View::make('administracion/departamentos/editar', compact('departamento'));
	}

	public function editar($id)
	{
		$departamento = $this->departamentoRepo->find($id);
		$data = Input::all();
		$data['pais_id'] = $departamento->pais_id;
		$manager = new DepartamentoManager($departamento, $data);
		$manager->save();
		Session::flash('success', 'Se editó el departamento con éxito.');
		return Redirect::route('departamentos',$departamento->pais_id);
	}

	public function ajaxByPais($paisId)
	{
		$departamentos = $this->departamentoRepo->getByPais($paisId)->lists('nombre','id');
		return json_encode($departamentos);
	}
}
