<?php

namespace App\App\Repositories;

use App\App\Entities\Servicio;

class ServicioRepo extends BaseRepo{

	public function getModel()
	{
		return new Servicio;
	}

	public function all($orderBy)
	{
		return Servicio::with('cliente')->orderBy($orderBy)->get();
	}

	public function getByEstado($estados)
	{
		return Servicio::whereIn('estado',$estados)->get();
	}

}