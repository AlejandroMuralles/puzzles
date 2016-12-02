@extends('layouts.admin')

@section('title') Dashboard @stop

@section('header') Dashboard @stop

@section('css')
<link href="{{ asset('assets/extra_plugins/revolution-slider/revolution_slider.css') }}" rel="stylesheet">
<style>
    #owl .item img{
        display: block;
        width: 100%;
        height: 200px;
    }
    ul
    {
        padding: 0
    }

    @media (max-width: 768px){
        #owl .item img{
            display: block;
            width: 100%;
            height: auto;
        }
    }
</style>
@stop

@section('content')
<div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="card-box widget-icon">
            <div>
                <i class="fa fa-users text-primary"></i>
                <div class="wid-icon-info">
                    <p class="text-muted m-b-5 font-13 text-uppercase">Colaboradores</p>
                    <h4 class="m-t-0 m-b-5 counter"></h4>
                    <small class="text-success"><a href="{{route('colaboradores')}}" class="btn btn-primary btn-xs">Ver</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="{{ asset('assets/extra_plugins/revolution-slider/js/jquery.themepunch.tools.min.js') }}"></script>
<script src="{{ asset('assets/extra_plugins/revolution-slider/js/jquery.themepunch.revolution.min.js') }}"></script>
<script src="{{ asset('assets/extra_plugins/revolution-slider/revolution_slider.js') }}"></script>
<script>
    $(document).ready(function() {
              
    });
</script>
@stop