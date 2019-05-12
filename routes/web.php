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

Route::get('/', function () {
    return view('dashboard');
});

// Clientes
Route::resource('cliente', 'ClientController')->except([
    'create', 'show'
]);
Route::get('/cliente/folio', 'ClientController@folio');
Route::get('/cliente/selectCliente', 'ClientController@selectCliente');

// Articulos
Route::resource('articulo', 'ItemController')->except([
    'create', 'show'
]);
Route::get('/articulo/folio', 'ItemController@folio');
Route::get('/articulo/buscarArticulo', 'ItemController@buscarArticuloVenta');

//Venta
Route::get('/venta', 'VentaController@index');
Route::post('/venta/registrar', 'VentaController@agregar');
Route::get('/venta/folio', 'VentaController@folio');

// Configuracio
Route::get('/confi/listar', 'ConfigurationController@index');
Route::get('/confi', 'ConfigurationController@edit');
Route::post('/confi', 'ConfigurationController@store');
Route::patch('/confi/{confi}/edit', 'ConfigurationController@update');

Route::get('/autocomplete/fetch', 'SaleController@fetch')->name('autocomplete.fetch');