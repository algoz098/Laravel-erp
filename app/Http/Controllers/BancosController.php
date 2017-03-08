<?php

namespace App\Http\Controllers;
use Datetime;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Contas as Contas;
use App\Bancos as Bancos;
use App\Contatos as Contatos;
use Log;

class BancosController  extends BaseController
{
  public function __construct(){
     parent::__construct();
  }

  public function index(){
    Log::info('Vendo bancos, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $bancos = Bancos::paginate(15);

    return view('bancos.index')->with('bancos', $bancos);
  }

  public function selecionar(){
    Log::info('Selecionar bancos, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $bancos = Bancos::paginate(15);

    return view('bancos.selecionar')->with('bancos', $bancos);
  }
  public function selecionar_busca(request $request){
    Log::info('Selecionar  busca bancos, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $bancos = bancos::query();
    if (!empty($request->busca)){
      $bancos = $bancos->orWhere('valor', 'like', '%' .  $request->busca . '%');
      $bancos = $bancos->orWhere('tipo', 'like', '%' .  $request->busca . '%');
      $bancos = $bancos->orWhere('agencia', 'like', '%' .  $request->busca . '%');
      $bancos = $bancos->orWhere('cc', 'like', '%' .  $request->busca . '%');
      $bancos = $bancos->orWhere('cc_dig', 'like', '%' .  $request->busca . '%');
      $bancos = $bancos->orWhere('comp', 'like', '%' .  $request->busca . '%');
    }
    $bancos = Bancos::paginate(15);

    return view('bancos.selecionar_parte')->with('bancos', $bancos);
  }
  public function detalhes($id){
    Log::info('Detalhes de banco, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $banco = Bancos::find($id);

    return view('bancos.detalhes')->with('banco', $banco);
  }
  public function novo(){
    Log::info('Criando conta em banco, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('bancos.novo');
  }
  public function editar($id){
    Log::info('Editando conta em banco, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $banco = bancos::find($id);
    return view('bancos.novo')->with("banco", $banco);
  }
  public function salva(request $request){
    Log::info('Salvando conta em banco, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $banco = new Bancos;
    $banco->contatos_id = $request->contatos_id;
    $banco->filial_id = $request->filiais_id;
    $banco->cc = $request->cc;
    $banco->cc_dig = $request->cc_dig;
    $banco->tipo = $request->tipo;
    $banco->agencia = $request->agencia;
    $banco->comp = $request->comp;
    $banco->valor = $request->valor;
    $banco->save();
    return redirect()->action('BancosController@index');
  }
  public function atualiza($id, request $request){
    Log::info('Salvando conta em banco, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $banco = bancos::find($id);
    $banco->contatos_id = $request->contatos_id;
    $banco->filial_id = $request->filiais_id;
    $banco->cc = $request->cc;
    $banco->cc_dig = $request->cc_dig;
    $banco->tipo = $request->tipo;
    $banco->agencia = $request->agencia;
    $banco->comp = $request->comp;
    $banco->valor = $request->valor;
    $banco->save();
    return redirect()->action('BancosController@index');

  }
  public function delete($id){
    Log::info('Salvando conta em banco, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $banco = Bancos::withTrashed()->find($id);
    if ($banco->trashed()) {
      $banco->restore();
      Log::info('Restaurando banco -> "'.$banco.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    } else {
      Log::info('Deletando banco -> "'.$banco.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $banco->delete();
    }
    return redirect()->action('BancosController@index');

  }
}
