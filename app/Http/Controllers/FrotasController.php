<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Frotas;
use App\Contatos;
use Log;
use Auth;

class FrotasController extends BaseController
{
  public function __construct(){
     parent::__construct();
  }

  public function index()
  {
    Log::info('Lista de Frota para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $frotas = Frotas::all();
    $deletados = 0;
    return view('frotas.index')
                ->with('frotas', $frotas)
                ->with('deletados', $deletados);
  }
  public function detalhes($id)
  {
    Log::info('Detalhes de Frota para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $frota = frotas::find($id);
    return view('frotas.detalhes')
                ->with('frota', $frota);

  }

  public function novo()
  {
    Log::info('Novo Frota para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $contatos = Contatos::orderBy('nome', 'asc')->paginate(15);
    return view('frotas.contatos')
                ->with('contatos', $contatos);
  }
  public function novo_2($id){
    Log::info('Novo Frota com ID: '.$id.' para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $contato = Contatos::find($id);
    return view('frotas.novo')
                ->with('contato', $contato);
  }
  public function criar($id, request $request){
    Log::info('Criar nova  Frota com ID: '.$id.' para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $contato = Contatos::find($id);
    $frota = new Frotas;
    $frota->contatos_id = $contato->id;
    $frota->marca=$request->marca;
    $frota->placa=$request->placa;
    $frota->modelo=$request->modelo;
    $frota->combustivel=$request->combustivel;
    $frota->ano=$request->ano;
    $frota->renavan=$request->renavan;
    $frota->chassis=$request->chassis;
    $frota->save();

    return redirect()->action('FrotasController@index');
  }
  public function delete($id){
    Log::info('Deletar Frota com ID: '.$id.' para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $frota = frotas::withTrashed()->find($id);

    if ($frota->trashed()) {
      $frota->restore();
    } else {
      $frota->delete();
    }

    return redirect()->action('FrotasController@index');
  }
  public function edit($id){
    Log::info('Editar Frota com ID: '.$id.' para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    $frota = Frotas::find($id);
    return view('frotas.novo')
                ->with('frota', $frota);
  }
  public function salvar($id, request $request){
    Log::info('Guardar Frota com ID: '.$id.' para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $frota = Frotas::find($id);
    $frota->marca=$request->marca;
    $frota->placa=$request->placa;
    $frota->modelo=$request->modelo;
    $frota->combustivel=$request->combustivel;
    $frota->ano=$request->ano;
    $frota->renavan=$request->renavan;
    $frota->chassis=$request->chassis;
    $frota->save();

    return redirect()->action('FrotasController@index');
  }
}
