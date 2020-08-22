<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'guest'], function () { 
	Route::get('/', function () {
	    return view('auth.login');
	});
	Auth::routes();
}); 

Route::get('sap/trabajadores-request', 'TrabajadorController@sincronizar_sap');

Route::group(['middleware' => 'auth'], function(){
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('logout', 'Auth\LoginController@logout');

	Route::get('usuarios/web', 'UsuarioWebController@create');	
	Route::post('usuarios/web/guardar', 'UsuarioWebController@store');	
	Route::post('usuarios/web/eliminar', 'UsuarioWebController@delete');	
	Route::post('usuarios/web/listar', 'UsuarioWebController@listar');	

	Route::get('usuarios/movil', 'UsuarioMovilController@create');	
	Route::post('usuarios/movil/guardar', 'UsuarioMovilController@store');	
	Route::post('usuarios/movil/eliminar', 'UsuarioMovilController@delete');	
	Route::post('usuarios/movil/listar', 'UsuarioMovilController@listar');	
	Route::post('usuarios/movil/manual', 'UsuarioMovilController@manual');

	Route::get('viajes/programar', 'ViajeController@programar');
	Route::post('viajes/programar', 'ViajeController@guardar_programacion');

	Route::get('viajes/programar/importar', 'ViajeController@importar');
	Route::get('viajes/plantilla/descargar', 'ViajeController@descargar');
	Route::post('viajes/plantilla/subir', 'ViajeController@subir');

	Route::get('viajes/programados', 'ViajeController@programados');
	Route::post('viajes/programados/eliminar', 'ViajeController@eliminar_programado');
	Route::post('viajes/programados/editar', 'ViajeController@editar_programado');
	Route::get('viajes/programados/copiar', 'ViajeController@copiar');
	Route::post('viajes/programados/copiar', 'ViajeController@copiar_programados');
	Route::get('viajes/programados/{id}', 'ViajeController@buscar_programado');
	Route::post('viajes/realizados/editar', 'ViajeController@editar_realizado');

	Route::post('viajes/validacion/getTrabajador', 'ViajeController@getTrabajador');
	Route::post('viajes/validacion/trabajador/delete', 'ViajeController@deleteTrabajador');
	Route::post('viajes/validacion/trabajador/addHorario', 'ViajeController@addHorario');
	Route::post('viajes/validacion/trabajador/editHorario', 'ViajeController@editHorario');

	Route::get('viajes/programados/{idEmpresa}/{idCentroCosto}/{idTransportista}/{idRuta}/{idVehiculo}/{desde}/{hasta}', 'ViajeController@programados_filtros');

	Route::post('viajes/asignar-conductor-placa', 'ViajeController@asignar_conductor_placa');

	Route::get('conductor/{string}', 'ConductorController@search_by_string');

	Route::get('vehiculo/{string}/{id}', 'VehiculoController@search_by_string');

	Route::get('reportes/viaje-personal', 'ReporteController@viaje_personal');
	Route::get('reportes/viajes', 'ReporteController@viajes');
	Route::get('reportes/viajes/manifiesto/{idViaje}', 'PDFController@manifiestoPDF');
	Route::get('reportes/viajes-liquidacion', 'ReporteController@liquidacion');
	Route::get('reportes/viajes/detalle/{id}', 'ReporteController@viaje_detalle');
	Route::get('reportes/viajes/tracking/{id}', 'ReporteController@viaje_tracking');

	Route::get('tracking_iframe/{id}', 'ReporteController@tracking');	
	
	Route::get('reportes/liquidacion/pdf/{idEmpresa}/{idCentroCosto}/{idTransportista}/{idRuta}/{idTipoViaje}/{desde}/{hasta}/{sp_name}', 'PDFController@liqui_pdf');
	Route::get('reportes/manifiesto/pdf/{idEmpresa}/{idCentroCosto}/{idTransportista}/{idRuta}/{idTipoViaje}/{desde}/{hasta}/{sp_name}', 'PDFController@manifiesto_pdf');

	Route::post('reportes/filtrar/{idEmpresa}/{idCentroCosto}/{idTransportista}/{idRuta}/{idTipoTarifa}/{desde}/{hasta}/{sp_name}', 'ReporteController@filtrar');

	Route::get('mantenimiento/trabajador/{ndoc}', 'TrabajadorController@search');

	//centro costos
	Route::get('mantenimiento/centro-costos', 'CentroCostoController@index');	
	Route::get('mantenimiento/centro-costos/listar', 'CentroCostoController@listar');	
	Route::get('mantenimiento/centro-costo', 'CentroCostoController@show');	
	Route::post('mantenimiento/centro-costo', 'CentroCostoController@store');
	Route::post('mantenimiento/centro-costo/delete', 'CentroCostoController@delete');

	Route::get('mantenimiento/proveedores', 'ProveedorController@index');	
	Route::get('mantenimiento/proveedores/listar', 'ProveedorController@listar');	
	Route::get('mantenimiento/proveedor', 'ProveedorController@show');	
	Route::post('mantenimiento/proveedor', 'ProveedorController@store');
	Route::post('mantenimiento/proveedor/delete', 'ProveedorController@delete');

	Route::get('mantenimiento/conductores', 'ConductorController@index');	
	Route::get('mantenimiento/conductores/listar', 'ConductorController@listar');	
	Route::get('mantenimiento/conductor', 'ConductorController@show');	
	Route::post('mantenimiento/conductor', 'ConductorController@store');
	Route::post('mantenimiento/conductor/delete', 'ConductorController@delete');

	Route::get('mantenimiento/vehiculos', 'VehiculoController@index');	
	Route::get('mantenimiento/vehiculos/listar', 'VehiculoController@listar');	
	Route::get('mantenimiento/vehiculo', 'VehiculoController@show');	
	Route::post('mantenimiento/vehiculo', 'VehiculoController@store');
	Route::post('mantenimiento/vehiculo/delete', 'VehiculoController@delete');
	Route::get('mantenimiento/vehiculos/tipo-vehiculos', 'VehiculoController@listarTipoVehiculos');	
	Route::post('mantenimiento/vehiculos/tipo-vehiculo', 'VehiculoController@storeTipoVehiculo');	
	Route::post('mantenimiento/vehiculos/tipo-vehiculo/delete', 'VehiculoController@deleteTipoVehiculo');	

	Route::get('mantenimiento/rutas', 'RutaController@index');	
	Route::get('mantenimiento/rutas/listar', 'RutaController@listar');	
	Route::get('mantenimiento/rutas/origenes', 'RutaController@getOrigenesByTransportista');	
	Route::get('mantenimiento/rutas/destinos', 'RutaController@getDestinosByTransportista');	
	Route::get('mantenimiento/ruta', 'RutaController@show');	
	Route::post('mantenimiento/ruta', 'RutaController@store');
	Route::post('mantenimiento/ruta/delete', 'RutaController@delete');

	Route::get('mantenimiento/tarifas', 'TarifaController@index');	
	Route::get('mantenimiento/tarifas/listar', 'TarifaController@listar');	
	Route::get('mantenimiento/tarifa', 'TarifaController@show');	
	Route::post('mantenimiento/tarifa', 'TarifaController@store');
	Route::post('mantenimiento/tarifa/delete', 'TarifaController@delete');
	Route::get('mantenimiento/tarifas/tipo-tarifas', 'TarifaController@listarTipoTarifas');	
	Route::post('mantenimiento/tarifas/tipo-tarifa', 'TarifaController@storeTipoTarifa');	
	Route::post('mantenimiento/tarifas/tipo-tarifa/delete', 'TarifaController@deleteTipoTarifa');	

	Route::get('mantenimiento/trabajadores', 'TrabajadorController@index');	
	Route::get('mantenimiento/trabajadores/listar', 'TrabajadorController@listar');	

	Route::get('mantenimiento/sincronizacion', function ()
	{
		return view('mantenimiento.sincronizacion');
	});	

});
