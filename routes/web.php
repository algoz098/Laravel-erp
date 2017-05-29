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

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/menus', 'BaseController@menus')->middleware('auth');
Route::get('/home', 'HomeController@index')->middleware('auth');

Route::get('/lista/combobox/{app}', 'ContatosController@combobox')->middleware('auth');

Route::get('/lista/contatos', 'ContatosController@show')->name('contatos')->middleware('auth');

Route::post('/lista/filiais', 'ContatosController@filiais_busca')->middleware('auth');

Route::post('/lista/contatos/cpf', 'ContatosController@consulta_cpf')->middleware('auth');
Route::get('/lista/contatos/selecionar', 'ContatosController@selecionar')->middleware('auth');
Route::get('/lista/filiais/selecionar', 'ContatosController@selecionar_filial')->middleware('auth');
Route::post('/lista/contatos/selecionar', 'ContatosController@selecionar_busca')->middleware('auth');
Route::post('/lista/filiais/selecionar', 'ContatosController@selecionar_busca')->middleware('auth');
Route::get('/lista/contatos/selecionar/novo', 'ContatosController@selecionar_novo')->middleware('auth');
Route::post('/lista/contatos/selecionar/novo', 'ContatosController@selecionar_salva')->middleware('auth');
Route::post('lista/contatos', 'ContatosController@search')->middleware('auth');
Route::get('lista/contatos/{id}/attachs', 'ContatosController@attachs_detalhes')->middleware('auth');
Route::post('lista/contatos/{id}/attach', 'ContatosController@attach')->middleware('auth');
Route::get('lista/contatos/{id}/delete/', 'ContatosController@delete')->middleware('auth');
Route::get('lista/contatos/{id}', 'ContatosController@detalhes')->middleware('auth');
Route::get('lista/contatos/{id}/telefones', 'ContatosController@telefones')->middleware('auth');
Route::post('lista/contatos/{id}/telefones', 'ContatosController@telefones_new')->middleware('auth');
Route::post('lista/contatos/{id}/telefones/{id_tel}', 'ContatosController@telefones_post')->middleware('auth');
Route::get('lista/contatos/{id}/telefones/{id_tel}', 'ContatosController@telefones_get')->middleware('auth');
Route::get('lista/contatos/{id}/telefones/{id_tel}/delete', 'ContatosController@telefones_delete')->middleware('auth');
Route::get('lista/contatos/enderecos/{id_endereco}/delete', 'ContatosController@enderecos_delete')->middleware('auth');
Route::post('/novo/contatos', 'ContatosController@novo')->middleware('auth');
Route::get('/novo/contatos', 'ContatosController@showNovo')->middleware('auth');
Route::get('novo/contatos/{id}', 'ContatosController@showId')->middleware('auth');
Route::post('novo/contatos/{id}', 'ContatosController@update')->middleware('auth');

Route::get('novo/funcionarios', 'ContatosController@funcionarios_novo')->middleware('auth');
Route::post('novo/funcionarios', 'ContatosController@novo')->middleware('auth');

Route::get('lista/contatos/{id}/relacoes', 'ContatosController@relacoes')->middleware('auth');
Route::get('lista/contatos/{id}/relacoes/novo', 'ContatosController@relacoes_novo')->middleware('auth');
Route::post('lista/contatos/{id}/relacoes/novo/busca', 'ContatosController@relacoes_busca')->middleware('auth');
Route::post('lista/contatos/{id}/relacoes/novo', 'ContatosController@relacoes_post')->middleware('auth');
Route::get('lista/contatos/{id}/relacoes/{id_relacao}', 'ContatosController@relacoes_edit')->middleware('auth');
Route::get('lista/contatos/{id}/relacoes/{id_relacao}/delete', 'ContatosController@relacoes_delete')->middleware('auth');

