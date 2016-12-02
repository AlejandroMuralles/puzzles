@extends('layouts.admin')

@section('title') Agregar Usuario @stop

@section('header') Agregar Usuario @stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            {!! Form::open(['route' => 'agregar_usuario', 'method' => 'POST', 'id' => 'form', 'class' => 'validate-form' ]) !!}

				{!! Field::select('colaborador_id', $colaboradores, '', ['data-required'=>'true']) !!}

				{!! Field::text('username', '', ['data-required'=>'true']) !!}

	            {!! Field::password('password', ['data-required'=>'true']) !!}

	            {!! Field::password('password_confirmation', ['placeholder' => 'Repite contraseña', 'data-required'=>'true'] ) !!}

	            {!! Field::select('perfil_id', $perfiles, '', ['data-required'=>'true']) !!}
	            
	            <p>
	                <input type="submit" value="Agregar" class="btn btn-primary">
	                <a href="{{ route('usuarios') }}" class="btn btn-danger">Cancelar</a>
	            </p>

            {!! Form::close() !!}

    	</div>
	</div>
</div>

@stop