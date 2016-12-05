<?php

namespace App\App\Entities;
use Variable;

class Cliente extends \Eloquent {
	protected $fillable = ['nombre','referido_por','estado'];

	protected $table = 'cliente';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

}