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

Route::get('/',[
	'as' => '/', 'uses' => 'HomeController@index'
]);

Route::resource('payloaders','PayloadersController');

Route::get('payloaders.create', [
	'as' => 'payloaders.create', 'uses' => 'PayloadersController@create'
]);

Route::get('payloaders.edit.{id}', [
	'as' => 'payloaders.edit', 'uses' => 'PayloadersController@edit'
]);

Route::get('payloaders.precios.{id}', [
	'as' => 'payloaders.precios', 'uses' => 'PayloadersController@precios'
]);

Route::get('payloaders.create_precio.{id}', [
	'as' => 'payloaders.create_precio', 'uses' => 'PayloadersController@createPrecio'
]);

Route::post('payloaders.store_precio', [
	'as' => 'payloaders.store_precio', 'uses' => 'PayloadersController@storePrecio'
]);

Route::get('payloaders.edit_precio.{id}', [
	'as' => 'payloaders.edit_precio', 'uses' => 'PayloadersController@editPrecio'
]);

Route::put('payloaders.update_precio.{id}', [
	'as' => 'payloaders.update_precio', 'uses' => 'PayloadersController@updatePrecio'
]);

Route::post('payloaders.store', [
	'as' => 'payloaders.store', 'uses' => 'PayloadersController@store'
]);

Route::put('payloaders.update.{id}', [
	'as' => 'payloaders.update', 'uses' => 'PayloadersController@update'
]);

Route::get('payloaders.destroy.{id}', [
	'as' => 'payloaders.destroy', 'uses' => 'PayloadersController@destroy'
]);

Route::get('payloaders.tabla', [
	'as' => 'payloaders.tabla', 'uses' => 'PayloadersController@tablaPrecios'
]);

Route::resource('corrugados','CorrugadosController');

Route::get('corrugados.create', [
	'as' => 'corrugados.create', 'uses' => 'CorrugadosController@create'
]);

Route::get('corrugados.edit.{id}', [
	'as' => 'corrugados.edit', 'uses' => 'CorrugadosController@edit'
]);

Route::post('corrugados.store', [
	'as' => 'corrugados.store', 'uses' => 'CorrugadosController@store'
]);

Route::put('corrugados.update.{id}', [
	'as' => 'corrugados.update', 'uses' => 'CorrugadosController@update'
]);

Route::get('corrugados.destroy.{id}', [
	'as' => 'corrugados.destroy', 'uses' => 'CorrugadosController@destroy'
]);
//verifica que existan cantidades en la base de datos
Route::get('corrugados.verificar_cant', [
	'as' => 'corrugados.verificar_cant', 'uses' => 'CorrugadosController@cantidades'
]);
Route::get('corrugados.precios.{id}', [
	'as' => 'corrugados.precios', 'uses' => 'CorrugadosController@precios'
]);

Route::get('corrugados.create_precio.{id}', [
	'as' => 'corrugados.create_precio', 'uses' => 'CorrugadosController@createPrecio'
]);

Route::post('corrugados.store_precio', [
	'as' => 'corrugados.store_precio', 'uses' => 'CorrugadosController@storePrecio'
]);

Route::get('corrugados.edit_precio.{id}', [
	'as' => 'corrugados.edit_precio', 'uses' => 'CorrugadosController@editPrecio'
]);

Route::put('corrugados.update_precio.{id}', [
	'as' => 'corrugados.update_precio', 'uses' => 'CorrugadosController@updatePrecio'
]);

Route::get('corrugados.tabla', [
	'as' => 'corrugados.tabla', 'uses' => 'CorrugadosController@tablaPrecios'
]);

Route::get('cantidades.create', [
	'as' => 'cantidades.create', 'uses' => 'CorrugadosController@createCantidades'
]);

Route::post('cantidades.store', [
	'as' => 'cantidades.store', 'uses' => 'CorrugadosController@storeCantidades'
]);

Route::resource('agregados','AgregadosController');

Route::get('agregados.create', [
	'as' => 'agregados.create', 'uses' => 'AgregadosController@create'
]);

Route::get('agregados.edit.{id}', [
	'as' => 'agregados.edit', 'uses' => 'AgregadosController@edit'
]);

Route::post('agregados.store', [
	'as' => 'agregados.store', 'uses' => 'AgregadosController@store'
]);

Route::put('agregados.update.{id}', [
	'as' => 'agregados.update', 'uses' => 'AgregadosController@update'
]);

Route::get('agregados.destroy.{id}', [
	'as' => 'agregados.destroy', 'uses' => 'AgregadosController@destroy'
]);

Route::get('agregados.precios.{id}', [
	'as' => 'agregados.precios', 'uses' => 'AgregadosController@precios'
]);

Route::get('agregados.create_precio.{id}', [
	'as' => 'agregados.create_precio', 'uses' => 'AgregadosController@createPrecio'
]);

Route::post('agregados.store_precio', [
	'as' => 'agregados.store_precio', 'uses' => 'AgregadosController@storePrecio'
]);

Route::get('agregados.edit_precio.{id}', [
	'as' => 'agregados.edit_precio', 'uses' => 'AgregadosController@editPrecio'
]);

