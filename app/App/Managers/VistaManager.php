<?php

namespace App\App\Managers;

class VistaManager extends BaseManager
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
			'modulo_id' => 'required',
			'ruta' => 'required'
		];

		return $rules;
	}

	function prepareData($data)
	{
		if(!isset($data['menu']))
			$data['menu'] = 0;
		if($data['parametros'] == '')
			$data['parametros'] = null;
		return $data;
	}

}