<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\NotaCredito;
use App\App\Repositories\NotaCreditoRepo;
use App\App\Managers\NotaCreditoManager;

use App\App\Repositories\PolizaExclusionRepo;

class NotaCreditoController extends BaseController {

	protected $notaCreditoRepo;
	protected $polizaExclusionRepo;

	public function __construct(NotaCreditoRepo $notaCreditoRepo, PolizaExclusionRepo $polizaExclusionRepo)
	{
		$this->notaCreditoRepo = $notaCreditoRepo;
		$this->polizaExclusionRepo = $polizaExclusionRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function mostrarAgregar($polizaExclusionId){
		$exclusion = $this->polizaExclusionRepo->find($polizaExclusionId);
		return View::make('administracion/notas_creditos/agregar', compact('exclusion'));
	}

	public function agregar($polizaExclusionId)
	{
		$exclusion = $this->polizaExclusionRepo->find($polizaExclusionId);
		$data = Input::all();
		$data['poliza_exclusion_id'] = $exclusion->id;
		$data['poliza_id'] = $exclusion->poliza_id;
		$manager = new NotaCreditoManager(new NotaCredito(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la nota de credito a la exclusión '.$exclusion->numero_solicitud.' con éxito.');
		return Redirect::route('ver_poliza', $exclusion->poliza_id);
	}

	public function mostrarEditar($id){
		$notaCredito = $this->notaCreditoRepo->find($id);
		return View::make('administracion/notas_creditos/editar', compact('notaCredito'));
	}

	public function editar($id)
	{
		$notaCredito = $this->notaCreditoRepo->find($id);
		$data = Input::all();
		$data['poliza_exclusion_id'] = $notaCredito->poliza_exclusion_id;
		$data['poliza_id'] = $notaCredito->poliza_id;
		$manager = new NotaCreditoManager($notaCredito, $data);
		$manager->save();
		Session::flash('success', 'Se editó la nota de crédito con éxito.');
		return Redirect::route('ver_poliza',$notaCredito->poliza_id);
	}
}
