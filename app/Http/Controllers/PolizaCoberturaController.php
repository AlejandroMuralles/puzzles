<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session, Variable;

use App\App\Entities\PolizaCobertura;
use App\App\Repositories\PolizaCoberturaRepo;
use App\App\Managers\PolizaCoberturaManager;

use App\App\Repositories\PolizaRepo;
use App\App\Repositories\CoberturaRepo;
use App\App\Repositories\ProductoRepo;
use App\App\Repositories\ProductoCoberturaRepo;

class PolizaCoberturaController extends BaseController {

	protected $polizaCoberturaRepo;
	protected $coberturaRepo;
	protected $polizaRepo;
	protected $productoRepo;
	protected $productoCoberturaRepo;

	public function __construct(PolizaCoberturaRepo $polizaCoberturaRepo, PolizaRepo $polizaRepo, ProductoRepo $productoRepo, CoberturaRepo $coberturaRepo,
								ProductoCoberturaRepo $productoCoberturaRepo)
	{
		$this->polizaCoberturaRepo = $polizaCoberturaRepo;
		$this->coberturaRepo = $coberturaRepo;
		$this->polizaRepo = $polizaRepo;
		$this->productoRepo = $productoRepo;
		$this->productoCoberturaRepo = $productoCoberturaRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	/*Agregar coberturas por medio de un producto*/
	public function mostrarAgregarProducto($polizaId, $productoId){
		$poliza = $this->polizaRepo->find($polizaId);
		$productos = $this->productoRepo->lists('nombre','id');
		$coberturas = $this->productoCoberturaRepo->getByProducto($productoId);
		return View::make('administracion/poliza_coberturas/agregar_producto', compact('poliza','productos','coberturas','productoId'));
	}

	public function agregarProducto($polizaId,$productoId)
	{
		$poliza = $this->polizaRepo->find($polizaId);
		$data = Input::all();
		//dd($data);
		$manager = new PolizaCoberturaManager(new PolizaCobertura(), $data);
		$manager->agregarProducto($polizaId);
		Session::flash('success', 'Se agregaron las coberturas a la póliza con éxito.');
		$url = route('ver_solicitud_poliza',$polizaId) . '#coberturas';
		return Redirect::to($url);
	}

	public function mostrarAgregar($polizaId){
		$poliza = $this->polizaRepo->find($polizaId);
		$coberturas = $this->polizaCoberturaRepo->getCoberturasNotInPoliza($polizaId)->lists('nombre','id')->toArray();
		return View::make('administracion/poliza_coberturas/agregar', compact('poliza','coberturas'));
	}

	public function agregar($polizaId)
	{
		$poliza = $this->polizaRepo->find($polizaId);
		$data = Input::all();
		$data['poliza_id'] = $polizaId;
		$data['estado'] = 'P';
		$data['fecha_inclusion'] = date('Y-m-d');
		$manager = new PolizaCoberturaManager(new PolizaCobertura(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la cobertura a la solicitud de póliza '.$poliza->numero_solicitud.' con éxito.');
		$url = route('ver_solicitud_poliza',$polizaId) . '#coberturas';
		return Redirect::to($url);
	}

	public function mostrarEditar($id){
		$cobertura = $this->polizaCoberturaRepo->find($id);
		return View::make('administracion/poliza_coberturas/editar', compact('cobertura'));
	}

	public function editar($id)
	{
		$cobertura = $this->polizaCoberturaRepo->find($id);
		$poliza = $this->polizaRepo->find($cobertura->poliza_id);
		$data = Input::all();
		$data['cobertura_id'] = $cobertura->cobertura->id;
		$data['poliza_id'] = $cobertura->poliza_id;
		$data['estado'] = $cobertura->estado;
		$data['fecha_inclusion'] = $cobertura->fecha_inclusion;
		$manager = new PolizaCoberturaManager($cobertura, $data);
		$manager->save();
		Session::flash('success', 'Se editó la cobertura de la solicitud de póliza '.$poliza->numero_solicitud.' con éxito.');
		$url = route('ver_solicitud_poliza',$cobertura->poliza_id) . '#coberturas';
		return Redirect::to($url);
	}

	public function eliminar()
	{
		$id = Input::get('poliza_cobertura_id');
		$cobertura = $this->polizaCoberturaRepo->find($id);
		$manager = new PolizaCoberturaManager($cobertura, Input::all());
		$manager->eliminar();
		Session::flash('success', 'Se eliminó la cobertura con éxito.');
		$url = route('ver_solicitud_poliza',$cobertura->poliza_id) . '#coberturas';
		return Redirect::to($url);
	}

}
