<?php

namespace App\App\Repositories;
use DB;

abstract class BaseRepo {

	protected $model;

	public function __construct()
	{
		$this->model = $this->getModel();
	}

	abstract public function getModel();

	public function all($orderBy)
	{
		return $this->model->orderBy($orderBy)->get();
	}

	public function orderList($orderBy, $value, $key)
	{
		return $this->model->orderBy($orderBy)->lists($value, $key)->toArray();
	}

	public function find($id)
	{
		return $this->model->find($id);
	}

	public function lists($value, $key)
	{
		return $this->model->orderBy($value)->lists($value, $key)->toArray();
	}

	public function listsConcat($value1, $value2, $key)
	{
		return $this->model->select($key, DB::raw('CONCAT('.$value1.'," ",'.$value2.') as nombre'))->lists('nombre', $key)->toArray();
	}

}