<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\PorcentajeFraccionamientoAseguradora;
use App\App\Repositories\PorcentajeFraccionamientoAseguradoraRepo;
use App\App\Managers\PorcentajeFraccionamientoAseguradoraManager;

use App\App\Repositories\AseguradoraRepo;

class PorcentajeFraccionamientoAseguradoraController extends BaseController {

	protected $porcentajeFraccionamientoAseguradoraRepo;
	protected $aseguradoraRepo;

	public function __construct(PorcentajeFraccionamientoAseguradoraRepo $porcentajeFraccionamientoAseguradoraRepo, AseguradoraRepo $aseguradoraRepo)
	{
		$this->porcentajeFraccionamientoAseguradoraRepo = $porcentajeFraccionamientoAseguradoraRepo;
		$this->aseguradoraRepo = $aseguradoraRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado($aseguradoraId)
	{
		$aseguradora = $this->aseguradoraRepo->find($aseguradoraId);
		$porcentajes = $this->porcentajeFraccionamientoAseguradoraRepo->getByAseguradora($aseguradoraId);
		return View::make('administracion/porcentajes_fraccionamientos_aseguradoras/index', compact('porcentajes','aseguradora'));
	}

	public function mostrarAgregar($aseguradoraId){
		$aseguradora = $this->aseguradoraRepo->find($aseguradoraId);
		return View::make('administracion/porcentajes_fraccionamientos_aseguradoras/agregar',compact('aseguradora'));
	}

	public function agregar($aseguradoraId)
	{
		$data = Input::all();
		$data['aseguradora_id'] = $aseguradoraId;
		$manager = new PorcentajeFraccionamientoAseguradoraManager(new PorcentajeFraccionamientoAseguradora(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el porcentaje de fraccionamiento de la aseguradora con éxito.');
		return Redirect::route('porcentajes_fraccionamientos_aseguradoras',$aseguradoraId);
	}

	public function mostrarEditar($id){
		$porcentaje = $this->porcentajeFraccionamientoAseguradoraRepo->find($id);
		return View::make('administracion/porcentajes_fraccionamientos_aseguradoras/editar', compact('porcentaje'));
	}

	public function editar($id)
	{
		$porcentaje = $this->porcentajeFraccionamientoAseguradoraRepo->find($id);
		$data = Input::all();
		$data['aseguradora_id'] = $porcentaje->aseguradora_id;		
		$manager = new PorcentajeFraccionamientoAseguradoraManager($porcentaje, $data);
		$manager->save();
		Session::flash('success', 'Se editó el porcentaje de fraccionamiento de la aseguradora con éxito.');
		return Redirect::route('porcentajes_fraccionamientos_aseguradoras',$porcentaje->aseguradora_id);
	}
}
