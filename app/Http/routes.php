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
	/* RECURSOS HUMANOS */
	Route::get('Colaboradores/listado', ['as' => 'colaboradores', 'uses' => 'ColaboradorController@listado']);
	Route::get('Colaboradores/agregar/', ['as' => 'agregar_colaborador', 'uses' => 'ColaboradorController@mostrarAgregar']);
	Route::post('Colaboradores/agregar/', ['as' => 'agregar_colaborador', 'uses' => 'ColaboradorController@agregar']);
	Route::get('Colaboradores/editar/{id}', ['as' => 'editar_colaborador', 'uses' => 'ColaboradorController@mostrarEditar']);
	Route::put('Colaboradores/editar/{id}', ['as' => 'editar_colaborador', 'uses' => 'ColaboradorController@editar']);

	/* CLIENTES */
	Route::get('Cliente/listado', ['as' => 'clientes', 'uses' => 'ClienteController@listado']);
	Route::get('Cliente/agregar/{tipo_cliente}', ['as' => 'agregar_cliente', 'uses' => 'ClienteController@mostrarAgregar']);
	Route::post('Cliente/agregar/{tipo_cliente}', ['as' => 'agregar_cliente', 'uses' => 'ClienteController@agregar']);
	Route::get('Cliente/editar/{id}', ['as' => 'editar_cliente', 'uses' => 'ClienteController@mostrarEditar']);
	Route::put('Cliente/editar/{id}', ['as' => 'editar_cliente', 'uses' => 'ClienteController@editar']);
	Route::get('Cliente/ver/{id}', ['as' => 'ver_cliente', 'uses' => 'ClienteController@mostrarVer']);

	/* CONTACTOS */
	Route::get('Contacto/listado/{clienteId}', ['as' => 'contactos', 'uses' => 'ContactoController@listado']);
	Route::get('Contacto/agregar/{clienteId}', ['as' => 'agregar_contacto', 'uses' => 'ContactoController@mostrarAgregar']);
	Route::post('Contacto/agregar/{clienteId}', ['as' => 'agregar_contacto', 'uses' => 'ContactoController@agregar']);
	Route::get('Contacto/editar/{id}', ['as' => 'editar_contacto', 'uses' => 'ContactoController@mostrarEditar']);
	Route::put('Contacto/editar/{id}', ['as' => 'editar_contacto', 'uses' => 'ContactoController@editar']);

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

	/* PAIS */
	Route::get('Paises/listado', ['as' => 'paises', 'uses' => 'PaisController@listado']);
	Route::get('Paises/agregar', ['as' => 'agregar_pais', 'uses' => 'PaisController@mostrarAgregar']);	
	Route::post('Paises/agregar', ['as' => 'agregar_pais', 'uses' => 'PaisController@agregar']);	
	Route::get('Paises/editar/{id}', ['as' => 'editar_pais', 'uses' => 'PaisController@mostrarEditar']);	
	Route::put('Paises/editar/{id}', ['as' => 'editar_pais', 'uses' => 'PaisController@editar']);

	/* DEPARTAMENTO */
	Route::get('Departamentos/listado/{paisId}', ['as' => 'departamentos', 'uses' => 'DepartamentoController@listado']);
	Route::get('Departamentos/agregar/{paisId}', ['as' => 'agregar_departamento', 'uses' => 'DepartamentoController@mostrarAgregar']);	
	Route::post('Departamentos/agregar/{paisId}', ['as' => 'agregar_departamento', 'uses' => 'DepartamentoController@agregar']);	
	Route::get('Departamentos/editar/{id}', ['as' => 'editar_departamento', 'uses' => 'DepartamentoController@mostrarEditar']);	
	Route::put('Departamentos/editar/{id}', ['as' => 'editar_departamento', 'uses' => 'DepartamentoController@editar']);

	/* MUNICIPIO */
	Route::get('Municipios/listado/{departamentoId}', ['as' => 'municipios', 'uses' => 'MunicipioController@listado']);
	Route::get('Municipios/agregar/{departamentoId}', ['as' => 'agregar_municipio', 'uses' => 'MunicipioController@mostrarAgregar']);	
	Route::post('Municipios/agregar/{departamentoId}', ['as' => 'agregar_municipio', 'uses' => 'MunicipioController@agregar']);	
	Route::get('Municipios/editar/{id}', ['as' => 'editar_municipio', 'uses' => 'MunicipioController@mostrarEditar']);	
	Route::put('Municipios/editar/{id}', ['as' => 'editar_municipio', 'uses' => 'MunicipioController@editar']);

	/* AREA */
	Route::get('Areas/listado', ['as' => 'areas', 'uses' => 'AreaController@listado']);
	Route::get('Areas/agregar', ['as' => 'agregar_area', 'uses' => 'AreaController@mostrarAgregar']);	
	Route::post('Areas/agregar', ['as' => 'agregar_area', 'uses' => 'AreaController@agregar']);	
	Route::get('Areas/editar/{id}', ['as' => 'editar_area', 'uses' => 'AreaController@mostrarEditar']);	
	Route::put('Areas/editar/{id}', ['as' => 'editar_area', 'uses' => 'AreaController@editar']);

	/* COBERTURA */
	Route::get('Coberturas/listado', ['as' => 'coberturas', 'uses' => 'CoberturaController@listado']);
	Route::get('Coberturas/agregar', ['as' => 'agregar_cobertura', 'uses' => 'CoberturaController@mostrarAgregar']);	
	Route::post('Coberturas/agregar', ['as' => 'agregar_cobertura', 'uses' => 'CoberturaController@agregar']);	
	Route::get('Coberturas/editar/{id}', ['as' => 'editar_cobertura', 'uses' => 'CoberturaController@mostrarEditar']);	
	Route::put('Coberturas/editar/{id}', ['as' => 'editar_cobertura', 'uses' => 'CoberturaController@editar']);

	/* PUESTO */
	Route::get('Puestos/listado', ['as' => 'puestos', 'uses' => 'PuestoController@listado']);
	Route::get('Puestos/agregar', ['as' => 'agregar_puesto', 'uses' => 'PuestoController@mostrarAgregar']);	
	Route::post('Puestos/agregar', ['as' => 'agregar_puesto', 'uses' => 'PuestoController@agregar']);	
	Route::get('Puestos/editar/{id}', ['as' => 'editar_puesto', 'uses' => 'PuestoController@mostrarEditar']);	
	Route::put('Puestos/editar/{id}', ['as' => 'editar_puesto', 'uses' => 'PuestoController@editar']);

	/* BANCO */
	Route::get('Bancos/listado', ['as' => 'bancos', 'uses' => 'BancoController@listado']);
	Route::get('Bancos/agregar', ['as' => 'agregar_banco', 'uses' => 'BancoController@mostrarAgregar']);	
	Route::post('Bancos/agregar', ['as' => 'agregar_banco', 'uses' => 'BancoController@agregar']);	
	Route::get('Bancos/editar/{id}', ['as' => 'editar_banco', 'uses' => 'BancoController@mostrarEditar']);	
	Route::put('Bancos/editar/{id}', ['as' => 'editar_banco', 'uses' => 'BancoController@editar']);

	/* MODULO */
	Route::get('Modulos/listado', ['as' => 'modulos', 'uses' => 'ModuloController@listado']);
	Route::get('Modulos/agregar', ['as' => 'agregar_modulo', 'uses' => 'ModuloController@mostrarAgregar']);	
	Route::post('Modulos/agregar', ['as' => 'agregar_modulo', 'uses' => 'ModuloController@agregar']);	
	Route::get('Modulos/editar/{id}', ['as' => 'editar_modulo', 'uses' => 'ModuloController@mostrarEditar']);	
	Route::put('Modulos/editar/{id}', ['as' => 'editar_modulo', 'uses' => 'ModuloController@editar']);

	/* MODULO */
	Route::get('Motivos-Anulacion/listado', ['as' => 'motivos_anulacion', 'uses' => 'MotivoAnulacionController@listado']);
	Route::get('Motivos-Anulacion/agregar', ['as' => 'agregar_motivo_anulacion', 'uses' => 'MotivoAnulacionController@mostrarAgregar']);	
	Route::post('Motivos-Anulacion/agregar', ['as' => 'agregar_motivo_anulacion', 'uses' => 'MotivoAnulacionController@agregar']);	
	Route::get('Motivos-Anulacion/editar/{id}', ['as' => 'editar_motivo_anulacion', 'uses' => 'MotivoAnulacionController@mostrarEditar']);	
	Route::put('Motivos-Anulacion/editar/{id}', ['as' => 'editar_motivo_anulacion', 'uses' => 'MotivoAnulacionController@editar']);

	/* VISTA */
	Route::get('Vistas/listado', ['as' => 'vistas', 'uses' => 'VistaController@listado']);
	Route::get('Vistas/agregar', ['as' => 'agregar_vista', 'uses' => 'VistaController@mostrarAgregar']);	
	Route::post('Vistas/agregar', ['as' => 'agregar_vista', 'uses' => 'VistaController@agregar']);	
	Route::get('Vistas/editar/{id}', ['as' => 'editar_vista', 'uses' => 'VistaController@mostrarEditar']);	
	Route::put('Vistas/editar/{id}', ['as' => 'editar_vista', 'uses' => 'VistaController@editar']);

	/* IMPUESTO */
	Route::get('Impuestos/listado', ['as' => 'impuestos', 'uses' => 'ImpuestoController@listado']);
	Route::get('Impuestos/agregar', ['as' => 'agregar_impuesto', 'uses' => 'ImpuestoController@mostrarAgregar']);	
	Route::post('Impuestos/agregar', ['as' => 'agregar_impuesto', 'uses' => 'ImpuestoController@agregar']);	
	Route::get('Impuestos/editar/{id}', ['as' => 'editar_impuesto', 'uses' => 'ImpuestoController@mostrarEditar']);	
	Route::put('Impuestos/editar/{id}', ['as' => 'editar_impuesto', 'uses' => 'ImpuestoController@editar']);

	/* ASEGURADORAS */
	Route::get('Aseguradoras/listado', ['as' => 'aseguradoras', 'uses' => 'AseguradoraController@listado']);
	Route::get('Aseguradoras/agregar/', ['as' => 'agregar_aseguradora', 'uses' => 'AseguradoraController@mostrarAgregar']);
	Route::post('Aseguradoras/agregar/', ['as' => 'agregar_aseguradora', 'uses' => 'AseguradoraController@agregar']);
	Route::get('Aseguradoras/editar/{id}', ['as' => 'editar_aseguradora', 'uses' => 'AseguradoraController@mostrarEditar']);
	Route::put('Aseguradoras/editar/{id}', ['as' => 'editar_aseguradora', 'uses' => 'AseguradoraController@editar']);

	/* CONSORCIO */
	Route::get('Consorcios/listado', ['as' => 'consorcios', 'uses' => 'ConsorcioController@listado']);
	Route::get('Consorcios/agregar', ['as' => 'agregar_consorcio', 'uses' => 'ConsorcioController@mostrarAgregar']);	
	Route::post('Consorcios/agregar', ['as' => 'agregar_consorcio', 'uses' => 'ConsorcioController@agregar']);	
	Route::get('Consorcios/editar/{id}', ['as' => 'editar_consorcio', 'uses' => 'ConsorcioController@mostrarEditar']);	
	Route::put('Consorcios/editar/{id}', ['as' => 'editar_consorcio', 'uses' => 'ConsorcioController@editar']);

	/* PRODUCTO */
	Route::get('Productos/listado', ['as' => 'productos', 'uses' => 'ProductoController@listado']);
	Route::get('Productos/agregar', ['as' => 'agregar_producto', 'uses' => 'ProductoController@mostrarAgregar']);	
	Route::post('Productos/agregar', ['as' => 'agregar_producto', 'uses' => 'ProductoController@agregar']);	
	Route::get('Productos/editar/{id}', ['as' => 'editar_producto', 'uses' => 'ProductoController@mostrarEditar']);	
	Route::put('Productos/editar/{id}', ['as' => 'editar_producto', 'uses' => 'ProductoController@editar']);

	/* PRODUCTO */
	Route::get('Productos/coberturas/{productoId}', ['as' => 'producto_coberturas', 'uses' => 'ProductoCoberturaController@listado']);
	Route::get('Productos/agregar-coberturas/{productoId}', ['as' => 'agregar_producto_coberturas', 'uses' => 'ProductoCoberturaController@mostrarAgregar']);	
	Route::post('Productos/agregar-coberturas/{productoId}', ['as' => 'agregar_producto_coberturas', 'uses' => 'ProductoCoberturaController@agregar']);	
	Route::get('Productos/editar-coberturas/{productoId}', ['as' => 'editar_producto_coberturas', 'uses' => 'ProductoCoberturaController@mostrarEditar']);	
	Route::put('Productos/editar-coberturas/{productoId}', ['as' => 'editar_producto_coberturas', 'uses' => 'ProductoCoberturaController@editar']);

	/* VEHICULO */
	Route::get('Vehiculos/listado', ['as' => 'vehiculos', 'uses' => 'VehiculoController@listado']);
	Route::get('Vehiculos/agregar', ['as' => 'agregar_vehiculo', 'uses' => 'VehiculoController@mostrarAgregar']);	
	Route::post('Vehiculos/agregar', ['as' => 'agregar_vehiculo', 'uses' => 'VehiculoController@agregar']);	
	Route::get('Vehiculos/editar/{id}', ['as' => 'editar_vehiculo', 'uses' => 'VehiculoController@mostrarEditar']);	
	Route::put('Vehiculos/editar/{id}', ['as' => 'editar_vehiculo', 'uses' => 'VehiculoController@editar']);
	Route::get('Vehiculos/ver/{id}', ['as' => 'ver_vehiculo', 'uses' => 'VehiculoController@mostrarVer']);	

	/* TIPOS DE VEHICULO */
	Route::get('Tipos-Vehiculos/listado', ['as' => 'tipos_vehiculos', 'uses' => 'TipoVehiculoController@listado']);
	Route::get('Tipos-Vehiculos/agregar', ['as' => 'agregar_tipo_vehiculo', 'uses' => 'TipoVehiculoController@mostrarAgregar']);	
	Route::post('Tipos-Vehiculos/agregar', ['as' => 'agregar_tipo_vehiculo', 'uses' => 'TipoVehiculoController@agregar']);	
	Route::get('Tipos-Vehiculos/editar/{id}', ['as' => 'editar_tipo_vehiculo', 'uses' => 'TipoVehiculoController@mostrarEditar']);	
	Route::put('Tipos-Vehiculos/editar/{id}', ['as' => 'editar_tipo_vehiculo', 'uses' => 'TipoVehiculoController@editar']);


	/* MARCAS DE VEHICULO */
	Route::get('Marcas-Vehiculos/listado', ['as' => 'marcas_vehiculos', 'uses' => 'MarcaVehiculoController@listado']);
	Route::get('Marcas-Vehiculos/agregar', ['as' => 'agregar_marca_vehiculo', 'uses' => 'MarcaVehiculoController@mostrarAgregar']);	
	Route::post('Marcas-Vehiculos/agregar', ['as' => 'agregar_marca_vehiculo', 'uses' => 'MarcaVehiculoController@agregar']);	
	Route::get('Marcas-Vehiculos/editar/{id}', ['as' => 'editar_marca_vehiculo', 'uses' => 'MarcaVehiculoController@mostrarEditar']);	
	Route::put('Marcas-Vehiculos/editar/{id}', ['as' => 'editar_marca_vehiculo', 'uses' => 'MarcaVehiculoController@editar']);

	/* POLIZAS */
	Route::get('Polizas/solicitudes', ['as' => 'solicitudes_polizas', 'uses' => 'PolizaController@solicitudes']);
	Route::get('Polizas/agregar-solicitud', ['as' => 'agregar_solicitud_poliza', 'uses' => 'PolizaController@mostrarAgregarSolicitud']);	
	Route::post('Polizas/agregar-solicitud', ['as' => 'agregar_solicitud_poliza', 'uses' => 'PolizaController@agregarSolicitud']);	
	Route::get('Polizas/ver-solicitud/{id}', ['as' => 'ver_solicitud_poliza', 'uses' => 'PolizaController@mostrarVerSolicitud']);
	Route::get('Polizas/aprobar-solicitud/{polizaId}', ['as' => 'aprobar_solicitud_poliza', 'uses' => 'PolizaController@mostrarAprobarSolicitudPoliza']);
	Route::post('Polizas/aprobar-solicitud/{polizaId}', ['as' => 'aprobar_solicitud_poliza', 'uses' => 'PolizaController@aprobarSolicitudPoliza']);
	Route::get('Polizas/renovar/{polizaId}', ['as' => 'renovar_poliza', 'uses' => 'PolizaController@mostrarRenovar']);
	Route::post('Polizas/renovar/{polizaId}', ['as' => 'renovar_poliza', 'uses' => 'PolizaController@renovar']);
	Route::post('Polizas/anular/{polizaId}', ['as' => 'anular_poliza', 'uses' => 'PolizaController@anular']);


	Route::get('Polizas/listado', ['as' => 'polizas', 'uses' => 'PolizaController@listado']);
	Route::get('Polizas/vigentes', ['as' => 'polizas_vigentes', 'uses' => 'PolizaController@vigentes']);
	Route::get('Polizas/ver/{id}', ['as' => 'ver_poliza', 'uses' => 'PolizaController@mostrarVerPoliza']);
	Route::get('Polizas/reporte-solicitudes-pendientes', ['as' => 'polizas_reporte_solicitudes_pendientes', 'uses' => 'PolizaController@reporteSolicitudesPendientes']);
	Route::get('Polizas/reporte-solicitud/{polizaId}', ['as' => 'polizas_reporte_solicitud', 'uses' => 'PolizaController@reporteSolicitud']);

	
	Route::get('Polizas/editar/{id}', ['as' => 'editar_poliza', 'uses' => 'PolizaController@mostrarEditar']);	
	Route::put('Polizas/editar/{id}', ['as' => 'editar_poliza', 'uses' => 'PolizaController@editar']);

	/* MARCAS DE VEHICULO */
	Route::get('Frecuencias-Pagos/listado', ['as' => 'frecuencias_pagos', 'uses' => 'FrecuenciaPagoController@listado']);
	Route::get('Frecuencias-Pagos/agregar', ['as' => 'agregar_frecuencia_pago', 'uses' => 'FrecuenciaPagoController@mostrarAgregar']);	
	Route::post('Frecuencias-Pagos/agregar', ['as' => 'agregar_frecuencia_pago', 'uses' => 'FrecuenciaPagoController@agregar']);	
	Route::get('Frecuencias-Pagos/editar/{id}', ['as' => 'editar_frecuencia_pago', 'uses' => 'FrecuenciaPagoController@mostrarEditar']);	
	Route::put('Frecuencias-Pagos/editar/{id}', ['as' => 'editar_frecuencia_pago', 'uses' => 'FrecuenciaPagoController@editar']);

	/* POLIZAS - VEHICULO */
	Route::get('Polizas-Vehiculos/agregar/{polizaId}', ['as' => 'agregar_poliza_vehiculo', 'uses' => 'PolizaVehiculoController@mostrarAgregar']);
	Route::post('Polizas-Vehiculos/agregar/{polizaId}', ['as' => 'agregar_poliza_vehiculo', 'uses' => 'PolizaVehiculoController@agregar']);	
	Route::get('Polizas-Vehiculos/editar/{id}', ['as' => 'editar_poliza_vehiculo', 'uses' => 'PolizaVehiculoController@mostrarEditar']);	
	Route::put('Polizas-Vehiculos/editar/{id}', ['as' => 'editar_poliza_vehiculo', 'uses' => 'PolizaVehiculoController@editar']);
	Route::delete('Polizas-Vehiculos/eliminar', ['as' => 'eliminar_poliza_vehiculo', 'uses' => 'PolizaVehiculoController@eliminar']);
	Route::get('Polizas-Vehiculos/editar-certificado/{id}', ['as' => 'editar_certificado_poliza_vehiculo', 'uses' => 'PolizaVehiculoController@mostrarEditarCertificado']);
	Route::put('Polizas-Vehiculos/editar-certificado/{id}', ['as' => 'editar_certificado_poliza_vehiculo', 'uses' => 'PolizaVehiculoController@editarCertificado']);
	Route::get('Polizas-Vehiculos/ver/{id}', ['as' => 'ver_poliza_vehiculo', 'uses' => 'PolizaVehiculoController@mostrarVer']);	
	Route::get('Polizas-Vehiculos/buscar', ['as' => 'buscar_poliza_vehiculo', 'uses' => 'PolizaVehiculoController@mostrarBuscar']);
	Route::post('Polizas-Vehiculos/buscar', ['as' => 'buscar_poliza_vehiculo', 'uses' => 'PolizaVehiculoController@buscar']);

	/* POLIZA COBERTURAS VEHICULO*/
	Route::get('Polizas-Coberturas-Vehiculo/agregar/{polizaVehiculoId}', ['as' => 'agregar_poliza_cobertura_vehiculo', 'uses' => 'PolizaCoberturaVehiculoController@mostrarAgregar']);	
	Route::post('Polizas-Coberturas-Vehiculo/agregar/{polizaVehiculoId}', ['as' => 'agregar_poliza_cobertura_vehiculo', 'uses' => 'PolizaCoberturaVehiculoController@agregar']);
	Route::get('Polizas-Coberturas-Vehiculos/editar/{id}', ['as' => 'editar_poliza_cobertura_vehiculo', 'uses' => 'PolizaCoberturaVehiculoController@mostrarEditar']);	
	Route::put('Polizas-Coberturas-Vehiculos/editar/{id}', ['as' => 'editar_poliza_cobertura_vehiculo', 'uses' => 'PolizaCoberturaVehiculoController@editar']);
	Route::delete('Polizas-Coberturas-Vehiculos/eliminar', ['as' => 'eliminar_poliza_cobertura_vehiculo', 'uses' => 'PolizaCoberturaVehiculoController@eliminar']);

	/* POLIZAS - INCLUSIONES */
	Route::post('Polizas-Inclusion/agregar/{polizaId}', ['as' => 'agregar_poliza_inclusion', 'uses' => 'PolizaInclusionController@agregar']);
	Route::get('Polizas-Inclusion/ver/{inclusionId}', ['as' => 'ver_poliza_inclusion', 'uses' => 'PolizaInclusionController@mostrarVer']);
	Route::get('Polizas-Inclusion/agregar-vehiculo/{inclusionId}', ['as' => 'agregar_poliza_inclusion_vehiculo', 'uses' => 'PolizaInclusionController@mostrarAgregarVehiculo']);
	Route::post('Polizas-Inclusion/agregar-vehiculo/{inclusionId}', ['as' => 'agregar_poliza_inclusion_vehiculo', 'uses' => 'PolizaInclusionController@agregarVehiculo']);
	Route::get('Polizas-Inclusion/agregar-cobertura/{inclusionId}', ['as' => 'agregar_poliza_inclusion_cobertura', 'uses' => 'PolizaInclusionController@mostrarAgregarCobertura']);
	Route::post('Polizas-Inclusion/agregar-cobertura/{inclusionId}', ['as' => 'agregar_poliza_inclusion_cobertura', 'uses' => 'PolizaInclusionController@agregarCobertura']);
	Route::get('Polizas-Inclusion/agregar-cobertura-vehiculo/{inclusionId}/{vehiculoId}', ['as' => 'agregar_poliza_inclusion_cobertura_vehiculo', 'uses' => 'PolizaInclusionController@mostrarAgregarCoberturaVehiculo']);
	Route::post('Polizas-Inclusion/agregar-cobertura-vehiculo/{inclusionId}/{vehiculoId}', ['as' => 'agregar_poliza_inclusion_cobertura_vehiculo', 'uses' => 'PolizaInclusionController@agregarCoberturaVehiculo']);
	Route::get('Polizas-Inclusion/aprobar-solicitud/{inclusionId}', ['as' => 'aprobar_poliza_inclusion', 'uses' => 'PolizaInclusionController@mostrarAprobarSolicitud']);
	Route::post('Polizas-Inclusion/aprobar-solicitud/{inclusionId}', ['as' => 'aprobar_poliza_inclusion', 'uses' => 'PolizaInclusionController@aprobarSolicitud']);

	/* POLIZAS - EXCLUSIONES */
	Route::post('Polizas-Exclusion/agregar/{polizaId}', ['as' => 'agregar_poliza_exclusion', 'uses' => 'PolizaExclusionController@agregar']);
	Route::get('Polizas-Exclusion/ver/{exclusionId}', ['as' => 'ver_poliza_exclusion', 'uses' => 'PolizaExclusionController@mostrarVer']);
	Route::get('Polizas-Exclusion/agregar-vehiculo/{exclusionId}', ['as' => 'agregar_poliza_exclusion_vehiculo', 'uses' => 'PolizaExclusionController@mostrarAgregarVehiculo']);
	Route::post('Polizas-Exclusion/agregar-vehiculo/{exclusionId}', ['as' => 'agregar_poliza_exclusion_vehiculo', 'uses' => 'PolizaExclusionController@agregarVehiculo']);
	Route::post('Polizas-Exclusion/eliminar-vehiculo/{exclusionId}', ['as' => 'eliminar_poliza_exclusion_vehiculo', 'uses' => 'PolizaExclusionController@eliminarVehiculo']);
	Route::get('Polizas-Exclusion/agregar-cobertura/{exclusionId}', ['as' => 'agregar_poliza_exclusion_cobertura', 'uses' => 'PolizaExclusionController@mostrarAgregarCobertura']);
	Route::post('Polizas-Exclusion/agregar-cobertura/{exclusionId}', ['as' => 'agregar_poliza_exclusion_cobertura', 'uses' => 'PolizaExclusionController@agregarCobertura']);
	Route::post('Polizas-Exclusion/eliminar-cobertura/{exclusionId}', ['as' => 'eliminar_poliza_exclusion_cobertura', 'uses' => 'PolizaExclusionController@eliminarCobertura']);
	Route::get('Polizas-Exclusion/agregar-cobertura-vehiculo/{exclusionId}/{vehiculoId}', ['as' => 'agregar_poliza_exclusion_cobertura_vehiculo', 'uses' => 'PolizaExclusionController@mostrarAgregarCoberturaVehiculo']);
	Route::post('Polizas-Exclusion/agregar-cobertura-vehiculo/{exclusionId}/{vehiculoId}', ['as' => 'agregar_poliza_exclusion_cobertura_vehiculo', 'uses' => 'PolizaExclusionController@agregarCoberturaVehiculo']);
	Route::get('Polizas-Exclusion/aprobar-solicitud/{exclusionId}', ['as' => 'aprobar_poliza_exclusion', 'uses' => 'PolizaExclusionController@mostrarAprobarSolicitud']);
	Route::post('Polizas-Exclusion/aprobar-solicitud/{exclusionId}', ['as' => 'aprobar_poliza_exclusion', 'uses' => 'PolizaExclusionController@aprobarSolicitud']);

	/* NOTAS DE CREDITO */
	Route::get('Notas-Credito/agregar/{exclusionId}', ['as' => 'agregar_nota_credito', 'uses' => 'NotaCreditoController@mostrarAgregar']);
	Route::post('Notas-Credito/agregar/{exclusionId}', ['as' => 'agregar_nota_credito', 'uses' => 'NotaCreditoController@agregar']);
	Route::get('Notas-Credito/editar/{id}', ['as' => 'editar_nota_credito', 'uses' => 'NotaCreditoController@mostrarEditar']);
	Route::post('Notas-Credito/editar/{id}', ['as' => 'editar_nota_credito', 'uses' => 'NotaCreditoController@editar']);
	

	/* POLIZAS - COBERTURA */
	Route::get('Polizas-Coberturas/agregar-producto/{polizaId}/{productoId}',['as' => 'agregar_poliza_producto', 'uses' => 'PolizaCoberturaController@mostrarAgregarProducto']);
	Route::post('Polizas-Coberturas/agregar-producto/{polizaId}/{productoId}',['as' => 'agregar_poliza_producto', 'uses' => 'PolizaCoberturaController@agregarProducto']);	
	Route::get('Polizas-Coberturas/agregar/{polizaId}',['as' => 'agregar_poliza_cobertura', 'uses' => 'PolizaCoberturaController@mostrarAgregar']);
	Route::post('Polizas-Coberturas/agregar/{polizaId}',['as' => 'agregar_poliza_cobertura', 'uses' => 'PolizaCoberturaController@agregar']);
	Route::get('Polizas-Coberturas/editar/{id}', ['as' => 'editar_poliza_cobertura', 'uses' => 'PolizaCoberturaController@mostrarEditar']);	
	Route::put('Polizas-Coberturas/editar/{id}', ['as' => 'editar_poliza_cobertura', 'uses' => 'PolizaCoberturaController@editar']);
	Route::delete('Polizas-Coberturas/eliminar', ['as' => 'eliminar_poliza_cobertura', 'uses' => 'PolizaCoberturaController@eliminar']);

	/* POLIZAS - REQUERIMIENTO */
	Route::post('Polizas-Requerimientos/generar/{polizaId}', ['as' => 'generar_poliza_requerimiento', 'uses' => 'PolizaRequerimientoController@generarRequerimientos']);
	Route::get('Polizas-Requerimientos/agregar/{polizaId}', ['as' => 'agregar_poliza_requerimiento', 'uses' => 'PolizaRequerimientoController@mostrarAgregar']);
	Route::post('Polizas-Requerimientos/agregar/{polizaId}', ['as' => 'agregar_poliza_requerimiento', 'uses' => 'PolizaRequerimientoController@agregar']);
	Route::get('Polizas-Requerimientos/editar/{id}', ['as' => 'editar_poliza_requerimiento', 'uses' => 'PolizaRequerimientoController@mostrarEditar']);	
	Route::put('Polizas-Requerimientos/editar/{id}', ['as' => 'editar_poliza_requerimiento', 'uses' => 'PolizaRequerimientoController@editar']);
	Route::put('Polizas-Requerimientos/anular', ['as' => 'anular_poliza_requerimiento', 'uses' => 'PolizaRequerimientoController@anular']);
	Route::get('Polizas-Requerimientos/pendientes', ['as' => 'requerimientos_pendientes', 'uses' => 'PolizaRequerimientoController@mostrarPendientes']);
	Route::get('Polizas-Requerimientos/no-cobrados-mes', ['as' => 'requerimientos_no_cobrados_mes', 'uses' => 'PolizaRequerimientoController@mostrarNoCobradosPorMes']);

	Route::get('Pago-Requerimiento/agregar/{polizaId}', ['as' => 'agregar_pago_requerimiento', 'uses' => 'PagoRequerimientoController@mostrarAgregar']);
	Route::post('Pago-Requerimiento/agregar/{polizaId}', ['as' => 'agregar_pago_requerimiento', 'uses' => 'PagoRequerimientoController@agregar']);

	/* PORCENTAJES DE FRACCIONAMIENTO GENERALES */
	Route::get('Porcentajes-Fraccionamientos-Generales/listado', ['as' => 'porcentajes_fraccionamientos_generales', 'uses' => 'PorcentajeFraccionamientoGeneralController@listado']);
	Route::get('Porcentajes-Fraccionamientos-Generales/agregar', ['as' => 'agregar_porcentaje_fraccionamiento_general', 'uses' => 'PorcentajeFraccionamientoGeneralController@mostrarAgregar']);	
	Route::post('Porcentajes-Fraccionamientos-Generales/agregar', ['as' => 'agregar_porcentaje_fraccionamiento_general', 'uses' => 'PorcentajeFraccionamientoGeneralController@agregar']);	
	Route::get('Porcentajes-Fraccionamientos-Generales/editar/{id}', ['as' => 'editar_porcentaje_fraccionamiento_general', 'uses' => 'PorcentajeFraccionamientoGeneralController@mostrarEditar']);	
	Route::put('Porcentajes-Fraccionamientos-Generales/editar/{id}', ['as' => 'editar_porcentaje_fraccionamiento_general', 'uses' => 'PorcentajeFraccionamientoGeneralController@editar']);

	/* PORCENTAJES DE FRACCIONAMIENTO POR ASEGURADORA */
	Route::get('Porcentajes-Fraccionamientos-Aseguradora/listado/{aseguradoraId}', ['as' => 'porcentajes_fraccionamientos_aseguradoras', 'uses' => 'PorcentajeFraccionamientoAseguradoraController@listado']);
	Route::get('Porcentajes-Fraccionamientos-Aseguradora/agregar/{aseguradoraId}', ['as' => 'agregar_porcentaje_fraccionamiento_aseguradora', 'uses' => 'PorcentajeFraccionamientoAseguradoraController@mostrarAgregar']);	
	Route::post('Porcentajes-Fraccionamientos-Aseguradora/agregar/{aseguradoraId}', ['as' => 'agregar_porcentaje_fraccionamiento_aseguradora', 'uses' => 'PorcentajeFraccionamientoAseguradoraController@agregar']);	
	Route::get('Porcentajes-Fraccionamientos-Aseguradora/editar/{id}', ['as' => 'editar_porcentaje_fraccionamiento_aseguradora', 'uses' => 'PorcentajeFraccionamientoAseguradoraController@mostrarEditar']);	
	Route::put('Porcentajes-Fraccionamientos-Aseguradora/editar/{id}', ['as' => 'editar_porcentaje_fraccionamiento_aseguradora', 'uses' => 'PorcentajeFraccionamientoAseguradoraController@editar']);

});


Route::get('login', ['as' => 'login', 'uses' => 'AuthController@mostrarLogin']);
Route::post('login', ['as' => 'login', 'uses' => 'AuthController@login']);


/* AJAX */
Route::get('ajax/puestos/{id}', ['as' => 'ajax_puestos', 'uses' => 'ColaboradorController@ajaxPuestosByDepartamento']);
Route::get('ajax/departamentos-pais/{paisId}', ['as' => 'ajax_departamentos_pais', 'uses' => 'DepartamentoController@ajaxByPais']);
Route::get('ajax/municipios-departamento/{departamentoId}', ['as' => 'ajax_municipos_departamento', 'uses' => 'MunicipioController@ajaxByDepartamento']);

