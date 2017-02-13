<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Frotas;
use App\Contas;
use App\Contatos;
use App\Abastecimentos;
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
  public function abastecer($id){
    Log::info('Mostrando abastecimento de Frota com ID: '.$id.' para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $frota = frotas::find($id);
    return view('frotas.abastecer')
                ->with('frota', $frota);
  }
  public function abastecer_editar($id, $id_abastecimento){
    Log::info('Mostrando abastecimento de Frota com ID: '.$id.' para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $frota = frotas::find($id);
    $abastecimento = abastecimentos::find($id_abastecimento);
    return view('frotas.abastecer')
                ->with('frota', $frota)
                ->with('abastecimento', $abastecimento);

  }
  public function abastecer_salvar($id, request $request){
    Log::info('Mostrando abastecimento de Frota com ID: '.$id.' para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    $this->validate($request, [
      'abastecido_em' => 'required',
      'abastecido_por' => 'required',
      'data' => 'required',
    ]);

    $date_temp = date_create($request->data);
    $frota = frotas::find($id);
    $abastecer = new abastecimentos;
    $abastecer->frotas_id = $id;
    $abastecer->data = $date_temp;
    $abastecer->combustivel = $request->combustivel;
    $abastecer->documento = $request->documento;
    $abastecer->lts = $request->lts;
    $abastecer->preco_lts = $request->preco_lts;
    $abastecer->km_anterior = $request->km_anterior;
    $abastecer->km_atual = $request->km_atual;
    $abastecer->km_rodado = $request->km_rodado;
    $abastecer->km_lts = $request->km_lts;
    $abastecer->abastecido_em = $request->abastecido_em;
    $abastecer->abastecido_por = $request->abastecido_por;

    $conta = new contas;
    $conta->tipo = 0;
    $conta->contatos_id = $request->abastecido_em;
    $conta->nome = "Abastecer ".$frota->placa;
    $conta->pagamento = "Dinheiro";
    $conta->vencimento = $date_temp;
    $conta->valor = $request->preco_lts*$request->lts;
    $conta->dm = $request->documento;

    if($request->km_atual!=""){
      $conta->estado="0";
      $abastecer->estado = "0";
    } else {
      $conta->estado="1";
      $abastecer->estado = "1";
    }

    $conta->descricao = "Referente a abastecimento";
    $conta->save();
    $abastecer->contas_id = $conta->id;
    $abastecer->save();

    return redirect()->action('FrotasController@index');
  }
  public function abastecer_guardar($id, $id_abastecimento, request $request){
    Log::info('Mostrando abastecimento de Frota com ID: '.$id.' para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $date_temp = date_create($request->data);
    $abastecer = abastecimentos::find($id_abastecimento);
    $abastecer->data = $date_temp;
    $abastecer->combustivel = $request->combustivel;
    $abastecer->documento = $request->documento;
    $abastecer->lts = $request->lts;
    $abastecer->preco_lts = $request->preco_lts;
    $abastecer->km_anterior = $request->km_anterior;
    $abastecer->km_atual = $request->km_atual;
    $abastecer->km_rodado = $request->km_rodado;
    $abastecer->km_lts = $request->km_lts;
    $abastecer->abastecido_em = $request->abastecido_em;
    $abastecer->abastecido_por = $request->abastecido_por;

    if($request->km_atual!=""){
      $abastecer->estado = "0";
    } else {
      $abastecer->estado = "1";
    }

    $abastecer->save();

    return redirect()->action('FrotasController@index');
  }
  public function abastecer_delete($id){
    Log::info('Apagar abastecimento de Frota com ID: '.$id.' para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $abastecimento = abastecimentos::withTrashed()->find($id);
    $conta = contas::withTrashed()->find($abastecimento->conta->id);

    if ($abastecimento->trashed()) {
      $abastecimento->restore();
    } else {
      $abastecimento->delete();
    }
    if ($conta->trashed()) {
      $conta->restore();
    } else {
      $conta->delete();
    }
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