Route::get('lista/contas', 'ContasController@index')->middleware('auth');
Route::post('lista/contas', 'ContasController@search')->middleware('auth');
Route::get('lista/contas/{id}', 'ContasController@detalhes')->middleware('auth');
Route::get('lista/contas/{id}/attachs', 'ContasController@attachs')->middleware('auth');
Route::get('lista/contas/{id}/delete', 'ContasController@delete')->middleware('auth');
Route::get('lista/contas/{id}/pago', 'ContasController@pagar')->middleware('auth');
Route::post('lista/contas/{id}/pago', 'ContasController@pago')->middleware('auth');
Route::get('novo/contas', 'ContasController@novo')->middleware('auth');
Route::post('novo/contas/busca', 'ContasController@searchContatos')->middleware('auth');
Route::get('novo/contas/', 'ContasController@add_2')->middleware('auth');
Route::post('novo/contas/parcelas', 'ContasController@add_3')->middleware('auth');
Route::post('novo/contas/parcelas/{conta_id}', 'ContasController@add_4')->middleware('auth');
Route::get('novo/contas/{id}', 'ContasController@editar')->middleware('auth');
Route::post('novo/contas/{id}', 'ContasController@atualiza')->middleware('auth');

Route::get('novo/consumos/', 'ContasController@consumos_novo2')->middleware('auth');
Route::post('novo/consumos/parcelas', 'ContasController@consumos_novo3')->middleware('auth');

Route::get('lista/bancos/', 'BancosController@index')->middleware('auth');
Route::get('lista/bancos/selecionar', 'BancosController@selecionar')->middleware('auth');
Route::post('lista/bancos/', 'BancosController@busca')->middleware('auth');
Route::get('lista/bancos/{id}', 'BancosController@detalhes')->middleware('auth');
Route::get('lista/bancos/{id}/delete', 'BancosController@delete')->middleware('auth');
Route::get('novo/bancos/', 'BancosController@novo')->middleware('auth');
Route::get('novo/bancos/{id}', 'BancosController@editar')->middleware('auth');
Route::post('novo/bancos/', 'BancosController@salva')->middleware('auth');
Route::post('novo/bancos/{id}', 'BancosController@atualiza')->middleware('auth');

Route::get('/lista/atendimentos', 'AtendimentoController@index')->middleware('auth')->name('atendimentos');
Route::get('/lista/atendimentos/{id}', 'AtendimentoController@detalhes')->middleware('auth');
Route::post('/lista/atendimentos/{id}/attach', 'AtendimentoController@attach')->middleware('auth');
Route::post('lista/atendimentos', 'AtendimentoController@search')->middleware('auth');
Route::get('lista/atendimentos/{id}/delete', 'AtendimentoController@delete')->middleware('auth');
Route::get('lista/atendimentos/{id}/edit', 'AtendimentoController@edit')->middleware('auth');
Route::post('novo/atendimentos/', 'AtendimentoController@add')->middleware('auth');
Route::get('/novo/atendimentos', 'AtendimentoController@new_a')->middleware('auth');
Route::post('novo/atendimentos/busca', 'AtendimentoController@searchContatos')->middleware('auth');
Route::get('novo/atendimentos/{id}', 'AtendimentoController@show')->middleware('auth');
Route::post('novo/atendimentos/{id}', 'AtendimentoController@edit')->middleware('auth');

Route::get('lista/estoques', 'EstoqueController@index')->middleware('auth');
Route::post('lista/estoques', 'EstoqueController@search')->middleware('auth');
Route::get('lista/estoques/{id}', 'EstoqueController@detalhes')->middleware('auth');
Route::get('lista/estoques/{id}/delete', 'EstoqueController@delete')->middleware('auth');
Route::get('lista/estoques/{id}/up', 'EstoqueController@up')->middleware('auth');
Route::get('lista/estoques/{id}/down', 'EstoqueController@down')->middleware('auth');
Route::get('novo/estoques/{id}', 'EstoqueController@edit')->middleware('auth');
Route::post('novo/estoques/{id}', 'EstoqueController@edit_save')->middleware('auth');
Route::get('novo/estoques', 'EstoqueController@novo')->middleware('auth');
Route::post('novo/estoques', 'EstoqueController@save')->middleware('auth');

