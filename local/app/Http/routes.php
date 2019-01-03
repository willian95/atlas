<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function(){
	return view('login');
});

Route::post('/login', 'authController@login');
Route::get('/logout', 'authController@logout');

Route::group(['middleware' => ['admin']], function(){


/********************************** Gerencias *****************************************/

Route::get('/gerencias', 'gerenciasController@vista');
Route::post('/crear_gerencia', 'gerenciasController@crear');
Route::post('/editar_gerencia/{id}', 'gerenciasController@editar');
Route::post('/eliminar_gerencia/{id}', 'gerenciasController@eliminar');

/********************************** Fin Gerencias *****************************************/

/********************************** Unidades *****************************************/

Route::get('/unidades', 'unidadesController@vista');
Route::post('/crear_unidad', 'unidadesController@crear');
Route::post('/editar_unidad/{id}', 'unidadesController@editar');
Route::post('/eliminar_unidad/{id}', 'unidadesController@eliminar');

/********************************** Fin Unidades *****************************************/

/********************************** Bienes *****************************************/

Route::get('/bienes', 'bienesController@vista');
Route::get('/bienes_unidades/{id}', 'bienesController@unidades');
Route::post('/crear_bien', 'bienesController@crear');
Route::post('/importar_archivo', 'bienesController@importar_archivo');
Route::post('/editar_bien/{id}', 'bienesController@editar');
Route::post('/eliminar_bien/{id}', 'bienesController@eliminar');
Route::post('/buscar_bien', 'bienesController@buscar');
Route::post('/buscar_bienes', 'bienesController@buscar_bienes');
Route::post('/buscar_bien_gerente/{id}', 'bienesController@buscar_gerente');

/********************************** Fin Bienes *****************************************/

/********************************** Usuarios *****************************************/

Route::get('/usuarios', 'usuariosController@vista');
Route::post('/crear_usuario', 'usuariosController@crear');
Route::post('/editar_usuario/{id}', 'usuariosController@editar');
Route::post('/eliminar_usuario/{id}', 'usuariosController@eliminar');

/********************************** Fin Usuarios *****************************************/

/********************************** Traslados *****************************************/

Route::get('/traslados_gerente', 'trasladosController@vistaGerente');
Route::get('/traslados_buscar/{texto}/{tipo}', 'trasladosController@buscarBienes');
Route::get('/buscar_bien_traslado/{id}', 'trasladosController@buscar');
Route::post('/trasladar/{unidad_fin}', 'trasladosController@trasladar');
Route::get('/traslados/notificaciones', 'trasladosController@notificaciones');
Route::get('/traslados/historial', 'trasladosController@historial');
Route::get('/nota_entrega/{traslado}', 'trasladosController@notas_entrega');
Route::post('/nota_rechazo/{traslado}', 'trasladosController@notas_rechazo');

/********************************** Fin Traslados *****************************************/

/********************************** Requisiciones *****************************************/

Route::get('/requisiciones', 'requisicionesController@vista');
Route::get('/requisiciones_administrador', 'requisicionesController@administrador_vista');
Route::get('/requisiciones_historial', 'requisicionesController@historial');
Route::post('/crear_requisicion', 'requisicionesController@crear');
Route::get('/requisicion_pdf/{id}', 'requisicionesController@pdf');
Route::get('/compras/{id}', 'requisicionesController@compra');
Route::get('/ver_articulo/{id}', 'requisicionesController@ver_articulo');
Route::get('/requisiones/contarRequisiciones', 'requisicionesController@contar_requisiciones');

/********************************** Fin Reqquisiciones *****************************************/

/********************************** Orden Compra *****************************************/

Route::get('/orden_compra/{requisicion}', 'ordenesCompraController@vista');
Route::get('/ordenes_compra_administrador', 'ordenesCompraController@vistaAdministrador');
Route::post('/orden_compra/registrar/{id}', 'ordenesCompraController@registrarCompra');
Route::get('/get/proveedores/{id}', 'ordenesCompraController@getProveedores');
Route::get('/orden_compra/pdf/{id}', 'ordenesCompraController@ordenCompraPdf');

/********************************** Fin Reqquisiciones *****************************************/

/********************************** Etiquetas *****************************************/

Route::get('/reportes', 'reportesController@vista');
Route::post('/reporte_unidad', 'reportesController@etiquetas_unidad');
Route::post('/reporte_gerencia', 'reportesController@etiquetas_gerencia');

/********************************** Fin Etiquetas *****************************************/

/********************************** Historial *****************************************/

Route::get('/historial', 'historialController@vista');
Route::get('/historial/registro', 'historialController@vistaRegistro');
Route::post('/historial/registrar', 'historialController@registrar');
Route::post('/historial/filtrar_fecha', 'historialController@buscarFecha');

Route::get('/historial/administrador', 'historialController@vistaAdministrador');
Route::post('/historial/administrador/filtrar_fecha', 'historialController@buscarFechaAdministrador');

/********************************** Fin Historial *****************************************/

/********************************** Reportes *****************************************/

Route::get('/reportes_pdf', 'reportesController@vista_pdf');
Route::post('/reportes_pdf_unidad', 'reportesController@reportes_unidad');
Route::post('/reportes_pdf_gerencia', 'reportesController@reportes_gerencia');

/********************************** Fin Reportes *****************************************/

/********************************** Notificaciones *****************************************/

Route::get('/notificaciones', 'notificacionesController@vista');

/********************************** Fin Notificaciones *****************************************/

/********************************** Planificacion Semanal *****************************************/

Route::get('/planificacionSemanal', 'planificacionSemanalController@vista');
Route::get('/planificacionSemanal/administrador', 'planificacionSemanalController@vistaAdministrador');
Route::post('/planificacionSemanal/administrador/reporte', 'planificacionSemanalController@generarReporte');
Route::get('/planificacionSemanal/administrador/actividades/{id}', 'planificacionSemanalController@vistaAdministradorActividades');
Route::post('/planificacionSemanal/registrar/poa', 'planificacionSemanalController@registrarPoa');
Route::post('/planificacionSemanal/registrar/semanal', 'planificacionSemanalController@registrarSemanal');
Route::get('/planificacionSemanal/editarPoa/{id}', 'planificacionSemanalController@editarPoa');
/********************************** Fin Notificaciones *****************************************/

});
