@extends('layouts.admin')

@section('title') Agregar Cliente @stop

@section('header') Agregar Cliente @stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            {!! Form::open(['route' => array('agregar_cliente'), 'method' => 'POST', 'id' => 'form', 'class' => 'validate-form']) !!}
			
				<div class="row">
					<div class="col-lg-12">
						{!! Field::text('nombre', null, ['data-required'=>'true']) !!}
					</div>
					<div class="col-lg-12">
						{!! Field::text('referido_por', null, ['data-required'=>'true']) !!}
					</div>
				</div>

				<br/>

	            <p>
	                <input type="submit" value="Agregar" class="btn btn-primary">
	                <a href="{{ route('clientes') }}" class="btn btn-danger">Cancelar</a>
	            </p>

            {!! Form::close() !!}
		</div>
	</div>
</div>
@stop