Route::put('agregados.update_precio.{id}', [
	'as' => 'agregados.update_precio', 'uses' => 'AgregadosController@updatePrecio'
]);

Route::get('clientes', [
	'as' => 'clientes', 'uses' => 'ClientesController@index'
]);

Route::get('cotizaciones_corrugado', [
	'as' => 'cotizaciones_corrugado', 'uses' => 'CotizacionesCorrugadosController@index'
]);

Route::get('cotizaciones_corrugado.create', [
	'as' => 'cotizaciones_corrugado.create', 'uses' => 'CotizacionesCorrugadosController@create'
]);

Route::post('cotizaciones_corrugado.store', [
	'as' => 'cotizaciones_corrugado.store', 'uses' => 'CotizacionesCorrugadosController@store'
]);

Route::get('cotizaciones_corrugado.pdf.{id}', [
	'as' => 'cotizaciones_corrugado.pdf', 'uses' => 'CotizacionesCorrugadosController@getPdf'
]);

Route::get('cotizaciones_corrugado.edit.{id}', [
	'as' => 'cotizaciones_corrugado.edit', 'uses' => 'CotizacionesCorrugadosController@edit'
]);

Route::put('cotizaciones_corrugado.update.{id}', [
	'as' => 'cotizaciones_corrugado.update', 'uses' => 'CotizacionesCorrugadosController@update'
]);

Route::get('cotizaciones_payloaders', [
	'as' => 'cotizaciones_payloaders', 'uses' => 'CotizacionesPayloadersController@index'
]);

Route::get('cotizaciones_payloaders.create', [
	'as' => 'cotizaciones_payloaders.create', 'uses' => 'CotizacionesPayloadersController@create'
]);

Route::post('cotizaciones_payloaders.store', [
	'as' => 'cotizaciones_payloaders.store', 'uses' => 'CotizacionesPayloadersController@store'
]);

Route::get('cotizaciones_payloaders.pdf.{id}', [
	'as' => 'cotizaciones_payloaders.pdf', 'uses' => 'CotizacionesPayloadersController@getPdf'
]);

Route::get('cotizaciones_payloaders.edit.{id}', [
	'as' => 'cotizaciones_payloaders.edit', 'uses' => 'CotizacionesPayloadersController@edit'
]);

Route::put('cotizaciones_payloaders.update.{id}', [
	'as' => 'cotizaciones_payloaders.update', 'uses' => 'CotizacionesPayloadersController@update'
]);


//ordenes de compra de corrugado
Route::get('ordenescompra_corrugado', [
	'as' => 'ordenescompra_corrugado', 'uses' => 'OrdenesCompraCorrugadoController@index'
]);

Route::get('ordenescompra_corrugado.create.{cotizacion_id}', [
	'as' => 'ordenescompra_corrugado.create', 'uses' => 'OrdenesCompraCorrugadoController@create'
]);

Route::post('ordenescompra_corrugado.store.{cotizacion_id}', [
	'as' => 'ordenescompra_corrugado.store', 'uses' => 'OrdenesCompraCorrugadoController@store'
]);

Route::get('ordenescompra_corrugado.pdf.{id}', [
	'as' => 'ordenescompra_corrugado.pdf', 'uses' => 'OrdenesCompraCorrugadoController@getPdf'
]);

Route::get('ordenescompra_corrugado.edit.{id}', [
	'as' => 'ordenescompra_corrugado.edit', 'uses' => 'OrdenesCompraCorrugadoController@edit'
]);

Route::put('ordenescompra_corrugado.update.{id}', [
	'as' => 'ordenescompra_corrugado.update', 'uses' => 'OrdenesCompraCorrugadoController@update'
]);

Route::get('ordenescompra_corrugado.pdf.{id}', [
	'as' => 'ordenescompra_corrugado.pdf', 'uses' => 'OrdenesCompraCorrugadoController@getPdf'
]);

//ordenes de compra de payloaders
Route::get('ordenescompra_payloaders', [
	'as' => 'ordenescompra_payloaders', 'uses' => 'OrdenesCompraPayloaderController@index'
]);

Route::get('ordenescompra_payloaders.create.{cotizacion_id}', [
	'as' => 'ordenescompra_payloaders.create', 'uses' => 'OrdenesCompraPayloaderController@create'
]);

Route::post('ordenescompra_payloaders.store.{cotizacion_id}', [
	'as' => 'ordenescompra_payloaders.store', 'uses' => 'OrdenesCompraPayloaderController@store'
]);

Route::get('ordenescompra_payloaders.pdf.{id}', [
	'as' => 'ordenescompra_payloaders.pdf', 'uses' => 'OrdenesCompraPayloaderController@getPdf'
]);

Route::get('ordenescompra_payloaders.edit.{id}', [
	'as' => 'ordenescompra_payloaders.edit', 'uses' => 'OrdenesCompraPayloaderController@edit'
]);

Route::put('ordenescompra_payloaders.update.{id}', [
	'as' => 'ordenescompra_payloaders.update', 'uses' => 'OrdenesCompraPayloaderController@update'
]);