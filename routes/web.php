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

Route::get('/home', 'HomeController@index')->middleware('auth');
Route::get('/lista/contatos', 'ContatosController@show')->name('contatos')->middleware('auth');
Route::post('lista/contatos', 'ContatosController@search')->middleware('auth');
Route::post('lista/contatos/{id}/attach', 'ContatosController@attach')->middleware('auth');
Route::get('lista/contatos/delete/{id}', 'ContatosController@delete')->middleware('auth');
Route::get('lista/contatos/{id}/telefones', 'ContatosController@telefones')->middleware('auth');
Route::post('lista/contatos/{id}/telefones', 'ContatosController@telefones_new')->middleware('auth');
Route::post('lista/contatos/{id}/telefones/{id_tel}', 'ContatosController@telefones_post')->middleware('auth');
Route::get('lista/contatos/{id}/telefones/{id_tel}', 'ContatosController@telefones_get')->middleware('auth');
Route::get('lista/contatos/{id}/telefones/{id_tel}/delete', 'ContatosController@telefones_delete')->middleware('auth');
Route::post('/novo/contatos', 'ContatosController@novo')->middleware('auth');
Route::get('/novo/contatos', 'ContatosController@showNovo')->middleware('auth');
Route::get('novo/contatos/{id}', 'ContatosController@showId')->middleware('auth');
Route::post('novo/contatos/{id}', 'ContatosController@update')->middleware('auth');

Route::get('lista/contatos/{id}/relacoes', 'ContatosController@relacoes')->middleware('auth');
Route::get('lista/contatos/{id}/relacoes/novo', 'ContatosController@relacoes_novo')->middleware('auth');
Route::post('lista/contatos/{id}/relacoes/novo/busca', 'ContatosController@relacoes_busca')->middleware('auth');
Route::post('lista/contatos/{id}/relacoes/novo', 'ContatosController@relacoes_post')->middleware('auth');
Route::get('lista/contatos/{id}/relacoes/{id_relacao}', 'ContatosController@relacoes_edit')->middleware('auth');
Route::get('lista/contatos/{id}/relacoes/{id_relacao}/delete', 'ContatosController@relacoes_delete')->middleware('auth');

Route::get('lista/contas', 'ContasController@index')->middleware('auth');
Route::post('lista/contas', 'ContasController@search')->middleware('auth');
Route::get('lista/contas/{id}/pago', 'ContasController@pago')->middleware('auth');
Route::get('lista/contas/{id}/delete', 'ContasController@delete')->middleware('auth');
Route::get('novo/contas', 'ContasController@novo')->middleware('auth');
Route::post('novo/contas/busca', 'ContasController@searchContatos')->middleware('auth');
Route::post('novo/contas', 'ContasController@add')->middleware('auth');
Route::get('novo/contas/{id}', 'ContasController@add_2')->middleware('auth');
Route::post('novo/contas/{id}/parcelas', 'ContasController@add_3')->middleware('auth');
Route::post('novo/contas/{id}/parcelas/{conta_id}', 'ContasController@add_4')->middleware('auth');

Route::get('/lista/atendimentos', 'AtendimentoController@index')->middleware('auth')->name('atendimentos');
Route::post('/lista/atendimentos/{id}/attach', 'AtendimentoController@attach')->middleware('auth');
Route::post('lista/atendimentos', 'AtendimentoController@search')->middleware('auth');
Route::get('lista/atendimentos/{id}/delete', 'AtendimentoController@delete')->middleware('auth');
Route::get('lista/atendimentos/{id}/edit', 'AtendimentoController@edit')->middleware('auth');
Route::post('novo/atendimentos/', 'AtendimentoController@add')->middleware('auth');
Route::get('/novo/atendimentos', 'AtendimentoController@new_a')->middleware('auth');
Route::post('novo/atendimentos/busca', 'AtendimentoController@searchContatos')->middleware('auth');
Route::get('novo/atendimentos/{id}', 'AtendimentoController@show')->middleware('auth');
Route::post('novo/atendimentos/{id}', 'AtendimentoController@edit')->middleware('auth');

