@extends('layouts.admin')

@section('title') Pago de Servicios Pendientes @stop

@section('header') Pago de Servicios Pendientes @stop

@section('css')
<link href="{{ asset('assets/plugins/datatables/datatables.css')}}" rel="stylesheet">
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <div class="table-responsive">
                <table id="table" class="table">
					<thead>
						<tr>
							<th>SERVICIO</th>
							<th>COSTO</th>
							<th>FECHA COBRO</th>
							<th>PAGO</th>
							<th>FECHA PAGO</th>
							<th>FECHA INICIO</th>
							<th>FECHA FIN</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($servicios as $servicio)
							<tr>
								<td>{{ $servicio->servicio->descripcion }}</td>
								<td>Q. {{ number_format($servicio->costo,2) }}</td>
								<td>{{ date('d-m-Y',strtotime($servicio->fecha_cobro)) }}</td>
								<td>Q. {{ number_format($servicio->pago,2) }}</td>
								<td>
									@if(!is_null($servicio->fecha_pago))
									{{ date('d-m-Y',strtotime($servicio->fecha_pago)) }}
									@endif
								</td>
								<td>{{ date('d-m-Y',strtotime($servicio->fecha_inicio)) }}</td>
								<td>{{ date('d-m-Y',strtotime($servicio->fecha_fin)) }}</td>
								<td>
									<a href="{{route('editar_servicio_pago',$servicio->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
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