<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Produtos_grupos as Grupos;
use App\Produtos_tipos as Tipos;

use Log;
use Auth;

class GruposController extends Controller
{

  public function busca(request $request)
  {
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return response()->json([__('messages.perms.leitura')], 403);
    }
    $grupos = Grupos::with('tipos')->paginate(15);
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return $grupos;
  }

  public function salva(request $request)
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return response()->json([__('messages.perms.adicao')], 403);
    }
    if($request->id!=""){
      $grupo = Grupos::find($request->id);
    } else {
      $grupo = new Grupos;
    }
    $grupo->nome = $request->nome;
    $grupo->save();
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return response()->json([__('messages.adicao.sucesso')], 201);
  }

  public function editar($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
      return response()->json([__('messages.perms.edicao')], 403);
    }
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $grupo = Grupos::find($id);
    return $grupo;
  }

  public function busca_tipos($id, request $request)
  {
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return response()->json([__('messages.perms.leitura')], 403);
    }
    $tipos = Tipos::with('grupo')->where('produtos_grupos_id', $id)->paginate(15);
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return $tipos;
  }
  public function salva_tipos($id, request $request)
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return response()->json([__('messages.perms.adicao')], 403);
    }
    if($request->id!=""){
      $tipo = Tipos::find($request->id);
    } else {
      $tipo = new Tipos;
    }
    $tipo->nome = $request->nome;
    $tipo->produtos_grupos_id = $id;
    $tipo->save();

    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return response()->json([__('messages.adicao.sucesso')], 201);
  }
}