Route::get('lista/estoque', 'EstoqueController@index')->middleware('auth');
Route::post('lista/estoque', 'EstoqueController@search')->middleware('auth');
Route::get('lista/estoque/{id}/delete', 'EstoqueController@delete')->middleware('auth');
Route::get('lista/estoque/{id}/up', 'EstoqueController@up')->middleware('auth');
Route::get('lista/estoque/{id}/down', 'EstoqueController@down')->middleware('auth');
Route::get('lista/estoque/{id}/editar', 'EstoqueController@edit')->middleware('auth');
Route::post('lista/estoque/{id}/editar', 'EstoqueController@edit_save')->middleware('auth');
Route::get('novo/estoque', 'EstoqueController@novo')->middleware('auth');
Route::post('novo/estoque', 'EstoqueController@save')->middleware('auth');
Route::post('novo/estoque/busca', 'EstoqueController@searchContatos')->middleware('auth');

Route::get('lista/caixa', 'CaixasController@index')->middleware('auth');
Route::post('lista/caixa', 'CaixasController@search')->middleware('auth');
Route::get('lista/caixa/fechar', 'CaixasController@fechar')->middleware('auth');
Route::get('lista/caixa/fechar/{id}', 'CaixasController@pendencias')->middleware('auth');
Route::get('lista/caixa/fechar/{id}/concluir', 'CaixasController@concluir')->middleware('auth');
Route::post('lista/caixa/fechar/{id}/movs/{id_mov}', 'CaixasController@prestacao')->middleware('auth');
Route::get('lista/caixa/{id}/delete', 'CaixasController@delete')->middleware('auth');
Route::get('novo/caixa', 'CaixasController@new_a')->middleware('auth');
Route::post('novo/caixa', 'CaixasController@new_do')->middleware('auth');

Route::get('lista/vendas', 'VendasController@index')->middleware('auth');
Route::get('novo/vendas', 'VendasController@novo')->middleware('auth');
Route::get('novo/vendas/{id}', 'VendasController@produtos')->middleware('auth');
Route::post('novo/vendas/{id}', 'VendasController@confirmar')->middleware('auth');
Route::post('novo/vendas/{id}/salvar', 'VendasController@salvar')->middleware('auth');

Route::get('attach/{id}', 'AttachmentsController@show')->middleware('auth');
Route::get('attach/{id}/get', 'AttachmentsController@get')->middleware('auth');
Route::get('attach/{id}/size/{height}', 'AttachmentsController@size')->middleware('auth');
Route::get('attach/{id}/delete', 'AttachmentsController@delete')->middleware('auth');
Route::get('attach/{id}/rotate/clock', 'AttachmentsController@rotate_clock')->middleware('auth');
Route::get('attach/{id}/rotate/unclock', 'AttachmentsController@rotate_unclock')->middleware('auth');
Route::get('attach/{id}/resize/{width}', 'AttachmentsController@resize')->middleware('auth');

Route::get('/admin', 'AdminController@index')->name('admin')->middleware('auth')->middleware('admin');
Route::get('/admin/user/{id}', 'AdminController@user_edit')->middleware('auth')->middleware('admin');
Route::post('/admin/user/{id}', 'AdminController@user_modify')->middleware('auth')->middleware('admin');
Route::get('/admin/access/{id}', 'AdminController@access')->middleware('auth')->middleware('admin');
Route::post('/admin/access/{id}', 'AdminController@access_post')->middleware('auth')->middleware('admin');
Route::get('/admin/access/{id}/delete/{id_access}', 'AdminController@access_delete')->middleware('auth')->middleware('admin');
Route::get('/admin/update', 'AdminController@update_index')->middleware('auth')->middleware('admin');
Route::get('/admin/update/do', 'AdminController@update_do')->middleware('auth')->middleware('admin');
Route::get('/admin/logs', 'AdminController@logs')->middleware('auth')->middleware('admin');

Route::get('/admin/combobox', 'AdminController@combobox')->middleware('auth')->middleware('admin');
Route::get('/admin/combobox/novo', 'AdminController@combobox_novo')->middleware('auth')->middleware('admin');
Route::post('/admin/combobox/novo', 'AdminController@combobox_salvar')->middleware('auth')->middleware('admin');
Route::get('/admin/combobox/{id}', 'AdminController@combobox_edit')->middleware('auth')->middleware('admin');
Route::post('/admin/combobox/novo/{id}', 'AdminController@combobox_atualizar')->middleware('auth')->middleware('admin');
Route::get('/admin/combobox/delete/{id}', 'AdminController@combobox_delete')->middleware('auth')->middleware('admin');

Route::get('/admin/backup', 'AdminController@backup_index')->middleware('auth')->middleware('admin');
Route::get('/admin/backup/do', 'AdminController@backup_do')->middleware('auth')->middleware('admin');
Route::get('/admin/backup/download/{file}', 'AdminController@backup_download')->middleware('auth')->middleware('admin');
