<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\PorcentajeFraccionamientoGeneral;
use App\App\Repositories\PorcentajeFraccionamientoGeneralRepo;
use App\App\Managers\PorcentajeFraccionamientoGeneralManager;

class PorcentajeFraccionamientoGeneralController extends BaseController {

	protected $generalRepo;

	public function __construct(PorcentajeFraccionamientoGeneralRepo $porcentajeFraccionamientoGeneralRepo)
	{
		$this->porcentajeFraccionamientoGeneralRepo = $porcentajeFraccionamientoGeneralRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$porcentajes = $this->porcentajeFraccionamientoGeneralRepo->all('cantidad_pagos');
		return View::make('administracion/porcentajes_fraccionamientos_generales/index', compact('porcentajes'));
	}

	public function mostrarAgregar(){
		return View::make('administracion/porcentajes_fraccionamientos_generales/agregar');
	}

	public function agregar()
	{
		$manager = new PorcentajeFraccionamientoGeneralManager(new PorcentajeFraccionamientoGeneral(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó el porcentaje de fraccionamiento de la general con éxito.');
		return Redirect::route('porcentajes_fraccionamientos_generales');
	}

	public function mostrarEditar($id){
		$porcentaje = $this->porcentajeFraccionamientoGeneralRepo->find($id);
		return View::make('administracion/porcentajes_fraccionamientos_generales/editar', compact('porcentaje'));
	}

	public function editar($id)
	{
		$porcentaje = $this->porcentajeFraccionamientoGeneralRepo->find($id);
		$manager = new PorcentajeFraccionamientoGeneralManager($porcentaje, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el porcentaje de fraccionamiento de la general con éxito.');
		return Redirect::route('porcentajes_fraccionamientos_generales');
	}
}
