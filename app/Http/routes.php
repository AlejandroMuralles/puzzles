<?php
date_default_timezone_set('America/Guatemala');

Route::group(['middleware' => 'auth'], function(){

	Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
	Route::get('/', ['as'=>'inicio', function()
	{
		return Redirect::route('login');
	}]);
	
	Route::get('cambiar-contrasena', ['as' => 'cambiar_password', 'uses' => 'UserController@mostrarCambiarPassword']);
	Route::post('cambiar-contrasena', ['as' => 'cambiar_password', 'uses' => 'UserController@cambiarPassword']);

	/* ADMINISTRACION */
	Route::get('Administracion/dashboard', ['as' => 'dashboard', 'uses' => 'AdminController@mostrarDashboard']);
	
	/* CLIENTES */
	Route::get('Cliente/listado', ['as' => 'clientes', 'uses' => 'ClienteController@listado']);
	Route::get('Cliente/agregar', ['as' => 'agregar_cliente', 'uses' => 'ClienteController@mostrarAgregar']);
	Route::post('Cliente/agregar', ['as' => 'agregar_cliente', 'uses' => 'ClienteController@agregar']);
	Route::get('Cliente/editar/{id}', ['as' => 'editar_cliente', 'uses' => 'ClienteController@mostrarEditar']);
	Route::put('Cliente/editar/{id}', ['as' => 'editar_cliente', 'uses' => 'ClienteController@editar']);

	/* SERVICIOS */
	Route::get('Servicio/listado', ['as' => 'servicios', 'uses' => 'ServicioController@listado']);
	Route::get('Servicio/agregar', ['as' => 'agregar_servicio', 'uses' => 'ServicioController@mostrarAgregar']);
	Route::post('Servicio/agregar', ['as' => 'agregar_servicio', 'uses' => 'ServicioController@agregar']);
	Route::get('Servicio/editar/{id}', ['as' => 'editar_servicio', 'uses' => 'ServicioController@mostrarEditar']);
	Route::put('Servicio/editar/{id}', ['as' => 'editar_servicio', 'uses' => 'ServicioController@editar']);

	/* PAGO DE SERVICIOS */
	Route::get('Servicio-Pago/listado', ['as' => 'servicios_pagos', 'uses' => 'ServicioPagoController@listado']);
	Route::get('Servicio-Pago/agregar/{servicioId}', ['as' => 'agregar_servicio_pago', 'uses' => 'ServicioPagoController@mostrarAgregar']);
	Route::post('Servicio-Pago/agregar/{servicioId}', ['as' => 'agregar_servicio_pago', 'uses' => 'ServicioPagoController@agregar']);
	Route::get('Servicio-Pago/editar/{id}', ['as' => 'editar_servicio_pago', 'uses' => 'ServicioPagoController@mostrarEditar']);
	Route::put('Servicio-Pago/editar/{id}', ['as' => 'editar_servicio_pago', 'uses' => 'ServicioPagoController@editar']);
	Route::get('Servicio-Pago/pendientes', ['as' => 'pagos_pendientes', 'uses' => 'ServicioPagoController@pendientes']);

	/* USUARIOS */
	Route::get('Usuarios/listado', ['as' => 'usuarios', 'uses' => 'UserController@mostrarUsuarios']);
	Route::get('Usuarios/agregar/', ['as' => 'agregar_usuario', 'uses' => 'UserController@mostrarAgregar']);
	Route::post('Usuarios/agregar/', ['as' => 'agregar_usuario', 'uses' => 'UserController@agregar']);
	Route::get('Usuarios/editar/{id}', ['as' => 'editar_usuario', 'uses' => 'UserController@mostrarEditar']);
	Route::put('Usuarios/editar/{id}', ['as' => 'editar_usuario', 'uses' => 'UserController@editar']);

	/* PERFILES */
	Route::get('Perfil/listado', ['as' => 'perfiles', 'uses' => 'PerfilController@listado']);
	Route::get('Perfil/agregar/', ['as' => 'agregar_perfil', 'uses' => 'PerfilController@mostrarAgregar']);
	Route::post('Perfil/agregar/', ['as' => 'agregar_perfil', 'uses' => 'PerfilController@agregar']);
	Route::get('Perfil/editar/{id}', ['as' => 'editar_perfil', 'uses' => 'PerfilController@mostrarEditar']);
	Route::put('Perfil/editar/{id}', ['as' => 'editar_perfil', 'uses' => 'PerfilController@editar']);
	Route::get('Perfil/permisos/{id}', ['as' => 'permisos', 'uses' => 'PermisoController@permisos']);	
	Route::post('Perfil/permisos/{id}', ['as' => 'permisos', 'uses' => 'PermisoController@editar']);	

	/* MODULO */
	Route::get('Modulos/listado', ['as' => 'modulos', 'uses' => 'ModuloController@listado']);
	Route::get('Modulos/agregar', ['as' => 'agregar_modulo', 'uses' => 'ModuloController@mostrarAgregar']);	
	Route::post('Modulos/agregar', ['as' => 'agregar_modulo', 'uses' => 'ModuloController@agregar']);	
	Route::get('Modulos/editar/{id}', ['as' => 'editar_modulo', 'uses' => 'ModuloController@mostrarEditar']);	
	Route::put('Modulos/editar/{id}', ['as' => 'editar_modulo', 'uses' => 'ModuloController@editar']);

	/* VISTA */
	Route::get('Vistas/listado', ['as' => 'vistas', 'uses' => 'VistaController@listado']);
	Route::get('Vistas/agregar', ['as' => 'agregar_vista', 'uses' => 'VistaController@mostrarAgregar']);	
	Route::post('Vistas/agregar', ['as' => 'agregar_vista', 'uses' => 'VistaController@agregar']);	
	Route::get('Vistas/editar/{id}', ['as' => 'editar_vista', 'uses' => 'VistaController@mostrarEditar']);	
	Route::put('Vistas/editar/{id}', ['as' => 'editar_vista', 'uses' => 'VistaController@editar']);

	

});


Route::get('login', ['as' => 'login', 'uses' => 'AuthController@mostrarLogin']);
Route::post('login', ['as' => 'login', 'uses' => 'AuthController@login']);


/* AJAX */
Route::get('ajax/puestos/{id}', ['as' => 'ajax_puestos', 'uses' => 'ColaboradorController@ajaxPuestosByDepartamento']);
Route::get('ajax/departamentos-pais/{paisId}', ['as' => 'ajax_departamentos_pais', 'uses' => 'DepartamentoController@ajaxByPais']);
Route::get('ajax/municipios-departamento/{departamentoId}', ['as' => 'ajax_municipos_departamento', 'uses' => 'MunicipioController@ajaxByDepartamento']);

