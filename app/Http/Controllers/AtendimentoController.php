<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Atendimento as Atendimento;
use App\Contatos as Contatos;
use App\Attachments as Attachs;

class AtendimentoController extends Controller
{
  public function index(){
    $atendimentos = Atendimento::paginate(15);
    return view('atend.index')->with('atendimentos', $atendimentos);
  }

  public function show($id){
    $atendimento = Atendimento::find($id);
    return view('atend.show')->with('atendimento', $atendimento);
  }

  public function new_a(){
    $contatos = Contatos::paginate(15);
    return view('atend.contatos')->with('contatos', $contatos);
  }

  public function add(Request $request){
    $atendimento = new Atendimento;
    $atendimento->assunto = $request->assunto;
    $atendimento->contatos_id = $request->contatos_id;
    $atendimento->created_at = $request->data;
    $atendimento->texto = $request->texto;
    $atendimento->save();
    return redirect()->action('AtendimentoController@index');
  }

  public function delete($id){
    $atendimento = Atendimento::find($id);
    $atendimento->delete();
    return redirect()->action('AtendimentoController@index');
  }

  public function search( Request $request)
  {
    if (!empty($request->busca)){
      $atendimentos = Atendimento::where('assunto', 'like', '%' .  $request->busca . '%')
                            ->orWhere('created_at', 'like', '%' .  $request->busca . '%')
                            ->paginate(30);
    } else {
      $atendimentos = Atendimento::paginate(30);
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
                            ->paginate(15);
    } else {
      $contatos = Contatos::paginate(15);
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

    return redirect()->action('AtendimentoController@index');
  }
  public function attach(request $request, $id){
    $attach = new Attachs;
    $attach->attachmentable_id = $id;
    $attach->attachmentable_type = "App\Atendimento";
    $attach->name = $request->name;
    $attach->path = $request->file->store('public');
    $attach->save();
    return redirect()->action('AtendimentoController@index');
  }

}
