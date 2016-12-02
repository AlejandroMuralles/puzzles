@extends('layouts.admin')

@section('title') Agregar Notificación @stop

@section('header') Agregar Notificación @stop

@section('css')
<link href="{{asset('assets/plugins/bootstrap-datepicker/datepicker3.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">

@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            {!! Form::open(['route' => array('agregar_permisos', $tipoUsuarioId), 'method' => 'POST', 'id' => 'form', 'class' => 'validate-form']) !!}
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
							<div class="col-lg-3">
								<ul id="myStacked" class="nav nav-pills nav-stacked">
									@foreach($modulos as $modulo)
										<li>
											<a href="#{{$modulo->modulo->id}}" data-toggle="tab">
												{{$modulo->modulo->nombre}}
											</a>
		                            	</li>
									@endforeach
		                        </ul>
		                    </div>
		                    <div class="col-lg-9">
		                    	<div id="myStackedContent" class="tab-content">
		                    		@foreach($modulos as $modulo)
										<div class="tab-pane fade" id="{{$modulo->modulo->id}}">
											<table class="table table-responsive">
												<thead>
													<tr>
														<th>NOMBRE</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
													@foreach($modulo->vistas as $vista)
													<tr>
														<td style="text-align: left">
															{{$vista->nombre}}
														</td>
														<td style="text-align: left">
															<input type="hidden" name="vistas[{{$vista->id}}][id]" value="{{$vista->id}}">
															<input type="checkbox" name="vistas[{{$vista->id}}][checked]" {{$vista->checked}}>
														</td>
													</tr>
													@endforeach
												</tbody>
											</table>
		                                </div>
		                    		@endforeach
	                            </div>
		                    </div>
		                </div>
					</div>
				</div>
				<br/>

	            <p style="text-align: right">
	                <input type="submit" value="Enviar" class="btn btn-primary">
	                <a href="{{ route('perfiles') }}" class="btn btn-danger">Cancelar</a>
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

	    $("#myStacked li:eq(0)").addClass("active");
	    $("#myStackedContent div:eq(0)").addClass("in");
	    $("#myStackedContent div:eq(0)").addClass("active");

    });
</script>
@stop