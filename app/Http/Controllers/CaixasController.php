<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caixas as Caixas;
use App\Contas as Contas;
Use Carbon\Carbon;
use Auth;
use DateTime;

class CaixasController extends Controller
{
    public function index(){
      $caixas = Caixas::whereRaw('date(created_at) = ?', [Carbon::today()])
                      ->where('filial_id', Auth::user()->trabalho_id)
                      ->paginate(15);
      $deletados = 0;
      #return $caixas;
      if (!isset($caixas[0])){
        $messages = "É preciso abrir o caixa";
        return redirect()->action('CaixasController@new')->withErrors($messages);
      }
      return view('caixa.index')->with('caixas', $caixas)->with('deletados', $deletados);
    }

    public function new(){
      return view('caixa.new');
    }

    public function search(request $request){
      if (!empty($request->data)){
        $data = $request->data;
      } else {
        $data = Carbon::today();
      }

      $caixas = caixas::query();
      if ($request->tipo){
        $caixas = $caixas->orWhere('tipo', $request->tipo);
      }
      $caixas = $caixas->whereRaw('date(created_at) = ?', [$data]);

      if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1 and $request->deletados){
          $deletados = Caixas::onlyTrashed()
                          ->whereRaw('date(created_at) = ?', [$data])
                          ->get();
      } else {
        $deletados = 0;
      }

      $caixas = $caixas->paginate(15);
      return view('caixa.index')->with('caixas', $caixas)->with('deletados', $deletados);
    }

    public function new_do(request $request ){
      $abertura = Caixas::whereRaw('date(created_at) = ?', [Carbon::today()])
                      ->orderBy('created_at', 'aaaa')
                      ->where('filial_id', Auth::user()->trabalho_id)
                      ->where('tipo', '0')
                      ->first();
      $fechamento = Caixas::whereRaw('date(created_at) = ?', [Carbon::today()])
                      ->orderBy('created_at', 'aaaa')
                      ->where('filial_id', Auth::user()->trabalho_id)
                      ->where('tipo', '1')
                      ->first();

      if (is_null($abertura)){
        if ($request->tipo!="0"){
          $messages = "Caixa ainda não aberto!";
          return redirect()->action('CaixasController@new')->withErrors($messages);
        }
      }
      if (!is_null($abertura)){
        if ($request->tipo=="0" and is_null($fechamento)){
          $messages = "Caixa ja aberto!";
          return redirect()->action('CaixasController@new')->withErrors($messages);
        }

        if (!is_null($fechamento)){
          if ($request->tipo=="0" and strtotime($abertura->created_at) > strtotime($fechamento->created_at)){
            $messages = "Caixa ja aberto";
            return redirect()->action('CaixasController@new')->withErrors($messages);
          }
          if (!empty($fechamento) and $request->tipo=="1" and strtotime($abertura->created_at) < strtotime($fechamento->created_at)){
            $messages = "Caixa já fechado!";
            return redirect()->action('CaixasController@new')->withErrors($messages);
          }
          if (!empty($fechamento) and $request->tipo=="2" and strtotime($abertura->created_at) < strtotime($fechamento->created_at)){
            $messages = "Caixa já fechado!";
            return redirect()->action('CaixasController@new')->withErrors($messages);
          }
        }
      }

      $movimentacao = new Caixas;
      $movimentacao->filial_id = Auth::user()->trabalho->id;
      $movimentacao->funcionario_id = Auth::user()->contato->id;
      $movimentacao->vendas_id="0";
      $movimentacao->pag = "0";
      $movimentacao->tipo = $request->tipo;
      $movimentacao->valor = $request->valor;
      if ($request->forma=="0"){
        $movimentacao->forma="0";
      } elseif ($request->forma=="1") {
        $movimentacao->forma="1";
      }

      if ($request->tipo=="1") {
        $conta = new Contas;
        $conta->contatos_id = Auth::user()->trabalho->id;
        $conta->nome = "Fechamento de Caixa";
        $conta->valor = $request->valor;
        $conta->vencimento = Carbon::now();
        $conta->descricao = Auth::user()->contato->nome." em ".Carbon::now();
        $conta->tipo = "1";
        $conta->estado = "1";
        $conta->save();
        $conta->referente = $conta->id;
        $conta->save();
      }
      if ($request->tipo=="0") {
        $conta = new Contas;
        $conta->contatos_id = Auth::user()->trabalho->id;
        $conta->nome = "Abertura de Caixa";
        $conta->valor = $request->valor;
        $conta->vencimento = Carbon::now();
        $conta->descricao = Auth::user()->contato->nome." em ".Carbon::now();
        $conta->tipo = "0";
        $conta->estado = "1";
        $conta->save();
        $conta->referente = $conta->id;
        $conta->save();
      }
      $movimentacao->save();

      return redirect()->action('CaixasController@index');
    }

    public function delete($id){
      $movimentacao = Caixas::withTrashed()->find($id);
      if ($movimentacao->trashed()) {
        $movimentacao->restore();
      } else {
        $movimentacao->delete();
      }
      return redirect()->action('CaixasController@index');
    }
}
