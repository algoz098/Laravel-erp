<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contatos as Contatos;
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


class CaixasController  extends BaseController
{
  public function __construct(){
     parent::__construct();
  }
  
    public function index(){
      Log::info('Vendo movimentação de caixa da filial -> "'.Auth::user()->trabalho_id.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $estado_caixa = new CaixasLib;
      $caixas = Caixas::where('filial_id', Auth::user()->trabalho_id)
                      ->where('estado', '0')
                      ->get();
      if (!$estado_caixa->isOpen()){
        $caixa_atual = 0;
        $inicial = 0;
      } else {
        $caixa_atual = $estado_caixa->MyCaixas();
        $inicial = $caixa->valor;
        foreach ($caixa_atual->movs as $key => $mov) {
          if ($mov->tipo=="1"){
            $inicial =  $inicial - $mov->valor;
          } elseif ($mov->tipo=="0"){
            $inicial =  $inicial + $mov->valor;
          }
        }
      }
      $a = "Filial";
      $filiais = Contatos::whereHas('from', function ($query) use ($a){
        $query->where('from_text', 'like', '%'.$a.'%');
      })->get();
      $deletados = 0;
      $comboboxes = comboboxes::where('combobox_textable_type', 'App\Relacionamento')->get();
      return view('caixa.index')->with('caixa_atual', $caixa_atual)
                                ->with('caixas', $caixas)
                                ->with('deletados', $deletados)
                                ->with('atual', $inicial)
                                ->with('comboboxes', $comboboxes)
                                ->with('filiais', $filiais);
    }

    public function search(request $request){
      $caixas = caixas::query();
      if ($request->data!=""){
        $caixas = $caixas->whereDate('created_at', $request->data.' 00:00:00');
      }
      if ($request->filial!=""){
        $caixas = $caixas->where('filial_id', $request->filial);
      } else {
        $caixas = $caixas->where('filial_id', Auth::user()->trabalho_id);
      }
      if ($request->estado!=""){
        $caixas = $caixas->where('estado', $request->estado);
      }
      if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1 and $request->deletados){
        $deletados = Caixas::onlyTrashed()->get();
      } else {
        $deletados = 0;
      }

      $caixas = $caixas->get();
      Log::info('Vendo movimentação de caixa da filial -> "'.Auth::user()->trabalho_id.'", com busca -> "tipo:'.$request->tipo.'" para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $estado_caixa = new CaixasLib;
      if (!$estado_caixa->isOpen()){
        $caixa_atual = 0;
        $inicial = 0;
      } else {
        $caixa_atual = $estado_caixa->MyCaixas();
        $inicial = $caixa->valor;
        foreach ($caixa_atual->movs as $key => $mov) {
          if ($mov->tipo=="1"){
            $inicial =  $inicial - $mov->valor;
          } elseif ($mov->tipo=="0"){
            $inicial =  $inicial + $mov->valor;
          }
        }
      }
      $a = "Filial";
      $filiais = Contatos::whereHas('from', function ($query) use ($a){
        $query->where('from_text', 'like', '%'.$a.'%');
      })->get();
      $deletados = 0;
      $comboboxes = comboboxes::where('combobox_textable_type', 'App\Relacionamento')->get();
      return view('caixa.index')->with('caixa_atual', $caixa_atual)
                                ->with('caixas', $caixas)
                                ->with('deletados', $deletados)
                                ->with('atual', $inicial)
                                ->with('comboboxes', $comboboxes)
                                ->with('filiais', $filiais);
    }

    public function new_do(request $request ){
      if(isset($request->caixa_id)){
        $caixa = Caixas::find($request->caixa_id);
        if($caixa->estado==1){
          $messages = "Este caixa ja foi fechado!";
          return redirect()->action('CaixasController@new_a')->withErrors($messages);
        }
        $mov = new movs;
        $mov->caixas_id = $request->caixa_id;
        $mov->valor = $request->valor;
        $mov->tipo = $request->tipo;
        $mov->estado = "0";
        $mov->nome = $request->nome;
        $mov->obs = $request->obs;
        $mov->save();
      } else {
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
      }

      Log::info('Salvando movimentação de caixa da filial -> "'.Auth::user()->trabalho_id.'",com dados -> "'.$request.'" para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

      return redirect()->action('CaixasController@index');
    }
    public function new_a(){
      Log::info('Criando movimentação de caixa da filial -> "'.Auth::user()->trabalho_id.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $comboboxes = comboboxes::where('combobox_textable_type', 'App\Contas')->get();
      return view('caixa.new')->with('comboboxes', $comboboxes);
    }
    public function movimentacao_novo($id ){
      Log::info('Criando movimentação de caixa da filial -> "'.Auth::user()->trabalho_id.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $comboboxes = comboboxes::where('combobox_textable_type', 'App\Contas')->get();
      $caixa = Caixas::find($id);
      return view('caixa.new')->with('comboboxes', $comboboxes)->with('caixa', $caixa);
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
