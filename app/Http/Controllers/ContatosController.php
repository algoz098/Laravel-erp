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
        $contato->active = "5";
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
    $contato->razao_social = $request->razao_social;
    $contato->cpf_cnpj = $request->cnpj;
    $contato->ie = $request->ie;
    $contato->nome_fantasia = $request->nome_fantasia;
    $contato->endereco = $request->endereco;
    $contato->numero = $request->numero;
    $contato->andar = $request->andar;
    $contato->sala = $request->sala;
    $contato->bairro = $request->bairro;
    $contato->uf = $request->uf;
    $contato->cidade = $request->cidade;
    $contato->cep = $request->cep;
    $contato->contato1 = $request->contato1;
    $contato->contato2 = $request->contato2;
    $contato->tel1 = $request->tel1;
    $contato->tel2 = $request->tel2;
    $contato->ramal1 = $request->ramal1;
    $contato->ramal2 = $request->ramal2;
    $contato->email1 = $request->email1;
    $contato->email2 = $request->email2;
    $contato->cel1 = $request->cel1;
    $contato->cel2 = $request->cel2;
    $contato->obs1 = $request->obs1;
    $contato->obs2 = $request->obs2;
    $contato->departamento1 = $request->departamento1;
    $contato->departament2 = $request->departamento2;
    $contato->save();
    $contatos = contatos::all();
    return view('contatos.list')->with('contatos', $contatos);
  }

}
