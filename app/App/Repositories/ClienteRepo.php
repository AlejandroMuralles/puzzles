<?php

namespace App\App\Repositories;

use App\App\Entities\Cliente;

class ClienteRepo extends BaseRepo{

	public function getModel()
	{
		return new Cliente;
	}

	public function getByEstado($estados)
	{
		return Cliente::whereIn('estado',$estados)->get();
	}

}