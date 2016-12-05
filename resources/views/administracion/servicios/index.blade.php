@extends('layouts.admin')

@section('title') Listado de Servicios @stop

@section('header') Listado de Servicios @stop

@section('css')
<link href="{{ asset('assets/plugins/datatables/datatables.css')}}" rel="stylesheet">
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <div class="table-responsive">
            	<a href="{{ route('agregar_servicio') }}" class="btn btn-primary">Agregar</a>
            	<br/><br/>
                <table id="table" class="table">
					<thead>
						<tr>
							<th>DESCRIPCION</th>
							<th>CLIENTE</th>
							<th>COSTO</th>
							<th>PAGO</th>
							<th>FECHA INICIO</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($servicios as $servicio)
							<tr>
								<td>{{ $servicio->descripcion }}</td>
								<td>{{ $servicio->cliente->nombre }}</td>
								<td>Q. {{ number_format($servicio->costo,2) }}</td>
								<td>Q. {{ number_format($servicio->pago,2) }}</td>
								<td>{{ $servicio->fecha_inicio }}</td>
								<td>
									<a href="{{route('editar_servicio',$servicio->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop
@section('js')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/datatables-bs3.js') }}"></script>
<script>
	$(document).ready(function() {
   		$('#table').dataTable({
		    "bSort" : false,
		    "iDisplayLength" : 20,
		    "aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "Todos"]],
		   	"aaSorting" : [[1, 'desc']]
		});
	});
</script>
@stop