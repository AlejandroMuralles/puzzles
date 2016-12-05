<?php

namespace App\App\Entities;

class Servicio extends \Eloquent {

	protected $fillable = ['descripcion','costo','pago','cliente_id','frecuencia','fecha_inicio','estado'];

	protected $table = 'servicio';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoServicio($this->estado);
	}

	public function cliente()
	{
		return $this->belongsTo('App\App\Entities\Cliente');
	}

}