<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session, Variable, PDF, Excel;

use App\App\Entities\Poliza;
use App\App\Repositories\PolizaRepo;
use App\App\Managers\PolizaManager;

use App\App\Repositories\AseguradoraRepo;
use App\App\Repositories\ClienteRepo;
use App\App\Repositories\ColaboradorRepo;
use App\App\Repositories\FrecuenciaPagoRepo;
use App\App\Repositories\PolizaVehiculoRepo;
use App\App\Repositories\PolizaInclusionRepo;
use App\App\Repositories\PolizaExclusionRepo;
use App\App\Repositories\PolizaCoberturaRepo;
use App\App\Repositories\PolizaCoberturaVehiculoRepo;
use App\App\Repositories\PolizaRequerimientoRepo;
use App\App\Repositories\ImpuestoRepo;
use App\App\Repositories\NotaCreditoRepo;
use App\App\Repositories\PorcentajeFraccionamientoGeneralRepo;
use App\App\Repositories\PorcentajeFraccionamientoAseguradoraRepo;
use App\App\Repositories\MotivoAnulacionRepo;
use App\App\Managers\SaveDataException;

class PolizaController extends BaseController {

	protected $polizaRepo;
	protected $aseguradoraRepo;
	protected $clienteRepo;
	protected $colaboradorRepo;
	protected $frecuenciaPagoRepo;
	protected $polizaVehiculoRepo;
	protected $polizaInclusionRepo;
	protected $polizaExclusionRepo;
	protected $polizaCoberturaRepo;
	protected $polizaRequerimientoRepo;
	protected $impuestoRepo;
	protected $notaCreditoRepo;
	protected $pfgRepo;
	protected $pfaRepo;
	protected $polizaCoberturaVehiculoRepo;
	protected $motivoAnulacionRepo;


	public function __construct(PolizaRepo $polizaRepo, AseguradoraRepo $aseguradoraRepo, ClienteRepo $clienteRepo, ColaboradorRepo $colaboradorRepo, 
								FrecuenciaPagoRepo $frecuenciaPagoRepo, PolizaVehiculoRepo $polizaVehiculoRepo, PolizaInclusionRepo $polizaInclusionRepo, PolizaExclusionRepo $polizaExclusionRepo,PolizaCoberturaRepo $polizaCoberturaRepo,
								PolizaCoberturaVehiculoRepo $polizaCoberturaVehiculoRepo, PolizaRequerimientoRepo $polizaRequerimientoRepo,
								ImpuestoRepo $impuestoRepo, NotaCreditoRepo $notaCreditoRepo, MotivoAnulacionRepo $motivoAnulacionRepo,
								PorcentajeFraccionamientoGeneralRepo $pfgRepo,
								PorcentajeFraccionamientoAseguradoraRepo $pfaRepo)
	{
		$this->polizaRepo = $polizaRepo;
		$this->aseguradoraRepo = $aseguradoraRepo;
		$this->clienteRepo = $clienteRepo;
		$this->colaboradorRepo = $colaboradorRepo;
		$this->frecuenciaPagoRepo = $frecuenciaPagoRepo;
		$this->polizaVehiculoRepo = $polizaVehiculoRepo;
		$this->polizaInclusionRepo = $polizaInclusionRepo;
		$this->polizaExclusionRepo = $polizaExclusionRepo;
		$this->polizaCoberturaRepo = $polizaCoberturaRepo;
		$this->polizaCoberturaVehiculoRepo = $polizaCoberturaVehiculoRepo;
		$this->polizaRequerimientoRepo = $polizaRequerimientoRepo;
		$this->impuestoRepo = $impuestoRepo;
		$this->notaCreditoRepo = $notaCreditoRepo;
		$this->pfgRepo = $pfgRepo;
		$this->pfaRepo = $pfaRepo;
		$this->motivoAnulacionRepo = $motivoAnulacionRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$polizas = $this->polizaRepo->all('numero');
		return View::make('administracion/polizas/index', compact('polizas'));
	}

	public function mostrarPolizasByEstado($estados)
	{
		$estados = Variable::commaSeparatedListToArray($estados);
		dd($estados);
		$polizas = $this->polizaRepo->getByEstado($estados);
		return View::make('administracion/polizas/index', compact('polizas'));
	}

	public function solicitudes()
	{
		$polizas = $this->polizaRepo->getByEstado('S');
		return View::make('administracion/polizas/solicitudes', compact('polizas'));
	}

