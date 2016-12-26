<?php

namespace App\App\Managers;
use App\App\Entities\ServicioPago;

class ServicioManager extends BaseManager
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
			'descripcion'  	=> 'required',
			'costo'			=> 'required',
			'pago'			=> 'required',
			'cliente_id'  	=> 'required',
			'frecuencia'	=> 'required',
			'estado'		=> 'required',

		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function agregar()
	{
		try
		{
			\DB::beginTransaction();
				$this->isValid();
				$this->entity->fill($this->prepareData($this->data));
				$this->entity->save();

				$servicioPago = new ServicioPago();
				$servicioPago->servicio_id = $this->entity->id;
				$servicioPago->costo = $this->entity->costo;
				$servicioPago->pago = $this->entity->pago;
				$servicioPago->fecha_cobro = $this->entity->fecha_inicio;
				$servicioPago->fecha_inicio = $this->entity->fecha_inicio;
				if($this->entity->frecuencia == 'M'){			
					$fechaInicio = $this->entity->fecha_inicio;
					$fechaInicio = strtotime ( '+30 day' , strtotime ( $fechaInicio ) ) ;
					$servicioPago->fecha_fin = date ( 'Y-m-d' , $fechaInicio );
				}
				elseif($this->entity->frecuencia == 'A'){			
					$fechaInicio = $this->entity->fecha_inicio;
					$fechaInicio = strtotime ( '+365 day' , strtotime ( $fechaInicio ) ) ;
					$servicioPago->fecha_fin = date ( 'Y-m-d' , $fechaInicio );
				}
				$servicioPago->estado = 'N';
				$servicioPago->save();
			\DB::commit();
			
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException('Error',$ex);
		}
	}

}