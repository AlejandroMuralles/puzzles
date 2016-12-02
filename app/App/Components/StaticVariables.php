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

	protected $estadosRequerimientos = [
		'C' => 'COBRADO',
		'N' => 'NO COBRADO',
		'A' => 'ANULADO'
	];

	protected $estadosPoliza = [
		'S'	=> 'SOLICITUD',
		'V' => 'VIGENTE',
		'A' => 'ANULADA',
		'C' => 'CANCELADA',
		'R' => 'RENOVADA'
	];

	protected $estadosPolizaVehiculo = [
		'P'	 => 'EMISION',
		'V'  => 'VIGENTE',
		'E'  => 'EXCLUIDO',
		'SE' => 'S. EXCLUSION',
		'A'  => 'ANULADO',
		'R'  => 'RENOVADO'
	];

	protected $estadosPolizaCobertura = [
		'P'	 => 'EMISION',
		'V'  => 'VIGENTE',
		'E'  => 'EXCLUIDA',
		'SE' => 'S. EXCLUSION',
		'A'  => 'ANULADA',
		'R'  => 'RENOVADA'
	];

	protected $tiposPlaca = [
		'P'  => 'Particular',
		'C'  => 'Comercial',
		'TC' => 'Transporte Comercial',
		'M'  => 'Motocicleta'
	];

	protected $impuestos = [
		'IVA' => 1,
		'EMISION' => 2,
	];

	protected $formasPago = [
		'C' => 'CHEQUE',
		'T' => 'TRANSFERENCIA',
		'D' => 'DEPOSITO',
		'E' => 'EFECTIVO'
	];

	protected $prefixSolicitudPoliza = 'SP-';
	protected $prefixSolicitudInclusion = 'SI-';
	protected $prefixSolicitudExclusion = 'SE-';

	public function STipoUsuario($key) { return $this->tipoUsuario[$key]; }
	public function getImpuesto($key) { return $this->impuestos[$key]; }

	public function getEmpresasCelular() { return $this->empresasCelular; }
	public function getEmpresaCelular($key) { return $this->empresasCelular[$key]; }

	public function getEstadosGenerales() { return $this->estadosGenerales; }
	public function getEstadoGeneral($key) { return $this->estadosGenerales[$key]; }

	public function getEstadosRequerimientos() { return $this->estadosRequerimientos; }
	public function getEstadoRequerimiento($key) { return $this->estadosRequerimientos[$key]; }

	public function getEstadosPoliza() { return $this->estadosPoliza; }
	public function getEstadoPoliza($key) { return $this->estadosPoliza[$key]; }

	public function getEstadosPolizaVehiculo() { return $this->estadosPolizaVehiculo; }
	public function getEstadoPolizaVehiculo($key) { return $this->estadosPolizaVehiculo[$key]; }

	public function getTiposPlaca() { return $this->tiposPlaca; }
	public function getTipoPlaca($key) { return $this->tiposPlaca[$key]; }

	public function getPrefixSolicitudPoliza(){ return $this->prefixSolicitudPoliza; }
	public function getPrefixSolicitudInclusion(){ return $this->prefixSolicitudInclusion; }
	public function getPrefixSolicitudExclusion(){ return $this->prefixSolicitudExclusion; }

	public function getFormasPago() { return $this->formasPago; }
	public function getFormaPago($key) { return $this->formasPago[$key]; }

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