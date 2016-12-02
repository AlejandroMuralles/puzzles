@extends('layouts.admin')

@section('title') Editar Usuario @stop

@section('header') Editar Usuario @stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            {!! Form::model($usuario, ['route' => array('editar_usuario',$usuario->id), 'method' => 'PUT', 'id' => 'form', 'class' => 'validate-form' ]) !!}

				{!! Field::text('persona', $usuario->persona->nombres." ".$usuario->persona->apellidos, ['disabled']) !!}

				{!! Field::text('username', null, ['disabled']) !!}

	            {!! Field::password('password') !!}

	            {!! Field::password('password_confirmation', ['placeholder' => 'Repite contraseña'] ) !!}

	            {!! Field::select('perfil_id', $perfiles, null, ['data-required'=>'true']) !!}

	            {!! Field::checkbox('activo') !!}
	            
	            <p>
	                <input type="submit" value="Editar" class="btn btn-primary">
	                <a href="{{ route('usuarios') }}" class="btn btn-danger">Cancelar</a>
	            </p>

            {!! Form::close() !!}

    	</div>
	</div>
</div>

@stop