<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\ProductoCobertura;
use App\App\Repositories\ProductoCoberturaRepo;
use App\App\Managers\ProductoCoberturaManager;

use App\App\Repositories\ProductoRepo;
use App\App\Repositories\CoberturaRepo;

class ProductoCoberturaController extends BaseController {

	protected $productoCoberturaRepo;
	protected $coberturaRepo;
	protected $productoRepo;

	public function __construct(ProductoCoberturaRepo $productoCoberturaRepo, ProductoRepo $productoRepo, CoberturaRepo $coberturaRepo)
	{
		$this->productoCoberturaRepo = $productoCoberturaRepo;
		$this->coberturaRepo = $coberturaRepo;
		$this->productoRepo = $productoRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado($productoId)
	{
		$producto = $this->productoRepo->find($productoId);
		$coberturas = $this->productoCoberturaRepo->getByProducto($productoId);
		return View::make('administracion/producto_coberturas/index', compact('producto','coberturas'));
	}

	public function mostrarAgregar($productoId){
		$producto = $this->productoRepo->find($productoId);
		$coberturas = $this->productoCoberturaRepo->getNotInProducto($productoId);
		return View::make('administracion/producto_coberturas/agregar', compact('producto','coberturas'));
	}

	public function agregar($productoId)
	{
		$producto = $this->productoRepo->find($productoId);
		$coberturas = Input::get('coberturas');
		$manager = new ProductoCoberturaManager(null, null);
		$manager->agregarCoberturas($producto, $coberturas);
		Session::flash('success', 'Se agregó la cobertura con éxito.');
		return Redirect::route('producto_coberturas',$producto->id);
	}

	public function mostrarEditar($id){
		$cobertura = $this->coberturaRepo->find($id);
		return View::make('administracion/producto_coberturas/editar', compact('cobertura'));
	}

	public function editar($id)
	{
		$cobertura = $this->coberturaRepo->find($id);
		$manager = new CoberturaManager($cobertura, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó la cobertura con éxito.');
		return Redirect::route('coberturas');
	}
}
