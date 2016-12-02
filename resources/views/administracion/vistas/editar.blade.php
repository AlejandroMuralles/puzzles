@extends('layouts.admin')

@section('title') Editar vista @stop

@section('header') Editar vista @stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">

            {!! Form::model($vista, ['route' => array('editar_vista',$vista->id), 'method' => 'PUT', 'id' => 'form', 'class' => 'validate-form']) !!}
			
				{!! Field::text('nombre', null, ['data-required'=>'true']) !!}

				{!! Field::select('modulo_id', $modulos, null, ['data-required'=>'true']) !!}

				{!! Field::text('ruta', null, ['data-required'=>'true']) !!}

				{!! Field::checkbox('menu') !!}

				{!! Field::text('icono', null, ['data-required'=>'false']) !!}


				<br/>

	            <p>
	                <input type="submit" value="Editar" class="btn btn-primary">
	                <a href="{{ route('vistas') }}" class="btn btn-danger">Cancelar</a>
	            </p>

            {!! Form::close() !!}
		</div>
	</div>
</div>
@stop