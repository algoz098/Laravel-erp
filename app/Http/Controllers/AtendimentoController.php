<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Atendimento as Atendimento;
use App\Contatos as Contatos;
use App\Attachments as Attachs;
use Carbon\Carbon;
use Log;
use Auth;

class AtendimentoController extends Controller
{
  public function index(){
    Log::info('Mostando atendimentos, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $atendimentos = Atendimento::paginate(15);
    return view('atend.index')->with('atendimentos', $atendimentos);
  }

  public function show($id){
    $atendimento = Atendimento::find($id);

    Log::info('Mostando atendimento -> "'.$atendimento.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return view('atend.show')->with('atendimento', $atendimento);
  }

  public function new_a(){
    Log::info('Criando novo atendimento, selecionando contato, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
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

    Log::info('Salvando atendimento -> "'.$atendimento.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return redirect()->action('AtendimentoController@index');
  }

  public function delete($id){
    $atendimento = Atendimento::find($id);
    Log::info('Deletando atendimento -> "'.$atendimento.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $atendimento->delete();

    return redirect()->action('AtendimentoController@index');
  }

  public function search( Request $request)
  {
    $atendimentos = atendimento::query();
    if (!empty($request->data)){
      $atendimentos = $atendimentos->whereRaw('date(created_at) = ?', [$request->data]);
    }
    if (!empty($request->busca)){
      $atendimentos = $atendimentos->orWhere('assunto', 'like', '%' .  $request->busca . '%');
    }
    if ($request->contatos_id!="0"){
      $atendimentos = $atendimentos->orWhere('contatos_id', $request->contatos_id);
    }
    $atendimentos = $atendimentos->paginate(30);
    Log::info('Mostando atendimentos com busca -> "'.$request->busca.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

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
    Log::info('Criando novo atendimento, selecionando contato com busca -> "'.$request->busca.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return view('atend.contatos')->with('contatos', $contatos);
  }

  public function novo($id){
    $contato = Contatos::find($id);
    Log::info('Criando novo atendimento para contato -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('atend.index')->with('contato', $contato);
  }

  public function edit(request $request, $id){
    $atendimento = Atendimento::find($id);
    $atendimento->assunto = $request->assunto;
    $atendimento->texto = $request->texto;
    $atendimento->save();
    Log::info('Editando atendimento com -> "'.$atendimento.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return redirect()->action('AtendimentoController@index');
  }
  public function attach(request $request, $id){
    $atendimento = Atendimento::find($id);
    $attach = new Attachs;
    $attach->attachmentable_id = $id;
    $attach->attachmentable_type = "App\Atendimento";
    $attach->name = $request->name;
    $attach->path = $request->file->store('public');
    $attach->contatos_id = $atendimento->contatos_id;
    $attach->save();
    Log::info('Anexando arquivo para atendimento, anexo -> "'.$attach.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return redirect()->action('AtendimentoController@index');
  }

}
