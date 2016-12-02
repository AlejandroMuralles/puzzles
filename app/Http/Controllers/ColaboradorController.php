<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;


use App\App\Repositories\ColaboradorRepo;
use App\App\Repositories\DepartamentoRepo;
use App\App\Repositories\PuestoRepo;

use App\App\Managers\ColaboradorManager;
use App\App\Entities\Colaborador;


class ColaboradorController extends BaseController {

	protected $colaboradorRepo;
	protected $departamentoRepo;
	protected $puestoRepo;

	public function __construct(ColaboradorRepo $colaboradorRepo, DepartamentoRepo $departamentoRepo, 
		PuestoRepo $puestoRepo)
	{
		$this->colaboradorRepo = $colaboradorRepo;
		$this->departamentoRepo = $departamentoRepo;
		$this->puestoRepo = $puestoRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$colaboradores = $this->colaboradorRepo->all('nombres');
		return View::make('administracion/colaboradores/index', compact('colaboradores'));
	}

	public function mostrarAgregar()
	{
		$departamentos = $this->departamentoRepo->lists('nombre','id');
		$puestos = $this->puestoRepo->all('nombre')->lists('nombre','id')->toArray();
		return View::make('administracion/colaboradores/agregar', compact('departamentos','puestos'));
	}

	public function agregar()
	{
		$manager = new ColaboradorManager(new Colaborador(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó el colaborador con éxito.');
		return Redirect::route('colaboradores');
	}

	public function mostrarEditar($id)
	{
		$colaborador = $this->colaboradorRepo->find($id);
		$departamentos = $this->departamentoRepo->lists('nombre','id')->toArray();
		$puestos = $this->puestoRepo->getByDepartamento($colaborador->puesto->departamento->id)->lists('nombre','id')->toArray();
		return View::make('administracion/colaboradores/editar', compact('departamentos','colaborador','puestos'));
	}

	public function editar($id)
	{
		$colaborador = $this->colaboradorRepo->find($id);
		$manager = new ColaboradorManager($colaborador, Input::all());
		$manager->update();
		Session::flash('success', 'Se actualizó el colaborador con éxito.');
		return Redirect::route('colaboradores');
	}

	public function ajaxPuestosByDepartamento($id)
	{
		$puestos = $this->puestoRepo->getByDepartamento($id)->lists('nombre','id')->toArray();
		return json_encode($puestos);
	}

	/* PUBLICO */
	public function mostrarAgenda()
	{
		View::composer('layouts.default', 'App\Http\Controllers\PublicMenuController');
		$colaboradores = $this->colaboradorRepo->findByContratado(true);
		return View::make('publico/rrhh/colaboradores', compact('colaboradores'));
	}
	
	public function mostrarCumplemes()
	{
		View::composer('layouts.default', 'App\Http\Controllers\PublicMenuController');
		$colaboradores = $this->colaboradorRepo->findByContratado(true);
		return View::make('publico/rrhh/cumplemes', compact('colaboradores'));
	}

}
