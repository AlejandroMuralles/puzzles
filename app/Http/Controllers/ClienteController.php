<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session;

use App\App\Entities\Cliente;
use App\App\Repositories\ClienteRepo;
use App\App\Managers\ClienteManager;

use App\App\Repositories\ConsorcioRepo;
use App\App\Repositories\PaisRepo;
use App\App\Repositories\DepartamentoRepo;
use App\App\Repositories\MunicipioRepo;
use App\App\Repositories\ContactoRepo;

class ClienteController extends BaseController {

	protected $clienteRepo;
	protected $consorcioRepo;
	protected $paisRepo;
	protected $departamentoRepo;
	protected $municipioRepo;
	protected $contactoRepo;

	public function __construct(ClienteRepo $clienteRepo, ConsorcioRepo $consorcioRepo, PaisRepo $paisRepo, DepartamentoRepo $departamentoRepo, MunicipioRepo $municipioRepo,
		ContactoRepo $contactoRepo)
	{
		$this->clienteRepo = $clienteRepo;
		$this->consorcioRepo = $consorcioRepo;
		$this->paisRepo = $paisRepo;
		$this->departamentoRepo = $departamentoRepo;
		$this->municipioRepo = $municipioRepo;
		$this->contactoRepo = $contactoRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$clientes = $this->clienteRepo->all('nombre');
		return View::make('administracion/clientes/index', compact('clientes'));
	}

	public function mostrarAgregar($tipoCliente){
		$consorcios = $this->consorcioRepo->lists('nombre','id');
		$paises = $this->paisRepo->lists('nombre','id');
		return View::make('administracion/clientes/agregar', compact('consorcios','paises','tipoCliente'));
	}

	public function agregar($tipoCliente)
	{
		$data = Input::all();
		$data['tipo_cliente'] = $tipoCliente;
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
