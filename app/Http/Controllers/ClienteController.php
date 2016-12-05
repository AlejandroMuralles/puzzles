<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\Cliente;
use App\App\Repositories\ClienteRepo;
use App\App\Managers\ClienteManager;

class ClienteController extends BaseController {

	protected $clienteRepo;

	public function __construct(ClienteRepo $clienteRepo)
	{
		$this->clienteRepo = $clienteRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$clientes = $this->clienteRepo->all('nombre');
		return View::make('administracion/clientes/index', compact('clientes'));
	}

	public function mostrarAgregar(){
		return View::make('administracion/clientes/agregar');
	}

	public function agregar()
	{
		$data = Input::all();
		$data['estado'] = 'A';
		$manager = new ClienteManager(new Cliente(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el cliente con éxito.');
		return Redirect::route('clientes');
	}

	public function mostrarEditar($id){
		$cliente = $this->clienteRepo->find($id);
		return View::make('administracion/clientes/editar', compact('cliente'));
	}

	public function editar($id)
	{
		$cliente = $this->clienteRepo->find($id);
		$manager = new ClienteManager($cliente, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el cliente con éxito.');
		return Redirect::route('clientes');
	}

	public function mostrarVer($id){
		$cliente = $this->clienteRepo->find($id);
		$contactos = $this->contactoRepo->getByCliente($id);
		return View::make('administracion/clientes/ver', compact('cliente','contactos'));
	}
}
