@extends('layouts.admin')

@section('title') Listado de Colaboradores @stop

@section('header') Listado de Colaboradores @stop

@section('css')
<link href="{{ asset('assets/plugins/datatables/datatables.css')}}" rel="stylesheet">
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <div class="table-responsive">
            	<a href="{{ route('agregar_usuario') }}" class="btn btn-primary">Agregar Usuario</a>
            	<br/><br/>
                <table id="table" class="table">
					<thead>
						<tr>
							<th>COLABORADOR</th>
							<th>USERNAME</th>
							<th>TIPO USUARIO</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($usuarios as $usuario)
							<tr>
								<td>{{ $usuario->colaborador->nombre_completo }}</td>
								<td>{{ $usuario->username }}</td>
								<td>{{ $usuario->perfil->nombre }}</td>
								<td>
									<a href="{{route('editar_usuario',$usuario->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
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