Route::get('lista/nf-entrada', 'EstoqueController@nf_entrada_lista')->middleware('auth');
Route::post('lista/nf-entrada', 'EstoqueController@nf_entrada_busca')->middleware('auth');

Route::get('novo/nf-entrada', 'EstoqueController@nf_entrada')->middleware('auth');
Route::get('novo/nf-entrada/{id}', 'EstoqueController@nf_entrada_editar')->middleware('auth');
Route::post('novo/nf-entrada', 'EstoqueController@nf_entrada_salva')->middleware('auth');
Route::post('novo/nf-entrada/{id}', 'EstoqueController@nf_entrada_atualiza')->middleware('auth');

Route::get('lista/produtos/selecionar', 'EstoqueController@produto_selecionar')->middleware('auth');
Route::get('lista/produtos', 'EstoqueController@produto_index')->middleware('auth');
Route::post('lista/produtos', 'EstoqueController@produto_busca')->middleware('auth');
Route::get('lista/produtos/campos/{id}/delete', 'EstoqueController@produto_campos_delete')->middleware('auth');
Route::get('lista/produtos/externos/{id}/delete', 'EstoqueController@produto_externos_delete')->middleware('auth');
Route::get('lista/produtos/selecionar/novo', 'EstoqueController@produto_selecionar_novo')->middleware('auth');
Route::post('lista/produtos/selecionar/novo', 'EstoqueController@produto_selecionar_salva')->middleware('auth');
Route::get('lista/produtos/grupo', 'EstoqueController@grupo_selecionar')->middleware('auth');
Route::post('lista/produtos/grupo', 'EstoqueController@grupo_busca')->middleware('auth');
Route::get('lista/produtos/grupo/novo', 'EstoqueController@grupo_novo')->middleware('auth');
Route::get('lista/produtos/grupo/novo/{id}', 'EstoqueController@grupo_edit')->middleware('auth');
Route::post('lista/produtos/grupo/novo', 'EstoqueController@grupo_salva')->middleware('auth');
Route::get('lista/produtos/{id}', 'EstoqueController@produto_detalhes')->middleware('auth');
Route::get('lista/produtos/{id}/delete', 'EstoqueController@produto_delete')->middleware('auth');
Route::get('novo/produto', 'EstoqueController@produto_novo')->middleware('auth');

Route::get('lista/produtos/tipo', 'EstoqueController@tipo_selecionar')->middleware('auth');
Route::post('lista/produtos/tipo', 'EstoqueController@tipo_busca')->middleware('auth');
Route::get('lista/produtos/tipo/novo/{id}', 'EstoqueController@tipo_novo')->middleware('auth');
Route::get('lista/produtos/tipo/editar/{id}', 'EstoqueController@tipo_editar')->middleware('auth');
Route::post('lista/produtos/tipo/novo', 'EstoqueController@tipo_salva')->middleware('auth');

Route::get('novo/produto/barras', 'EstoqueController@gerar_barras')->middleware('auth');
Route::get('novo/produto/{id}', 'EstoqueController@produto_editar')->middleware('auth');
Route::post('novo/produto', 'EstoqueController@produto_salva')->middleware('auth');
Route::post('novo/produto/{id}', 'EstoqueController@produto_atualiza')->middleware('auth');

Route::get('lista/caixa', 'CaixasController@index')->middleware('auth');
Route::post('lista/caixa', 'CaixasController@search')->middleware('auth');
Route::get('lista/caixa/fechar', 'CaixasController@fechar')->middleware('auth');
Route::get('lista/caixa/fechar/{id}', 'CaixasController@pendencias')->middleware('auth');
Route::get('lista/caixa/fechar/{id}/concluir', 'CaixasController@concluir')->middleware('auth');
Route::post('lista/caixa/fechar/{id}/movs/{id_mov}', 'CaixasController@prestacao')->middleware('auth');
Route::get('lista/caixa/{id}/delete', 'CaixasController@delete')->middleware('auth');
Route::get('novo/caixa', 'CaixasController@new_a')->middleware('auth');
Route::post('novo/caixa', 'CaixasController@new_do')->middleware('auth');
Route::get('novo/caixa/{id}', 'CaixasController@movimentacao_novo')->middleware('auth');

