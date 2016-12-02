<?php

namespace App\App\Entities;

class Vista extends \Eloquent {
	protected $fillable = ['nombre','ruta','parametros','menu','modulo_id'];

	protected $table = 'vista';

	public function modulo()
	{
		return $this->belongsTo('App\App\Entities\Modulo');
	}

}