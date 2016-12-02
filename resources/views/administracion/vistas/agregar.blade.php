@extends('layouts.admin')

@section('title') Agregar vista @stop

@section('header') Agregar vista @stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4></h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">

	            {!! Form::open(['route' => array('agregar_vista'), 'method' => 'POST', 'id' => 'form', 'class' => 'validate-form']) !!}
				
					{!! Field::text('nombre', null, ['data-required'=>'true']) !!}

					{!! Field::select('modulo_id', $modulos, '', ['data-required'=>'true']) !!}

					{!! Field::text('ruta', null, ['data-required'=>'true']) !!}

					{!! Field::checkbox('menu') !!}

					{!! Field::text('icono', null, ['data-required'=>'false']) !!}


					<br/>

		            <p>
		                <input type="submit" value="Agregar" class="btn btn-primary">
		                <a href="{{ route('vistas') }}" class="btn btn-danger">Cancelar</a>
		            </p>

	            {!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@stop