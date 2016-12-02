<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\Producto;
use App\App\Repositories\ProductoRepo;
use App\App\Managers\ProductoManager;

use App\App\Repositories\AseguradoraRepo;

class ProductoController extends BaseController {

	protected $productoRepo;
	protected $aseguradoraRepo;

	public function __construct(ProductoRepo $productoRepo, AseguradoraRepo $aseguradoraRepo)
	{
		$this->productoRepo = $productoRepo;
		$this->aseguradoraRepo = $aseguradoraRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$productos = $this->productoRepo->all('nombre');
		return View::make('administracion/productos/index', compact('productos'));
	}

	public function mostrarAgregar(){
		$aseguradoras = $this->aseguradoraRepo->all('nombre')->lists('nombre','id')->toArray();
		return View::make('administracion/productos/agregar', compact('aseguradoras'));
	}

	public function agregar()
	{
		$manager = new ProductoManager(new Producto(), Input::all());
		$manager->save();
		Session::flash('success', 'Se agregó el producto con éxito.');
		return Redirect::route('productos');
	}

	public function mostrarEditar($id){
		$aseguradoras = $this->aseguradoraRepo->all('nombre')->lists('nombre','id')->toArray();
		$producto = $this->productoRepo->find($id);
		return View::make('administracion/productos/editar', compact('producto', 'aseguradoras'));
	}

	public function editar($id)
	{
		$producto = $this->productoRepo->find($id);
		$manager = new ProductoManager($producto, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el producto con éxito.');
		return Redirect::route('productos');
	}
}
