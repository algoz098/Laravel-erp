<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Atendimento as Atendimento;
use App\Contatos as Contatos;
use App\Attachments as Attachs;
use App\Combobox_texts as Comboboxes;
use Carbon\Carbon;
use Log;
use Auth;
use Intervention\Image\ImageManagerStatic as Image;
use File;
use Storage;

class AtendimentoController  extends BaseController
{
  public function __construct(){
     parent::__construct();
  }

  public function index(){
    Log::info('Mostando atendimentos, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $atendimentos = Atendimento::orderBy('created_at', 'desc')->paginate(15);
    $deletados = "0";
    $total= Atendimento::count();
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Atendimentos')->get();
    return view('atend.index')->with('atendimentos', $atendimentos)->with('total', $total)->with('comboboxes', $comboboxes)->with('deletados', $deletados);
  }

  public function show($id){
    $atendimento = Atendimento::find($id);
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Atendimentos')->get();
    Log::info('Mostando atendimento -> "'.$atendimento.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return view('atend.show')->with('atendimento', $atendimento)->with('comboboxes', $comboboxes);
  }

  public function detalhes($id){
    $atendimento = Atendimento::find($id);
    Log::info('Mostando detalhes atendimento -> "'.$atendimento.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return view('atend.detalhes')->with('atendimento', $atendimento);
  }

  public function new_a(){
    Log::info('Criando novo atendimento, selecionando contato, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $contatos = Contatos::paginate(15);
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Atendimentos')->get();
    return view('atend.contatos')->with('contatos', $contatos)->with('comboboxes', $comboboxes);
  }

  public function add(Request $request){
    $this->validate($request, [
        'assunto' => 'required|max:50',
        'contatos_id' => 'required',
    ]);
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
    $atendimento = Atendimento::withTrashed()->find($id);
    Log::info('Deletando atendimento -> "'.$atendimento.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    if ($atendimento->trashed()) {
      $atendimento->restore();
    } else {
      $atendimento->delete();
    }

    return redirect()->action('AtendimentoController@index');
  }

  public function search( Request $request)
  {
    #return $request;
    $atendimentos = atendimento::query();
    if ($request->data_de and !$request->data_ate){
      $atendimentos = $atendimentos->whereBetween('created_at', [$request->data_de, Carbon::today()]);
    }
    if ($request->data_de and $request->data_ate){
      $atendimentos = $atendimentos->whereBetween('created_at', [$request->data_de, $request->data_ate]);
    }
    if ($request->assunto!=""){
      $atendimentos = $atendimentos->orWhere('assunto', $request->assunto);
    }
    if ($request->busca!=""){
      $contatos = Contatos::where('nome', 'like', '%' .  $request->busca . '%')
                            ->orWhere('sobrenome', 'like', '%' .  $request->busca . '%')
                            ->orWhere('endereco', 'like', '%' .  $request->busca . '%')
                            ->orWhere('cpf', 'like', '%' .  $request->busca . '%')
                            ->orWhere('cidade', 'like', '%' .  $request->busca . '%')
                            ->orWhere('uf', 'like', '%' .  $request->busca . '%')
                            ->orWhere('bairro', 'like', '%' .  $request->busca . '%')
                            ->orWhere('cep', 'like', '%' .  $request->busca . '%')
                            ->get();
        $a = 0;
        while ($a < count($contatos)) {
          $atendimentos = $atendimentos->orWhere('contatos_id', '=', $contatos[$a]->id);
          $a++;
        }
    }
    $atendimentos = $atendimentos->orderBy('created_at', 'desc')->paginate(30);

    if ((is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1) and $request->deletados){
        $deletados = atendimento::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }

    $total= Atendimento::count();
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Atendimentos')->get();

    Log::info('Mostando atendimentos com busca -> "'.$request->busca.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return view('atend.index')->with('atendimentos', $atendimentos)->with('total', $total)->with('comboboxes', $comboboxes)->with('deletados', $deletados);
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
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Atendimentos')->get();
    Log::info('Criando novo atendimento, selecionando contato com busca -> "'.$request->busca.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return view('atend.contatos')->with('contatos', $contatos)->with('comboboxes', $comboboxes);
  }

  public function novo($id){
    $contato = Contatos::find($id);

    Log::info('Criando novo atendimento para contato -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('atend.index')->with('contato', $contato);
  }

  public function edit(request $request, $id){
    $this->validate($request, [
        'assunto' => 'required|max:50',
    ]);
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

    $path = storage_path() . '/' .'app/'. $attach->path;
    $extension = File::extension($attach->path);
    if ($extension=="JPG" or $extension=="JPEG" or $extension=="PNG" or $extension=="GIF") {
      $file = Image::make($path);
    } else {
      $file = Storage::put(storage_path() . '/' .'app', $request->file);
    }

    Log::info('Anexando arquivo para atendimento, anexo -> "'.$attach.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return redirect()->action('AtendimentoController@index');
  }

}
