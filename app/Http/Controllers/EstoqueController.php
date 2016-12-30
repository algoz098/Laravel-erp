<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contatos as Contatos;
use App\Estoque as Estoque;
use Auth;

class EstoqueController extends Controller
{
  public function index()
  {
    $estoques = Estoque::paginate(30);
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Estoque::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    return view('estoque.index')->with('estoques', $estoques)->with('deletados', $deletados);
  }

  public function novo()
  {
    $contatos = Contatos::paginate(15);
    return view('estoque.contatos')->with('contatos', $contatos);
  }

  public function save(request $request)
  {
    $estoque = new Estoque;
    $estoque->contatos_id = $request->contatos_id;
    $estoque->nome = $request->nome;
    $estoque->descricao = $request->descricao;
    $estoque->quantidade = $request->quantidade;
    $estoque->valor_custo = $request->valor_custo;
    $estoque->barras = $request->barras;
    $estoque->save();
    return redirect()->action('EstoqueController@index');
  }

  public function edit($id)
  {
    $estoque = Estoque::find($id);
    return view('estoque.edit')->with('estoque', $estoque);
  }
  public function edit_save(request $request, $id)
  {
    $estoque = Estoque::find($id);
    $estoque->nome = $request->nome;
    $estoque->descricao = $request->descricao;
    $estoque->quantidade = $request->quantidade;
    $estoque->valor_custo = $request->valor_custo;
    $estoque->barras = $request->barras;
    $estoque->save();
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
    return view('estoque.contatos')->with('contatos', $contatos);
  }

  public function delete($id)
  {
    $estoque = Estoque::withTrashed()->find($id);
    if ($estoque->trashed()){
      $estoque->restore();
    }else{
      $estoque->delete();
    }
    return redirect()->action('EstoqueController@index');
  }

  public function up($id){
    $estoque = Estoque::find($id);
    $estoque->quantidade = $estoque->quantidade+1;
    $estoque->save();
    return redirect()->action('EstoqueController@index');
  }
  public function down($id){
    $estoque = Estoque::find($id);
    $estoque->quantidade = $estoque->quantidade-1;
    $estoque->save();
  }
    return redirect()->action('EstoqueController@index');
  }
}
