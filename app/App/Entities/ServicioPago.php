<?php

namespace App\App\Entities;

class ServicioPago extends \Eloquent {

	protected $fillable = ['servicio_id','fecha_cobro','costo','pago','observaciones','numero_documento','fecha_pago','estado'];

	protected $table = 'servicio_pago';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoServicioPago($this->estado);
	}

}