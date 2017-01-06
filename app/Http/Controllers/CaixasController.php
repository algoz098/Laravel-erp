<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caixas as Caixas;
use App\Contas as Contas;
Use App\Movs as Movs;
Use App\Movs_prestacao as Prestacao;
use App\Combobox_texts as Comboboxes;
use Auth;
use DateTime;
use Log;
Use App\Http\Controllers\CaixasLib;
Use Carbon\Carbon;


class CaixasController extends Controller
{
    public function index(){
      Log::info('Vendo movimentação de caixa da filial -> "'.Auth::user()->trabalho_id.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $estado_caixa = new CaixasLib;
      $caixa = $estado_caixa->myCaixas();
      $deletados = 0;
      if (!$estado_caixa->isOpen()){
        $caixa = 0;
        $inicial = 0;
      } else {
        $inicial = $caixa->valor;
        foreach ($caixa->movs as $key => $mov) {
          if ($mov->tipo=="1"){
            $inicial =  $inicial - $mov->valor;
          } elseif ($mov->tipo=="0"){
            $inicial =  $inicial + $mov->valor;
          }
        }
      }
      return view('caixa.index')->with('caixa', $caixa)->with('deletados', $deletados)->with('atual', $inicial);
    }

    public function new_a(){
      Log::info('Criando movimentação de caixa da filial -> "'.Auth::user()->trabalho_id.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $comboboxes = comboboxes::where('combobox_textable_type', 'App\Contas')->get();
      return view('caixa.new')->with('comboboxes', $comboboxes);
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
      Log::info('Vendo movimentação de caixa da filial -> "'.Auth::user()->trabalho_id.'", com busca -> "data:'.$data.', tipo:'.$request->tipo.'" para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

      return view('caixa.index')->with('caixas', $caixas)->with('deletados', $deletados);
    }

    public function new_do(request $request ){
      $estado_caixa = new CaixasLib;
      if ($request->tipo=="99"){
        $this->validate($request, [
            'valor' => 'required|numeric',
        ]);
        if (!$estado_caixa->isOpen()){
          $mov = new Caixas;
          $mov->estado = 0;
          $mov->valor = $request->valor;
          $mov->filial_id = Auth::user()->trabalho->id;
          $mov->funcionario_id = Auth::user()->contato->id;
          $mov->save();
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
          return redirect()->action('CaixasController@index');
        } else {
          $messages = "Caixa já aberto!";
          return redirect()->action('CaixasController@new_a')->withErrors($messages);
        }
      }


      if ($estado_caixa->isClosed()){
        $messages = "Este caixa ja foi fechado!";
        return redirect()->action('CaixasController@new_a')->withErrors($messages);
      }
      if (!$estado_caixa->isOpen()){
        $messages = "Caixa nao aberto!";
        return redirect()->action('CaixasController@new_a')->withErrors($messages);
      }

      $caixa = $estado_caixa->myCaixas();
      $mov = new movs;
      $mov->caixas_id = $caixa->id;
      $mov->valor = $request->valor;
      $mov->tipo = $request->tipo;
      $mov->estado = "0";
      $mov->nome = $request->nome;
      $mov->obs = $request->obs;
      $mov->save();
      Log::info('Salvando movimentação de caixa da filial -> "'.Auth::user()->trabalho_id.'",com dados -> "'.$request.'" para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

      return redirect()->action('CaixasController@index');
    }

    public function fechar(){
      $caixas = Caixas::where("estado", 0)->paginate(15);
      foreach ($caixas as $key => $caixa) {
        $caixa->att = 0;
        foreach ($caixa->movs as $key => $mov) {
          if ($mov->estado=="0"){
            $caixa->att = 1;
          }
        }
      }
      return view('caixa.fechar')->with('caixas', $caixas);
    }

    public function pendencias($id){
      $caixa = Caixas::find($id);
      foreach ($caixa->movs as $key => $mov) {
        if ($mov->estado=="0"){
          $movs[] = $mov;
        }
      }
      if(!isset($movs)){
        $movs=0;
      }
      return view('caixa.pendencias')->with('movs', $movs)->with('caixa', $caixa);
    }

    public function prestacao(request $request, $id, $mov_id){
      $prestacao = new Prestacao;
      $prestacao->valor = $request->recebido;
      $prestacao->justificativa = $request->justificativa;
      $prestacao->movs_id = $mov_id;
      $prestacao->save();
      $mov = Movs::find($mov_id);
      $valor_total = 0;
      foreach ($mov->prestacoes as $key => $prestacoes) {
        $valor_total = $valor_total + $prestacoes->valor;
      }
      if ($valor_total>=$mov->valor){
        $mov->estado = "1";
        $mov->save();
      }
      return redirect()->action('CaixasController@pendencias', ['id' => $id]);
    }
    public function concluir($id){
      $caixa = Caixas::find($id);
      foreach ($caixa->movs as $key => $mov) {
        if ($mov->estado=="0"){
          return redirect()->action('CaixasController@pendencias');
        }
      }
      $caixa->estado = 1;
      $caixa->save();
      return redirect()->action('CaixasController@index');
    }

    public function delete($id){
      $movimentacao = Caixas::withTrashed()->find($id);
      if ($movimentacao->trashed()) {
        Log::info('Restaurando movimentação de caixa -> "'.$movimentacao.'" da filial -> "'.Auth::user()->trabalho_id.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
        $movimentacao->restore();
      } else {
        Log::info('Deletando movimentação de caixa -> "'.$movimentacao.'" da filial -> "'.Auth::user()->trabalho_id.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
        $movimentacao->delete();
      }
      return redirect()->action('CaixasController@index');
    }
}
