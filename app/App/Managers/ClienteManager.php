<?php

namespace App\App\Managers;

class ClienteManager extends BaseManager
{

	protected $entity;
	protected $data;

	public function __construct($entity, $data)
	{
		$this->entity = $entity;
        $this->data   = $data;
	}

	function getRules()
	{

		$rules = [
			'nombre'  => 'required',
			'referido_por'  => 'required',

		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

}