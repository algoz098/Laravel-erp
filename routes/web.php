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

Route::get('/home', 'HomeController@index')->middleware('auth');
Route::get('/contatos', 'ContatosController@show')->middleware('auth');
Route::get('/contatos/novo', 'ContatosController@showNovo')->middleware('auth');
Route::post('/contatos/novo/{id}', 'ContatosController@update')->middleware('auth');
Route::post('/contatos/novo', 'ContatosController@novo')->middleware('auth');
Route::get('/contatos/{id}', 'ContatosController@showId')->middleware('auth');


Route::get('/admin', 'AdminController@index')->middleware('auth');
