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
		if(!isset($data['consorcio_id']) || $data['consorcio_id'] == '')
			$data['consorcio_id'] = null;
		return $data;
	}

}