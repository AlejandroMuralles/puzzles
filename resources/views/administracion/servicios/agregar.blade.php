@extends('layouts.admin')

@section('title') Agregar Servicio @stop

@section('header') Agregar Servicio @stop

@section('css')
<link href="{{asset('assets/plugins/bootstrap-datepicker/datepicker3.css')}}" rel="stylesheet">
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            {!! Form::open(['route' => array('agregar_servicio'), 'method' => 'POST', 'id' => 'form', 'class' => 'validate-form']) !!}
			
				<div class="row">
					<div class="col-lg-12">{!! Field::text('descripcion', null, ['data-required'=>'true']) !!}</div>
				</div>
				<div class="row">
					<div class="col-lg-4">{!! Field::select('cliente_id', $clientes, null, ['data-required'=>'true']) !!}</div>
				</div>
				<div class="row">
					<div class="col-lg-4">{!! Field::text('costo', null, ['data-required'=>'true']) !!}</div>
					<div class="col-lg-4">{!! Field::text('pago', null, ['data-required'=>'true']) !!}</div>
				</div>
				<div class="row">
					<div class="col-lg-4">{!! Field::select('frecuencia', $frecuencias, null, ['data-required'=>'true']) !!}</div>
					<div class="col-lg-4">{!! Field::text('fecha_inicio', null, ['data-required'=>'true', 'class'=>'fecha']) !!}</div>
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
@section('js')
<script src="{{asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
<script>
    $(function(){
    	$('.fecha').datepicker({
    		format: 'yyyy-mm-dd',
		    autoclose: true,
		    todayHighlight: true
		});
    });
</script>
@stop
