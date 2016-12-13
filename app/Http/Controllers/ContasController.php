<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Contas as Contas;
use App\Contatos as Contatos;

class ContasController extends Controller
{
  public function index(){
    $contas = Contas::all();
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Contas::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    return view('contas.index')->with('contas', $contas)->with('deletados', $deletados);
  }

  public function novo(){
    $contatos = Contatos::all();
    return view('contas.contatos')->with('contatos', $contatos);
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
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Contas::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    return view('contas.index')->with('contas', $contas)->with('deletados', $deletados);
  }
  public function add(Request $request){
    $conta = new Contas;
    $conta->contatos_id = $request->contatos_id;
    $conta->nome = $request->nome;
    $conta->valor = $request->val;
    $conta->vencimento = $request->venc;
    $conta->descricao = $request->descricao;
    $conta->tipo = $request->tipo;
    $conta->estado = $request->estado;
    $conta->save();
    $conta->referente = $conta->id;
    $conta->save();
    if ($request->parcelas>0){
      $i = 0;
      while ($i <= $request->parcelas) {
        $parcela = new Contas;
        $parcela->contatos_id = $request->contatos_id;
        $parcela->referente = $conta->id;
        $parcela->nome = $request->nome.' '.$i;
        $parcela->valor = $request->valor[$i];
        $parcela->vencimento = $request->vencimento[$i];
        $parcela->descricao = $request->descricao;
        $parcela->tipo = $request->tipo;
        $parcela->estado = $request->estado;
        $parcela->save();
        $i++;
      }
    }
    $contas = Contas::all();
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Contas::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    return view('contas.index')->with('contas', $contas)->with('deletados', $deletados);
  }

  public function pago($id){
    $conta = Contas::find($id);
    if ($conta->estado==1) {
      $conta->estado = '0';
    } elseif ($conta->estado == 0) {
      $conta->estado = '1';
    }
    $conta->save();
    $contas = Contas::all();
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Contas::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    return view('contas.index')->with('contas', $contas)->with('deletados', $deletados);
  }

  public function delete($id){
    $conta = Contas::withTrashed()->find($id);
    if ($conta->trashed()) {
      $conta->restore();
    } else {
      $conta->delete();
    }
    $contas = Contas::all();
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Contas::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    return view('contas.index')->with('contas', $contas)->with('deletados', $deletados);
  }
  public function edit($id){
    $conta = Contas::find($id);
    return view('contas.edit')->with('conta', $conta);
  }
}
