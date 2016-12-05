<?php

namespace App\App\Repositories;

use App\App\Entities\ServicioPago;

class ServicioPagoRepo extends BaseRepo{

	public function getModel()
	{
		return new ServicioPago;
	}

	public function getByEstado($estados)
	{
		return ServicioPago::whereIn('estado',$estados)->get();
	}

}