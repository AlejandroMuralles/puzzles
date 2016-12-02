<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\Municipio;
use App\App\Repositories\MunicipioRepo;
use App\App\Managers\MunicipioManager;

use App\App\Repositories\DepartamentoRepo;

class MunicipioController extends BaseController {

	protected $municipioRepo;
	protected $departamentoRepo;

	public function __construct(MunicipioRepo $municipioRepo, DepartamentoRepo $departamentoRepo)
	{
		$this->municipioRepo = $municipioRepo;
		$this->departamentoRepo = $departamentoRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado($departamentoId)
	{
		$departamento = $this->departamentoRepo->find($departamentoId);
		$municipios = $this->municipioRepo->getByDepartamento($departamentoId);
		return View::make('administracion/municipios/index', compact('municipios','departamento'));
	}

	public function mostrarAgregar($departamentoId){
		$departamento = $this->departamentoRepo->find($departamentoId);
		return View::make('administracion/municipios/agregar',compact('departamento'));
	}

	public function agregar($departamentoId)
	{
		$data = Input::all();
		$data['departamento_id'] = $departamentoId;
		$manager = new MunicipioManager(new Municipio(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el municipio con éxito.');
		return Redirect::route('municipios', $departamentoId);
	}

	public function mostrarEditar($id){
		$municipio = $this->municipioRepo->find($id);
		return View::make('administracion/municipios/editar', compact('municipio'));
	}

	public function editar($id)
	{
		$municipio = $this->municipioRepo->find($id);
		$data = Input::all();
		$data['departamento_id'] = $municipio->departamento_id;
		$manager = new MunicipioManager($municipio, $data);
		$manager->save();
		Session::flash('success', 'Se editó el municipio con éxito.');
		return Redirect::route('municipios', $municipio->departamento_id);
	}

	public function ajaxByDepartamento($departamentoId)
	{
		$municipios = $this->municipioRepo->getByDepartamento($departamentoId)->lists('nombre','id');
		return json_encode($municipios);
	}
}
