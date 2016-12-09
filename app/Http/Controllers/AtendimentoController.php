<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Atendimento as Atendimento;
use App\Contatos as Contatos;

class AtendimentoController extends Controller
{
  public function index(){
    $atendimentos = Atendimento::all();
    return view('atend.index')->with('atendimentos', $atendimentos);
  }

  public function show($id){
    $atendimento = Atendimento::find($id);
    return view('atend.show')->with('atendimento', $atendimento);
  }

  public function new_a(){
    $contatos = Contatos::all();
    return view('atend.contatos')->with('contatos', $contatos);
  }

  public function add(Request $request){
    $atendimento = new Atendimento;
    $atendimento->assunto = $request->assunto;
    $atendimento->contatos_id = $request->contatos_id;
    $atendimento->created_at = $request->data;
    $atendimento->texto = $request->texto;
    $atendimento->save();
    $atendimentos = Atendimento::all();
    return view('atend.index')->with('atendimentos', $atendimentos);
  }

  public function delete($id){
    $atendimento = Atendimento::find($id);
    $atendimento->delete();
    $atendimentos = Atendimento::all();
    return view('atend.index')->with('atendimentos', $atendimentos);
  }

  public function search( Request $request)
  {
    if (!empty($request->busca)){
      $atendimentos = Atendimento::where('assunto', 'like', '%' .  $request->busca . '%')
                            ->orWhere('created_at', 'like', '%' .  $request->busca . '%')
                            ->get();
    } else {
      $atendimentos = Atendimento::all();
    }
    return view('atend.index')->with('atendimentos', $atendimentos);
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
    return view('atend.contatos')->with('contatos', $contatos);
  }

  public function novo($id){
    $contato = Contatos::find($id);
    return view('atend.index')->with('contato', $contato);
  }

  public function edit(request $request, $id){
    $atendimento = Atendimento::find($id);
    $atendimento->assunto = $request->assunto;
    $atendimento->texto = $request->texto;
    $atendimento->save();

    $atendimentos = Atendimento::all();
    $contatos = Contatos::all();
    return view('atend.index')->with('atendimentos', $atendimentos)->with('contatos', $contatos);
  }
}
