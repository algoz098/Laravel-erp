<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes as Clientes;

class ClientesController extends Controller
{
  public function show()
  {
    $clientes = Clientes::all();
    return view('clientes.list')->with('clientes', $clientes);
  }

  public function showNovo()
  {
    return view('clientes.new');
  }

  public function novo( Request $request )
  {
    //return view('clientes.new');
    $cliente = new Clientes;
    $cliente->razao_social = $request->razao_social;
    $cliente->cpf_cnpj = $request->cnpj;
    $cliente->ie = $request->ie;
    $cliente->nome_fantasia = $request->nome_fantasia;
    $cliente->endereco = $request->endereco;
    $cliente->numero = $request->numero;
    $cliente->andar = $request->andar;
    $cliente->sala = $request->sala;
    $cliente->bairro = $request->bairro;
    $cliente->uf = $request->uf;
    $cliente->cidade = $request->cidade;
    $cliente->cep = $request->cep;
    $cliente->contato1 = $request->contato1;
    $cliente->contato2 = $request->contato2;
    $cliente->tel1 = $request->tel1;
    $cliente->tel2 = $request->tel2;
    $cliente->ramal1 = $request->ramal1;
    $cliente->ramal2 = $request->ramal2;
    $cliente->email1 = $request->email1;
    $cliente->email2 = $request->email2;
    $cliente->cel1 = $request->cel1;
    $cliente->cel2 = $request->cel2;
    $cliente->obs1 = $request->obs1;
    $cliente->obs2 = $request->obs2;
    $cliente->departamento1 = $request->departamento1;
    $cliente->departament2 = $request->departamento2;
    $cliente->save();
    $clientes = Clientes::all();
    return view('clientes.list')->with('clientes', $clientes);
  }
  public function showId( $id )
  {
    $cliente = Clientes::find($id);
    return view('clientes.new')->with('cliente', $cliente);
  }

  public function update( Request $request, $id )
  {
    $cliente = Clientes::find($id);
    $cliente->razao_social = $request->razao_social;
    $cliente->cpf_cnpj = $request->cnpj;
    $cliente->ie = $request->ie;
    $cliente->nome_fantasia = $request->nome_fantasia;
    $cliente->endereco = $request->endereco;
    $cliente->numero = $request->numero;
    $cliente->andar = $request->andar;
    $cliente->sala = $request->sala;
    $cliente->bairro = $request->bairro;
    $cliente->uf = $request->uf;
    $cliente->cidade = $request->cidade;
    $cliente->cep = $request->cep;
    $cliente->contato1 = $request->contato1;
    $cliente->contato2 = $request->contato2;
    $cliente->tel1 = $request->tel1;
    $cliente->tel2 = $request->tel2;
    $cliente->ramal1 = $request->ramal1;
    $cliente->ramal2 = $request->ramal2;
    $cliente->email1 = $request->email1;
    $cliente->email2 = $request->email2;
    $cliente->cel1 = $request->cel1;
    $cliente->cel2 = $request->cel2;
    $cliente->obs1 = $request->obs1;
    $cliente->obs2 = $request->obs2;
    $cliente->departamento1 = $request->departamento1;
    $cliente->departament2 = $request->departamento2;
    $cliente->save();
    $clientes = Clientes::all();
    return view('clientes.list')->with('clientes', $clientes);
  }

}
