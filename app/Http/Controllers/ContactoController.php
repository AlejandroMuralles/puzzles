<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session, Variable;

use App\App\Entities\Contacto;
use App\App\Repositories\ContactoRepo;
use App\App\Managers\ContactoManager;

use App\App\Repositories\ClienteRepo;

class ContactoController extends BaseController {

	protected $contactoRepo;
	protected $clienteRepo;

	public function __construct(ContactoRepo $contactoRepo, ClienteRepo $clienteRepo)
	{
		$this->contactoRepo = $contactoRepo;
		$this->clienteRepo = $clienteRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado($clienteId)
	{
		$cliente = $this->clienteRepo->find($clienteId);
		$contactos = $this->contactoRepo->getByCliente($clienteId);
		return View::make('administracion/contactos/index', compact('contactos','cliente'));
	}

	public function mostrarAgregar($clienteId){
		$empresasCelular = Variable::getEmpresasCelular();
		$cliente = $this->clienteRepo->find($clienteId);
		return View::make('administracion/contactos/agregar', compact('cliente','empresasCelular'));
	}

	public function agregar($clienteId)
	{
		$cliente = $this->clienteRepo->find($clienteId);
		$data = Input::all();
		$data['cliente_id'] = $clienteId;
		$manager = new ContactoManager(new Contacto(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el contacto con éxito.');
		return Redirect::route('contactos', $clienteId);
	}

	public function mostrarEditar($id){
		$contacto = $this->contactoRepo->find($id);
		$empresasCelular = Variable::getEmpresasCelular();
		return View::make('administracion/contactos/editar', compact('contacto','empresasCelular'));
	}

	public function editar($id)
	{
		$contacto = $this->contactoRepo->find($id);
		$manager = new ContactoManager($contacto, Input::all());
		$manager->save();
		Session::flash('success', 'Se editó el contacto con éxito.');
		return Redirect::route('contactos', $contacto->cliente_id);
	}
}