Route::get('lista/vendas', 'VendasController@index')->middleware('auth');
Route::get('novo/vendas', 'VendasController@novo')->middleware('auth');
Route::get('novo/vendas/{id}', 'VendasController@produtos')->middleware('auth');
Route::post('novo/vendas/{id}', 'VendasController@confirmar')->middleware('auth');
Route::post('novo/vendas/{id}/salvar', 'VendasController@salvar')->middleware('auth');

Route::get('lista/tickets/', 'TicketsController@index')->middleware('auth');
Route::post('lista/tickets/', 'TicketsController@busca')->middleware('auth');
Route::get('lista/tickets/{id}', 'TicketsController@detalhes')->middleware('auth');
Route::get('lista/tickets/{id}/delete', 'TicketsController@delete')->middleware('auth');
Route::get('lista/tickets/{id}/andamento', 'TicketsController@andamento')->middleware('auth');
Route::post('lista/tickets/{id}/andamento', 'TicketsController@andamento_salvar')->middleware('auth');
Route::get('novo/tickets/', 'TicketsController@novo')->middleware('auth');
Route::get('novo/tickets/{id}/edit', 'TicketsController@editar')->middleware('auth');
Route::post('novo/tickets/{id}/edit', 'TicketsController@editar_salvar')->middleware('auth');
Route::post('novo/tickets/', 'TicketsController@salvar')->middleware('auth');

Route::get('lista/frotas', 'FrotasController@index')->middleware('auth');
Route::post('lista/frotas', 'FrotasController@busca')->middleware('auth');
Route::get('lista/frotas/{id}', 'FrotasController@detalhes')->middleware('auth');
Route::get('lista/frotas/{id}/delete', 'FrotasController@delete')->middleware('auth');
Route::get('lista/frotas/{id}/abastecer/{id_abastecimento}', 'FrotasController@abastecer_editar')->middleware('auth');
Route::post('lista/frotas/{id}/abastecer/{id_abastecimento}', 'FrotasController@abastecer_guardar')->middleware('auth');
Route::get('lista/frotas/{id}/abastecer', 'FrotasController@abastecer')->middleware('auth');
Route::post('lista/frotas/{id}/abastecer', 'FrotasController@abastecer_salvar')->middleware('auth');
Route::get('novo/frotas', 'FrotasController@novo')->middleware('auth');
Route::get('novo/frotas/{id}', 'FrotasController@novo_2')->middleware('auth');
Route::post('novo/frotas/{id}', 'FrotasController@criar')->middleware('auth');
Route::get('novo/frotas/{id}/edit', 'FrotasController@edit')->middleware('auth');
Route::post('novo/frotas/{id}/edit', 'FrotasController@salvar')->middleware('auth');

Route::get('lista/abastecimentos/{id}/delete', 'FrotasController@abastecer_delete')->middleware('auth');

Route::get('attach/{id}', 'AttachmentsController@show')->middleware('auth');
Route::get('attach/{id}/get', 'AttachmentsController@get')->middleware('auth');
Route::get('attach/{id}/size/{height}', 'AttachmentsController@size')->middleware('auth');
Route::get('attach/{id}/delete', 'AttachmentsController@delete')->middleware('auth');
Route::get('attach/{id}/rotate/clock', 'AttachmentsController@rotate_clock')->middleware('auth');
Route::get('attach/{id}/rotate/unclock', 'AttachmentsController@rotate_unclock')->middleware('auth');
Route::get('attach/{id}/resize/{width}', 'AttachmentsController@resize')->middleware('auth');

Route::get('attach/{modulo}/{id}/{contatos_id}', 'AttachmentsController@novo')->middleware('auth');

Route::post('attach/nome/{id}', 'AttachmentsController@nome')->middleware('auth');
Route::post('attach/{modulo}/{id}/{contatos_id}', 'AttachmentsController@salva')->middleware('auth');


