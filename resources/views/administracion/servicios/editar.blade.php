@extends('layouts.admin')

@section('title') Agregar Cliente @stop

@section('header') Agregar Cliente @stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            {!! Form::model($cliente, ['route' => array('editar_cliente',$cliente->id), 'method' => 'PUT', 'id' => 'form', 'class' => 'validate-form']) !!}
			
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
@section('js')
<script>
    $(function(){

    	$('#pais_facturacion_id').on('change', function()
    	{
    		$.ajax({
				url: "{{ route('inicio') }}/ajax/departamentos-pais/" + $(this).val(),
			  	dataType: "json",
			  	success: function(data) {
				    var name, select, option;

				    // Get the raw DOM object for the select box
				    select = document.getElementById('departamento_facturacion_id');

				    // Clear the old options
				    select.options.length = 0;
				    select.options.add(new Option('Seleccione', ''));
				    // Load the new options
				    for (name in data) {
				      if (data.hasOwnProperty(name)) {
				        select.options.add(new Option(data[name], name));
				      }
				    }
				}
			});
    	});

    	$('#departamento_facturacion_id').on('change', function()
    	{
    		$.ajax({
				url: "{{ route('inicio') }}/ajax/municipios-departamento/" + $(this).val(),
			  	dataType: "json",
			  	success: function(data) {
				    var name, select, option;

				    // Get the raw DOM object for the select box
				    select = document.getElementById('municipio_facturacion_id');

				    // Clear the old options
				    select.options.length = 0;
				    select.options.add(new Option('Seleccione', ''));
				    // Load the new options
				    for (name in data) {
				      if (data.hasOwnProperty(name)) {
				        select.options.add(new Option(data[name], name));
				      }
				    }
				}
			});
    	});

    	/*FISCAL*/
    	$('#pais_fiscal_id').on('change', function()
    	{
    		$.ajax({
				url: "{{ route('inicio') }}/ajax/departamentos-pais/" + $(this).val(),
			  	dataType: "json",
			  	success: function(data) {
				    var name, select, option;

				    // Get the raw DOM object for the select box
				    select = document.getElementById('departamento_fiscal_id');

				    // Clear the old options
				    select.options.length = 0;
				    select.options.add(new Option('Seleccione', ''));
				    // Load the new options
				    for (name in data) {
				      if (data.hasOwnProperty(name)) {
				        select.options.add(new Option(data[name], name));
				      }
				    }
				}
			});
    	});

    	$('#departamento_fiscal_id').on('change', function()
    	{
    		$.ajax({
				url: "{{ route('inicio') }}/ajax/municipios-departamento/" + $(this).val(),
			  	dataType: "json",
			  	success: function(data) {
				    var name, select, option;

				    // Get the raw DOM object for the select box
				    select = document.getElementById('municipio_fiscal_id');

				    // Clear the old options
				    select.options.length = 0;
				    select.options.add(new Option('Seleccione', ''));
				    // Load the new options
				    for (name in data) {
				      if (data.hasOwnProperty(name)) {
				        select.options.add(new Option(data[name], name));
				      }
				    }
				}
			});
    	});

    });
</script>
@stop