	public function mostrarAgregarSolicitud(){
		$aseguradoras = $this->aseguradoraRepo->lists('nombre','id');
		$clientes = $this->clienteRepo->lists('nombre','id');
		$colaboradores = $this->colaboradorRepo->listsConcat('nombres','apellidos','id');
		$frecuencias = $this->frecuenciaPagoRepo->lists('nombre','id');
		$fraccionamientos = array();
		$pfg = $this->pfgRepo->all('cantidad_pagos');
		foreach($pfg as $f)
		{
			$fraccionamientos[$f->cantidad_pagos] = $f->cantidad_pagos;
		}

		return View::make('administracion/polizas/agregar_solicitud', compact('aseguradoras','clientes','colaboradores','frecuencias','fraccionamientos'));
	}

	public function agregarSolicitud()
	{
		$data = Input::all();
		$data['estado'] = 'S';
		$data['fecha_solicitud'] = date('Y-m-d H:i:s');

		$pct_fraccionamiento = 0;
		$pfa = $this->pfaRepo->getByAseguradoraByCantidadPagos($data['aseguradora_id'], $data['cantidad_pagos']);
		if(is_null($pfa)){
			$pfg = $this->pfgRepo->getByCantidadPagos($data['cantidad_pagos']);
			if(!is_null($pfg)){
				$pct_fraccionamiento = $pfg->porcentaje/100;
			}
		}
		else{
			$pct_fraccionamiento = $pfa->porcentaje/100;
		}

		$pct_emision = $this->impuestoRepo->find(Variable::getImpuesto('EMISION'))->porcentaje / 100;
		$pct_iva =  $this->impuestoRepo->find(Variable::getImpuesto('IVA'))->porcentaje / 100;

		$data['pct_fraccionamiento'] = $pct_fraccionamiento;
		$data['pct_emision'] = $pct_emision;
		$data['pct_iva'] = $pct_iva;

		$manager = new PolizaManager(new Poliza(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la solicitud de póliza con éxito.');
		return Redirect::route('solicitudes_polizas');
	}

	public function mostrarVerSolicitud($id)
	{
		$poliza = $this->polizaRepo->find($id);
		
		if($poliza->estado != 'S')
		{
			Session::flash('error', 'La solicitud de póliza ya fue procesada. Estado actual: ' . $poliza->descripcion_estado);
			return Redirect::route('solicitudes_polizas');
		}

		$vehiculos = $this->polizaVehiculoRepo->getByPoliza($id);
		$coberturas = $this->polizaCoberturaRepo->getByPoliza($id);
		$coberturasParticulares = $this->polizaCoberturaVehiculoRepo->getByPoliza($id);
		return View::make('administracion/polizas/ver_solicitud', compact('poliza', 'vehiculos','coberturas','coberturasParticulares'));

	}

	public function mostrarAprobarSolicitudPoliza($polizaId)
	{
		$poliza = $this->polizaRepo->find($polizaId);

		if($poliza->estado != 'S')
		{
			Session::flash('error', 'La solicitud de póliza ya fue procesada. Estado actual: ' . $poliza->descripcion_estado);
			return Redirect::route('solicitudes_polizas');
		}
		return View::make('administracion/polizas/aprobar_solicitud', compact('poliza'));
	}

	public function aprobarSolicitudPoliza($polizaId)
	{
		$poliza = $this->polizaRepo->find($polizaId);

		if($poliza->estado != 'S')
		{
			Session::flash('error', 'La solicitud de póliza ya fue procesada. Estado actual: ' . $poliza->descripcion_estado);
			return Redirect::route('solicitudes_polizas');
		}
		$poliza->estado = 'V';
		$poliza->fecha_aprobada = date('Y-m-d H:i:s');
		$vehiculos = $this->polizaVehiculoRepo->getByPoliza($polizaId);
		$coberturasGenerales = $this->polizaCoberturaRepo->getByPoliza($polizaId);
		$coberturasParticulares = $this->polizaCoberturaVehiculoRepo->getByPoliza($polizaId);
		$manager = new PolizaManager($poliza, Input::all());
		$manager->aprobarSolicitud($vehiculos, $coberturasGenerales, $coberturasParticulares);
		Session::flash('success', 'Se aprobó la póliza con éxito.');
		return Redirect::route('solicitudes_polizas');
	}

	public function vigentes()
	{
		$polizas = $this->polizaRepo->getByEstado('V');
		return View::make('administracion/polizas/vigentes', compact('polizas'));
	}

	public function mostrarVerPoliza($id)
	{
		$poliza = $this->polizaRepo->find($id);
		
		if($poliza->estado == 'S')
		{
			Session::flash('error', 'La póliza aún esta en estado de SOLICITUD.');
			return Redirect::route('polizas_vigentes');
		}

		$vehiculos = $this->polizaVehiculoRepo->getByPoliza($id);
		$coberturas = $this->polizaCoberturaRepo->getByPoliza($id);
		$coberturasParticulares = $this->polizaCoberturaVehiculoRepo->getByPoliza($id);
		$requerimientos = $this->polizaRequerimientoRepo->getByPoliza($id);
		$inclusiones = $this->polizaInclusionRepo->getbyPoliza($id);
		$exclusiones = $this->polizaExclusionRepo->getbyPoliza($id);
		$notas = $this->notaCreditoRepo->getByPoliza($id);
		$motivosAnulacion = $this->motivoAnulacionRepo->lists('nombre','id');
		return View::make('administracion/polizas/ver_poliza', compact('poliza', 'vehiculos','coberturas','requerimientos','inclusiones', 'exclusiones','notas','motivosAnulacion','coberturasParticulares'));

	}

	public function anular($id)
	{
		$motivoAnulacionId = Input::get('motivo_anulacion_id');
		$poliza = $this->polizaRepo->find($id);
		$vehiculos = $this->polizaVehiculoRepo->getByPolizaByEstado($id, ['V','P','SE']);
		$coberturas = $this->polizaCoberturaRepo->getByPolizaByEstado($id, ['V','P','SE']);
		$coberturasParticulares = $this->polizaCoberturaVehiculoRepo->getByPolizaByEstado($id, ['V','P','SE']);
		$requerimientos = $this->polizaRequerimientoRepo->getByPolizaByEstado($id,['N']);
		$inclusiones = $this->polizaInclusionRepo->getByPolizaByEstado($id, ['S','V']);
		$exclusiones = $this->polizaExclusionRepo->getByPolizaByEstado($id, ['S','V']);
		$notas = $this->notaCreditoRepo->getByPoliza($id);
		$manager = new PolizaManager($poliza, Input::all());
		$manager->anular($poliza, $motivoAnulacionId, $vehiculos, $coberturas, $coberturasParticulares, $requerimientos, $inclusiones, $exclusiones);
		Session::flash('success', 'Se anuló la poliza con éxito.');
		return Redirect::route('polizas');
	}

	public function mostrarRenovar($id)
	{
		/*VERIFICAR SI NO TIENE REQUERIMIENTOS PENDIENTES DE COBRO*/
		$requerimientos = $this->polizaRequerimientoRepo->getByPolizaByEstado($id,['N']);
		if(count($requerimientos)>0)
		{
			throw new SaveDataException('Error', new \Exception('No se puede renovar la póliza. Existen '. count($requerimientos) . ' requerimientos sin cobrar.'));
		}

		$poliza = $this->polizaRepo->find($id);
		$aseguradoras = $this->aseguradoraRepo->lists('nombre','id');
		$clientes = $this->clienteRepo->lists('nombre','id');
		$colaboradores = $this->colaboradorRepo->listsConcat('nombres','apellidos','id');
		$frecuencias = $this->frecuenciaPagoRepo->lists('nombre','id');
		$fraccionamientos = array();
		$pfg = $this->pfgRepo->all('cantidad_pagos');
		foreach($pfg as $f)
		{
			$fraccionamientos[$f->cantidad_pagos] = $f->cantidad_pagos;
		}
		return View::make('administracion/polizas/renovar', compact('poliza','aseguradoras','clientes','colaboradores','frecuencias','fraccionamientos'));
	}

	public function renovar($id)
	{
		/*VERIFICAR SI NO TIENE REQUERIMIENTOS PENDIENTES DE COBRO*/
		$requerimientos = $this->polizaRequerimientoRepo->getByPolizaByEstado($id,['N']);
		if(count($requerimientos)>0)
		{
			throw new SaveDataException('Error', new \Exception('No se renovó la póliza. Existen '. count($requerimientos) . ' requerimientos sin cobrar.'));
		}

		$data = Input::all();

		/* CALCULOS PARA LA NUEVA SOLICITUD DE POLIZA */
		$pct_fraccionamiento = 0;
		$pfa = $this->pfaRepo->getByAseguradoraByCantidadPagos($data['aseguradora_id'], $data['cantidad_pagos']);
		if(is_null($pfa)){
			$pfg = $this->pfgRepo->getByCantidadPagos($data['cantidad_pagos']);
			if(!is_null($pfg)){
				$pct_fraccionamiento = $pfg->porcentaje/100;
			}
		}
		else{
			$pct_fraccionamiento = $pfa->porcentaje/100;
		}

		$pct_emision = $this->impuestoRepo->find(Variable::getImpuesto('EMISION'))->porcentaje / 100;
		$pct_iva =  $this->impuestoRepo->find(Variable::getImpuesto('IVA'))->porcentaje / 100;

		$data['pct_fraccionamiento'] = $pct_fraccionamiento;
		$data['pct_emision'] = $pct_emision;
		$data['pct_iva'] = $pct_iva;
		
		/* DATOS DE LA POLIZA A RENOVAR */
		$poliza = $this->polizaRepo->find($id);
		$vehiculos = $this->polizaVehiculoRepo->getByPolizaByEstado($id, ['V','P','SE']);
		$coberturas = $this->polizaCoberturaRepo->getByPolizaByEstado($id, ['V','P','SE']);
		$coberturasParticulares = $this->polizaCoberturaVehiculoRepo->getByPolizaByEstado($id, ['V','P','SE']);
		$inclusiones = $this->polizaInclusionRepo->getbyPolizaByEstado($id, ['S','V']);
		$exclusiones = $this->polizaExclusionRepo->getbyPolizaByEstado($id, ['S','V']);

		$manager = new PolizaManager($poliza, Input::all());
		$manager->anular($poliza, $vehiculos, $coberturas, $coberturasParticulares, $requerimientos, $inclusiones, $exclusiones);
		Session::flash('success', 'Se renovó la poliza con éxito.');
		return Redirect::route('polizas');
	}


	public function mostrarEditar($id){
		$aseguradoras = $this->aseguradoraRepo->all('nombre')->lists('nombre','id')->toArray();
		$poliza = $this->polizaRepo->find($id);
		return View::make('administracion/polizas/editar', compact('poliza', 'aseguradoras'));
	}

	public function editar($id)
	{
		$poliza = $this->polizaRepo->find($id);
		$manager = new PolizaManager($poliza, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el poliza con éxito.');
		return Redirect::route('polizas');
	}

	public function reporteSolicitud($polizaId)
	{
		$poliza = $this->polizaRepo->find($polizaId);
		$vehiculos = $this->polizaVehiculoRepo->getByPoliza($polizaId);
		$coberturasGenerales = $this->polizaCoberturaRepo->getByPolizaByEstado($polizaId, ['P']);
		$coberturasParticulares = $this->polizaCoberturaVehiculoRepo->getByPolizaByEstado($polizaId, ['P']);
		$pdf = PDF::loadView('reportes/polizas/solicitud', compact('poliza','vehiculos','coberturasGenerales','coberturasParticulares'));
		return $pdf->download('Solicitud de Poliza - '.$poliza->numero_solicitud.'.pdf');
	}


	public function reporteSolicitudesPendientes()
	{
		$solicitudesDB = $this->polizaRepo->getByEstado('S');
		$solicitudes = array();
		foreach($solicitudesDB as $solicitudDB)
		{
			$solicitud['FECHA SOLICITUD'] = date('d/m/y', strtotime($solicitudDB->fecha_solicitud));
			$solicitud['NUMERO SOLICITUD'] = $solicitudDB->numero_solicitud;
			$solicitud['ASEGURADORA'] = $solicitudDB->aseguradora->nombre;
			$solicitud['CLIENTE'] = $solicitudDB->cliente->nombre;
			$solicitud['DIAS ATRASO'] = $solicitudDB->dias_desde_solicitud;
			$solicitudes[] = $solicitud;
		}
		Excel::create('Solicitudes de Póliza Pendientes', function($excel) use ($solicitudes) {
			$excel->setTitle('Solicitudes de Póliza Pendientes');
		    $excel->sheet('Solicitudes Pendientes', function($sheet) use ($solicitudes) {				
				$sheet->fromArray($solicitudes);
				$sheet->setAutoFilter();
		    });
		})->export('xlsx');
	}



}
