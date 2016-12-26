@extends('layouts.admin')

@section('title') Agregar Servicio @stop

@section('header') Agregar Servicio @stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            {!! Form::model($servicio, ['route' => array('editar_servicio_pago',$servicio->id), 'method' => 'PUT', 'id' => 'form', 'class' => 'validate-form']) !!}
			
				<div class="row">
					<div class="col-lg-3">
						{!! Field::text('fecha_cobro', null, ['data-required'=>'true','class'=>'fecha']) !!}
					</div>
					<div class="col-lg-3">
						{!! Field::number('costo', null, ['data-required'=>'true','step'=>'any']) !!}
					</div>
					<div class="col-lg-3">
						{!! Field::text('fecha_pago', null, ['data-required'=>'true','class'=>'fecha']) !!}
					</div>
					<div class="col-lg-3">
						{!! Field::number('pago', null, ['data-required'=>'false','step'=>'any']) !!}
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						{!! Field::text('numero_documento') !!}
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						{!! Field::text('fecha_inicio', null, ['data-required'=>'true','class'=>'fecha']) !!}
					</div>
					<div class="col-lg-3">
						{!! Field::text('fecha_fin', null, ['data-required'=>'true','class'=>'fecha']) !!}
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						{!! Field::textarea('observaciones') !!}
					</div>
				</div>

				<br/>

	            <p>
	                <input type="submit" value="Agregar" class="btn btn-primary">
	                <a href="{{ route('servicios') }}" class="btn btn-danger">Cancelar</a>
	            </p>

            {!! Form::close() !!}
		</div>
	</div>
</div>
@stop
