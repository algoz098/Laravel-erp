<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contatos as Contatos;
use App\Estoque as Estoque;
use Carbon\Carbon;
use App\Estoque_campos as Campos;
use Log;
use Auth;

class EstoqueController  extends BaseController
{
  public function __construct(){
     parent::__construct();
  }

  public function index()
  {
    Log::info('Vendo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $estoques = Estoque::paginate(30);
    $total= Estoque::count();
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Estoque::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    return view('estoque.index')->with('estoques', $estoques)->with('deletados', $deletados)->with('total', $total);
  }

  public function novo()
  {
    $contatos = Contatos::paginate(15);
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.novo')->with('contatos', $contatos);
  }
  public function detalhes($id)
  {
    $estoque = estoque::Find($id);
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.detalhes')->with('estoque', $estoque);
  }

  public function save(request $request)
  {
    $this->validate($request, [
        'contatos_id' => 'required',
        'nome' => 'required|max:50',
    ]);
    $estoque = new Estoque;
    $estoque->contatos_id = $request->contatos_id;
    $estoque->nome = $request->nome;
    $estoque->tipo = $request->tipo;
    $estoque->descricao = $request->descricao;
    $estoque->quantidade = $request->quantidade;
    $estoque->unidade = $request->unidade;
    $estoque->valor_custo = $request->valor_custo;
    $estoque->barras = $request->barras;
    $estoque->save();
    foreach ($request->campo_nome as $key => $value) {
      $campo = new Campos;
      $campo->estoque_id = $estoque->id;
      $campo->tipo = $request->tipo;
      $campo->nome = $request->campo_nome[$key];
      $campo->valor = $request->campo_valor[$key];
      $campo->save();
    }
    Log::info('Salvando estoque -> "'.$estoque.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return redirect()->action('EstoqueController@index');
  }

  public function edit($id)
  {
    $estoque = Estoque::find($id);
    Log::info('Editar estoque -> "'.$estoque.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return view('estoque.novo')->with('estoque', $estoque);
  }
  public function edit_save(request $request, $id)
  {
    $this->validate($request, [
      'contatos_id' => 'required',
      'nome' => 'required|max:50'
    ]);
    $estoque = Estoque::find($id);
    $estoque->contatos_id = $request->contatos_id;

    $estoque->nome = $request->nome;
    $estoque->descricao = $request->descricao;
    $estoque->quantidade = $request->quantidade;
    $estoque->valor_custo = $request->valor_custo;
    $estoque->barras = $request->barras;

    foreach ($request->campo_nome_edit as $key => $value) {
      $campo = Campos::find($request->campo_id_edit[$key]);
      $campo->tipo = $request->tipo;
      $campo->nome = $request->campo_nome_edit[$key];
      $campo->valor = $request->campo_valor_edit[$key];
      $campo->save();
    }
    if(isset($request->campo_nome)){
      foreach ($request->campo_nome as $key => $value) {
        $campo = new Campos;
        $campo->estoque_id = $estoque->id;
        $campo->tipo = $request->tipo;
        $campo->nome = $request->campo_nome[$key];
        $campo->valor = $request->campo_valor[$key];
        $campo->save();
      }
    }
    $estoque->save();
    Log::info('Salvando estoque -> "'.$estoque.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return redirect()->action('EstoqueController@index');
  }

  public function search( Request $request)
  {
    $estoques = Estoque::query();
    if ($request->estocado){
      $estoques = $estoques->orWhere('quantidade', '>', '0');
    }
    if ($request->falta){
      $estoques = $estoques->orWhere('quantidade', '<=', '0');
    }
    if (!empty($request->valor)){
      $estoques = $estoques->orWhere('valor_custo', '>', $request->valor);
    }
    if (!empty($request->codigo)){
      $estoques = $estoques->orWhere('barras', $request->codigo);
    }
    if (!empty($request->nome)){
      $estoques = $estoques->orWhere('nome', 'like', '%' . $request->nome . '%');
    }
    if (!empty($request->contato)){
      $contatos = Contatos::where('nome', 'like', '%' .  $request->contato . '%')
                            ->orWhere('sobrenome', 'like', '%' .  $request->contato . '%')
                            ->orWhere('endereco', 'like', '%' .  $request->contato . '%')
                            ->orWhere('cpf', 'like', '%' .  $request->contato . '%')
                            ->orWhere('cidade', 'like', '%' .  $request->contato . '%')
                            ->orWhere('uf', 'like', '%' .  $request->contato . '%')
                            ->orWhere('bairro', 'like', '%' .  $request->contato . '%')
                            ->orWhere('cep', 'like', '%' .  $request->contato . '%')
                            ->get();
        $a = 0;
        while ($a < count($contatos)) {
          $estoques = $estoques->orWhere('contatos_id', '=', $contatos[$a]->id);
          $a++;
        }
    }
    $estoques = $estoques->paginate(30);
    Log::info('Vendo estoque com busca -> "'.$request.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    $deletados = 0;
    return view('estoque.index')->with('estoques', $estoques)->with('deletados', $deletados);
  }

  public function searchContatos( Request $request)
  {
    if (!empty($request->busca)){
      $contatos = Contatos::where('nome', 'like', '%' .  $request->busca . '%')
                            ->orWhere('sobrenome', 'like', '%' .  $request->busca . '%')
                            ->orWhere('endereco', 'like', '%' .  $request->busca . '%')
                            ->orWhere('cpf', 'like', '%' .  $request->busca . '%')
                            ->orWhere('cidade', 'like', '%' .  $request->busca . '%')
                            ->orWhere('uf', 'like', '%' .  $request->busca . '%')
                            ->orWhere('bairro', 'like', '%' .  $request->busca . '%')
                            ->orWhere('cep', 'like', '%' .  $request->busca . '%')
                            ->paginate(15);
    } else {
      $contatos = Contatos::paginate(15);
    }
    Log::info('Criando estoque com busca -> "'.$request->busca.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return view('estoque.contatos')->with('contatos', $contatos);
  }

  public function delete($id)
  {
    $estoque = Estoque::withTrashed()->find($id);
    if ($estoque->trashed()){
      Log::info('Restaurando estoque -> "'.$estoque.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $estoque->restore();
    }else{
      Log::info('Deletando estoque -> "'.$estoque.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $estoque->delete();
    }
    return redirect()->action('EstoqueController@index');
  }

  public function up($id){
    $estoque = Estoque::find($id);
    $estoque->quantidade = $estoque->quantidade+1;
    $estoque->save();
    Log::info('Somando 1 ao estoque -> "'.$estoque.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return redirect()->action('EstoqueController@index');
  }
  public function down($id){
    $estoque = Estoque::find($id);
    $estoque->quantidade = $estoque->quantidade-1;
    $estoque->save();
    Log::info('Removendo 1 ao estoque -> "'.$estoque.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return redirect()->action('EstoqueController@index');
  }
}
