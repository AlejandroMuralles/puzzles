<?php

namespace App\App\Entities;

class Cliente extends \Eloquent {
	protected $fillable = ['nombre','referido_por'];

	protected $table = 'cliente';

}