Route::get('/lista/cons_int', 'Cons_intController@index')->middleware('auth');


Route::get('/admin/config/img_destaque', 'AdminController@img_destaque'); // Rota espcial nao colocar middleware de proteção

Route::get('/admin', 'AdminController@index')->name('admin')->middleware('auth')->middleware('admin');

Route::get('/admin/config', 'AdminController@configuration')->name('admin')->middleware('auth')->middleware('admin');
Route::post('/admin/config', 'AdminController@configuration_save')->name('admin')->middleware('auth')->middleware('admin');

Route::get('/admin/user/{id}', 'AdminController@user_edit')->middleware('auth')->middleware('admin');
Route::post('/admin/user/{id}', 'AdminController@user_modify')->middleware('auth')->middleware('admin');
Route::get('/admin/access/{id}', 'AdminController@access')->middleware('auth')->middleware('admin');
Route::post('/admin/access/{id}', 'AdminController@access_post')->middleware('auth')->middleware('admin');
Route::get('/admin/access/{id}/delete/{id_access}', 'AdminController@access_delete')->middleware('auth')->middleware('admin');
Route::get('/admin/update', 'AdminController@update_index')->middleware('auth')->middleware('admin');
Route::get('/admin/update/do', 'AdminController@update_do')->middleware('auth')->middleware('admin');
Route::get('/admin/logs', 'AdminController@logs')->middleware('auth')->middleware('admin');

Route::get('/lista/combobox/contas', 'AdminController@combobox_lista_contas')->middleware('auth')->middleware('admin');
Route::post('/lista/combobox/contas', 'AdminController@combobox_lista_contas_search')->middleware('auth')->middleware('admin');

Route::get('/admin/combobox', 'AdminController@combobox')->middleware('auth')->middleware('admin');
Route::get('/novo/combobox/telefone', 'AdminController@combobox_novo_telefone')->middleware('auth')->middleware('admin');
Route::get('/novo/combobox/relacao', 'AdminController@combobox_novo_relacao')->middleware('auth')->middleware('admin');
Route::get('/novo/combobox/atend', 'AdminController@combobox_novo_atend')->middleware('auth')->middleware('admin');
Route::get('/novo/combobox/contas', 'AdminController@combobox_novo_contas')->middleware('auth')->middleware('admin');
Route::get('/novo/combobox/caixas', 'AdminController@combobox_novo_caixas')->middleware('auth')->middleware('admin');
Route::get('/novo/combobox/consumos', 'AdminController@combobox_novo_consumos')->middleware('auth')->middleware('admin');
Route::get('/novo/combobox/formas', 'AdminController@combobox_novo_formas')->middleware('auth')->middleware('admin');
Route::get('novo/combobox/estoque/produtos/medidas', 'AdminController@combobox_novo_medidas')->middleware('auth')->middleware('admin');
Route::get('novo/combobox/estoque/produtos/embalagens', 'AdminController@combobox_novo_embalagens')->middleware('auth')->middleware('admin');

Route::post('/admin/combobox/novo', 'AdminController@combobox_salvar')->middleware('auth')->middleware('admin');
Route::get('/admin/combobox/{id}', 'AdminController@combobox_edit')->middleware('auth')->middleware('admin');
Route::post('/admin/combobox/novo/{id}', 'AdminController@combobox_atualizar')->middleware('auth')->middleware('admin');
Route::get('/admin/combobox/delete/{id}', 'AdminController@combobox_delete')->middleware('auth')->middleware('admin');

Route::get('/admin/backup', 'AdminController@backup_index')->middleware('auth')->middleware('admin');
Route::get('/admin/backup/do', 'AdminController@backup_do')->middleware('auth')->middleware('admin');
Route::get('/admin/backup/download/{file}', 'AdminController@backup_download')->middleware('auth')->middleware('admin');

Route::get('/busca/cep/{cep}', 'CepController@buscacep')->middleware('auth');
