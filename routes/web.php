<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@index');

Auth::routes();

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/clientes', 'ClientesController@show')->middleware('auth');
Route::get('/clientes/novo', 'ClientesController@showNovo');
Route::post('/clientes/novo/{id}', 'ClientesController@update');
Route::post('/clientes/novo', 'ClientesController@novo');
Route::get('/clientes/{id}', 'ClientesController@showId');
