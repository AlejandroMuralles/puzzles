<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\PolizaRequerimiento;
use App\App\Repositories\PolizaRequerimientoRepo;
use App\App\Managers\PolizaRequerimientoManager;

use App\App\Repositories\PolizaRepo;
use App\App\Repositories\PorcentajeFraccionamientoAseguradoraRepo;
use App\App\Repositories\PorcentajeFraccionamientoGeneralRepo;

use App\App\Repositories\PolizaInclusionRepo;
use App\App\Repositories\MotivoAnulacionRepo;

class PolizaRequerimientoController extends BaseController {

	protected $polizaRequerimientoRepo;
	protected $polizaRepo;
	protected $polizaInclusionRepo;
	protected $pfgRepo;
	protected $pfaRepo;
	protected $motivoAnulacionRepo;

	public function __construct(PolizaRequerimientoRepo $polizaRequerimientoRepo, PolizaRepo $polizaRepo, PolizaInclusionRepo $polizaInclusionRepo, PorcentajeFraccionamientoGeneralRepo $pfgRepo,
			PorcentajeFraccionamientoAseguradoraRepo $pfaRepo, MotivoAnulacionRepo $motivoAnulacionRepo)
	{
		$this->polizaRequerimientoRepo = $polizaRequerimientoRepo;
		$this->polizaRepo = $polizaRepo;
		$this->polizaInclusionRepo = $polizaInclusionRepo;
		$this->pfgRepo = $pfgRepo;
		$this->pfaRepo = $pfaRepo;
		$this->motivoAnulacionRepo = $motivoAnulacionRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function mostrarAgregar($polizaId){
		$inclusiones = $this->polizaInclusionRepo->getByPolizaByEstado($polizaId, ['V'])->lists('endoso','id')->toArray();
		$poliza = $this->polizaRepo->find($polizaId);
		$numero = 0;
		$numero_inicial = 0;
		$prima_neta = 0;
		$cantidad_pagos = $poliza->cantidad_pagos;
		$fecha_inicio = $poliza->fecha_inicio;	
		$polizaInclusionId = 0;
		return View::make('administracion/poliza_requerimientos/agregar', compact('poliza','numero_inicial','numero','fecha_inicio','prima_neta','cantidad_pagos','inclusiones','polizaInclusionId'));
	}

	public function agregar($polizaId)
	{
		$poliza = $this->polizaRepo->find($polizaId);
		$data = Input::all();
		$manager = new PolizaRequerimientoManager(new PolizaRequerimiento(), $data);
		$manager->agregarRequerimientos($poliza);
		Session::flash('success', 'Se agregaron los requerimientos con éxito.');
		$url = route('ver_poliza',$polizaId).'#requerimientos';
		return Redirect::to($url);
	}

	public function generarRequerimientos($polizaId)
	{
		$inclusiones = $this->polizaInclusionRepo->getByPoliza($polizaId)->lists('endoso','id')->toArray();
		$poliza = $this->polizaRepo->find($polizaId);
		$cantidad_pagos = Input::get('cantidad_pagos');;
		$polizaInclusionId = Input::get('poliza_inclusion_id');
		if($polizaInclusionId == '') $polizaInclusionId = null;
		$requerimientos = array();

		$numero_inicial = Input::get('numero');
		$numero = $numero_inicial;
		$prima_neta = Input::get('prima_neta');
		$prima_neta_frac = $prima_neta / $cantidad_pagos;

		$pct_fraccionamiento = $poliza->pct_fraccionamiento;
		$pct_iva = $poliza->pct_iva;
		$pct_emision = $poliza->pct_emision;

		$mesesFrecuenciaPago = $poliza->frecuenciaPago->meses;

		$fecha_inicio = Input::get('fecha_inicio');
		$totalPrimaNeta = 0;
		$totalPrimaTotal = 0;
		
		for($i=1;$i<=$cantidad_pagos;$i++)
		{
			$r = new PolizaRequerimiento();
			$r->numero = $numero;
			$r->fecha_cobro = date('Y-m-d', strtotime("+".$mesesFrecuenciaPago*($i-1)." months", strtotime($fecha_inicio)));
			$r->prima_neta = round($prima_neta_frac,2);
			$r->fraccionamiento = round($r->prima_neta * $pct_fraccionamiento,2);
			$r->emision = round($r->prima_neta * $pct_emision,2);
			$r->iva = round(($r->prima_neta + $r->fraccionamiento + $r->emision ) * $pct_iva,2);
			$r->prima_total = round($r->prima_neta + $r->fraccionamiento + $r->emision + $r->iva,2);
			$r->cuota = $i;
			$r->poliza_inclusion_id = $polizaInclusionId;
			$requerimientos[] = $r;
			$totalPrimaNeta += $r->prima_neta;
			$totalPrimaTotal += $r->prima_total;
			$numero++;
		}
		return View::make('administracion/poliza_requerimientos/agregar', compact('poliza','requerimientos','numero_inicial','numero','prima_neta','fecha_inicio','totalPrimaNeta','totalPrimaTotal','cantidad_pagos','inclusiones','polizaInclusionId'));
	}

	public function mostrarEditar($id){
		$requerimiento = $this->polizaRequerimientoRepo->find($id);
		return View::make('administracion/poliza_requerimientos/editar', compact('requerimiento'));
	}

	public function editar($id)
	{
		$requerimiento = $this->polizaRequerimientoRepo->find($id);
		$data = Input::all();
		$data['cuota'] = $requerimiento->cuota;
		$data['poliza_id'] = $requerimiento->poliza_id;
		$data['numero'] = $requerimiento->numero;
		$manager = new PolizaRequerimientoManager($requerimiento, $data);
		$manager->save();
		Session::flash('success', 'Se editó el requerimiento con éxito.');
		$url = route('ver_poliza',$requerimiento->poliza_id).'#requerimientos';
		return Redirect::to($url);
	}

	public function mostrarPendientes()
	{
		$motivos = $this->motivoAnulacionRepo->lists('nombre','id');
		$estado = ['N'];
		$fecha = date('Y-m-d');
		$requerimientos = $this->polizaRequerimientoRepo->getByEstadoBeforeFechaCobro($estado, $fecha);
		return View::make('administracion/poliza_requerimientos/pendientes', compact('requerimientos'));
	}

	public function anular()
	{
		$data = Input::all();
		$id = $data['requerimiento_id'];
		$data['estado'] = 'A';
		$data['fecha_anulacion'] = date('Y-m-d H:i:s');		
		$requerimiento = $this->polizaRequerimientoRepo->find($id);
		$manager = new PolizaRequerimientoManager($requerimiento, $data);
		$manager->anular();
		Session::flash('success', 'Se anuló el requerimiento '. $requerimiento->numero .' con éxito.');
		$url = route('ver_poliza',$requerimiento->poliza_id).'#requerimientos';
		return Redirect::to($url);
	}

	public function mostrarNoCobradosPorMes()
	{
		$fecha = date('Y-m-d');
		$requerimientosPendientes = $this->polizaRequerimientoRepo->getByEstadoBeforeFechaCobro(['N'], $fecha);
		$meses = [];
		foreach($requerimientosPendientes as $r)
		{
			$mes = date('m',strtotime($r->fecha_cobro));
			$meses[$mes]['mes'] = date('m-Y', strtotime($r->fecha_cobro));
			if( !isset($meses[$mes]['total_no_cobrado']))
				$meses[$mes]['total_no_cobrado'] = 0;
			$meses[$mes]['total_no_cobrado'] += $r->prima_total;
			if( !isset($meses[$mes]['requerimientos']))
				$meses[$mes]['requerimientos'] = 0;
			$meses[$mes]['requerimientos']++;
		}
		return View::make('administracion/poliza_requerimientos/no_cobrado_mes', compact('meses'));

	}


}
