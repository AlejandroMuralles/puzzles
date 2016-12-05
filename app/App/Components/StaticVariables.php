<?php

namespace App\App\Components;

class StaticVariables {


	protected $tipoUsuario = [
		'Administrador' => 1
	];

	protected $empresasCelular = [
		'CLARO' 	=> 'CLARO',
		'TIGO' 		=> 'TIGO',
		'MOVISTAR' 	=> 'MOVISTAR'
	];

	protected $estadosGenerales = [
		'A' => 'ACTIVO',
		'I' => 'INACTIVO'
	];

	protected $estadosServiciosPagos = [
		'C' => 'COBRADO',
		'N' => 'NO COBRADO',
		'A' => 'ANULADO'
	];

	protected $formasPago = [
		'C' => 'CHEQUE',
		'T' => 'TRANSFERENCIA',
		'D' => 'DEPOSITO',
		'E' => 'EFECTIVO'
	];

	protected $frecuenciasPago = [
		'M' => 'MENSUAL',
		'A' => 'ANUAL',
	];

	public function STipoUsuario($key) { return $this->tipoUsuario[$key]; }
	public function getImpuesto($key) { return $this->impuestos[$key]; }

	public function getEmpresasCelular() { return $this->empresasCelular; }
	public function getEmpresaCelular($key) { return $this->empresasCelular[$key]; }

	public function getEstadosGenerales() { return $this->estadosGenerales; }
	public function getEstadoGeneral($key) { return $this->estadosGenerales[$key]; }

	public function getEstadosRequerimientos() { return $this->estadosRequerimientos; }
	public function getEstadoRequerimiento($key) { return $this->estadosRequerimientos[$key]; }

	public function getEstadosServiciosPagos() { return $this->estadosServiciosPagos; }
	public function getEstadoServicioPago($key) { return $this->estadosServiciosPagos[$key]; }

	public function getFormasPago() { return $this->formasPago; }
	public function getFormaPago($key) { return $this->formasPago[$key]; }

	public function getFrecuenciasPago() { return $this->frecuenciasPago; }
	public function getFrecuenciaPago($key) { return $this->frecuenciasPago[$key]; }

	public function arrayToCommaSeparatedList($array)
	{
		$list = "";
		$i=0;
		foreach($array as $key)
		{
			if($i==0)
				$list = '\''.$key.'\'';
			else
				$list .= ',\''. $key.'\'';
			$i++;
		}
		return $list;
	}

	public function commaSeparatedListToArray($list)
	{
		$array = explode(',', $list);
		return $list;
	}

}