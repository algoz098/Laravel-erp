<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contatos as Contatos;

class ContatosController extends Controller
{
  public function show()
  {
    $contatos = contatos::all();
    return view('contatos.list')->with('contatos', $contatos);
  }

  public function showNovo()
  {
    return view('contatos.new');
  }

  public function novo( Request $request )
  {
    //return view('contatos.new');
    $contato = new Contatos;
    $contato->nome = $request->nome;
    $contato->cpf = $request->cnpj;
    $contato->rg = $request->ie;
    $contato->sobrenome = $request->sobrenome;
    $contato->endereco = $request->endereco;
    $contato->andar = $request->andar;
    $contato->sala = $request->sala;
    $contato->bairro = $request->bairro;
    $contato->uf = $request->uf;
    $contato->cidade = $request->cidade;
    $contato->cep = $request->cep;
    $contato->sociabilidade = $request->sociabilidade;
    if ($request->active=="1"){
        $contato->active = "4";
    }
    $contato->save();
    $contatos = Contatos::all();
    return view('contatos.list')->with('contatos', $contatos);
  }
  public function showId( $id )
  {
    $contato = contatos::find($id);
    return view('contatos.new')->with('contato', $contato);
  }

  public function update( Request $request, $id )
  {
    $contato = contatos::find($id);
    $contato->nome = $request->nome;
    $contato->cpf = $request->cpf;
    $contato->rg = $request->rg;
    $contato->sobrenome = $request->sobrenome;
    $contato->endereco = $request->endereco;
    $contato->andar = $request->andar;
    $contato->sala = $request->sala;
    $contato->bairro = $request->bairro;
    $contato->uf = $request->uf;
    $contato->cidade = $request->cidade;
    $contato->cep = $request->cep;
    $contato->sociabilidade = $request->sociabilidade;
    if ($request->active=="1"){
        $contato->active = "4";
    }
    $contato->save();
    $contatos = contatos::all();
    return view('contatos.list')->with('contatos', $contatos);
  }

}
