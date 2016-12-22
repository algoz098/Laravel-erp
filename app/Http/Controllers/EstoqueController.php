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
    $estoques = Estoque::all();
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Estoque::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    return view('estoque.index')->with('estoques', $estoques)->with('deletados', $deletados);
  }
  public function novo()
  {
    $contatos = Contatos::all();
    return view('estoque.contatos')->with('contatos', $contatos);
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
                            ->get();
    } else {
      $contatos = Contatos::all();
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
    $estoques = Estoque::all();
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Estoque::onlyTrashed()->get();
    } else {
      $deletados = 0;
      $estoques = 0;
    }
    return view('estoque.index')->with('estoques', $estoques)->with('deletados', $deletados);
  }
}
