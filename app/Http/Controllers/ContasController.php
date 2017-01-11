<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Contas as Contas;
use App\Contatos as Contatos;
use App\Combobox_texts as Comboboxes;
use App\Discriminacoes as Discs;
use Log;

class ContasController extends Controller
{
  public function index(){
    Log::info('Vendo contas, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $contas = Contas::paginate(15);
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Contas::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    $total= Contas::count();
    return view('contas.index')->with('contas', $contas)->with('deletados', $deletados)->with('total', $total);
  }
  public function search(Request $request){
    $contas = Contas::query();
    if ($request->debito){
      $contas = $contas->orWhere('tipo', '0');
    }
    if ($request->credito){
      $contas = $contas->orWhere('tipo', '1');
    }
    if ($request->vencer){
      $contas = $contas->orWhere('vencimento', '>', Carbon::today()->toDateString());
    }
    if ($request->vencido){
      $contas = $contas->orWhere('vencimento', '<', Carbon::today()->toDateString());
    }
    if ($request->pago){
      $contas = $contas->orWhere('estado', '1');
    }
    if ($request->pagar){
      $contas = $contas->orWhere('estado', '0');
    }
    if (!empty($request->valor)){
      $contas = $contas->orWhere('valor', '>', $request->valor);
    }
    if (!empty($request->referencia)){
      $contas = $contas->whereRaw('id = referente');
    }
    if (!empty($request->parcelas)){
      $contas = $contas->whereRaw('id != referente');
    }
    if (!empty($request->contato)){
      $contatos = Contatos::where('nome', 'like', '%' .  $request->contato . '%')
                            ->orWhere('sobrenome', 'like', '%' .  $request->contato . '%')
                            ->orWhere('endereco', 'like', '%' .  $request->contato . '%')
                            ->orWhere('cpf', 'like', '%' .  $request->contato . '%')
                            ->orWhere('cidade', 'like', '%' .  $request->contato . '%')
                            ->orWhere('uf', 'like', '%' .  $request->contato . '%')
                            ->orWhere('bairro', 'like', '%' .  $request->contato . '%')
                            ->orWhere('cep', 'like', '%' .  $request->contato . '%')
                            ->get();
        $a = 0;
        while ($a < count($contatos)) {
          $contas = $contas->orWhere('contatos_id', '=', $contatos[$a]->id);
          $a++;
        }
    }
    $contas = $contas->paginate(15);
    Log::info('Vendo contas com busca "'.$request.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $deletados = 0;
    return view('contas.index')->with('contas', $contas)->with('deletados', $deletados);
  }

  public function novo(){
    Log::info('Adicionando contas, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $contatos = Contatos::paginate(15);
    return view('contas.contatos')->with('contatos', $contatos);
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
    Log::info('Adicionando contas com busca -> "'.$request->busca.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Contas::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    return view('contas.index')->with('contas', $contas)->with('deletados', $deletados);
  }
  public function add(Request $request){
    $conta = new Contas;
    $conta->contatos_id = $request->contatos_id;
    $conta->nome = $request->nome;
    $conta->valor = $request->val;
    $conta->vencimento = $request->venc;
    $conta->descricao = $request->descricao;
    $conta->tipo = $request->tipo;
    $conta->estado = $request->estado;
    $conta->dm = $request->dm;
    $conta->save();
    $conta->referente = $conta->id;
    $conta->save();
    if ($request->parcelas>0){
      $i = 0;
      while ($i < count($request->valor)) {
        $parcela = new Contas;
        $parcela->contatos_id = $request->contatos_id;
        $parcela->referente = $conta->id;
        $parcela->nome = $request->nome.' '.$i;
        $parcela->valor = $request->valor[$i];
        $parcela->vencimento = $request->vencimento[$i];
        $parcela->descricao = $request->descricao;
        $parcela->tipo = $request->tipo;
        $parcela->estado = $request->estado;
        $parcela->save();
        $i++;
      }
    }
    Log::info('Salvando contas -> "'.$conta.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return redirect()->action('ContasController@index');
  }

  public function pago($id){
    $conta = Contas::find($id);
    if ($conta->estado==1) {
      $conta->estado = '0';
      Log::info('Mudando conta para NÃO paga -> "'.$conta.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    } elseif ($conta->estado == 0) {
      $conta->estado = '1';
      Log::info('Mudando conta para paga -> "'.$conta.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    }
    $conta->save();
    return redirect()->action('ContasController@index');
  }

  public function delete($id){
    $conta = Contas::withTrashed()->find($id);

    if ($conta->trashed()) {
      Log::info('Restaurando conta -> "'.$conta.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $conta->restore();
    } else {
      Log::info('Deletando conta -> "'.$conta.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $conta->delete();
    }
    return redirect()->action('ContasController@index');
  }
  public function add_2(request $request, $id){
    $contato = Contatos::find($id);
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Contas')->get();
    Log::info('Adicionar CONTA passo 2, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('contas.valores')->with('contato', $contato)->with('comboboxes', $comboboxes);
  }
  public function add_3(request $request, $id){
    $this->validate($request, [
        'tipo' => 'required',
        'forma' => 'required',
        'nome' => 'required|max:50',
        'cheio' => 'required|numeric',
    ]);
    $contato = Contatos::find($id);
    $conta = new Contas;
    $conta->contatos_id = $contato->id;
    $conta->nome = $request->nome;
    $conta->valor = $request->cheio;
    $conta->vencimento = $request->vencimento;
    $conta->descricao = $request->descricao;
    $conta->tipo = $request->tipo;
    $conta->dm = $request->dm;
    $conta->estado = $request->estado;
    if (!$request->desconto){
      $conta->desconto = "0";
    } else {
      $conta->desconto = $request->desconto;
    }
    $conta->pagamento = $request->forma;
    $conta->save();
    $conta->referente = $conta->id;
    $conta->save();
    if ($request->tipo=="2"){
      foreach ($request->disc_text as $key => $text) {
        $disc = new Discs;
        $disc->contas_id = $conta->id;
        $disc->nome = $request->disc_text[$key];
        $disc->valor = $request->disc_valor[$key];
        $disc->save();
      }
    }
    Log::info('Adicionar CONTA passo 3, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    if ($request->parcelas>0){
      $i = 0;
      if (!empty($conta->desconto)){
        $parcela = ($conta->valor - $conta->desconto)/$request->parcelas;
      }
      $parcela = $conta->valor/$request->parcelas;
      while ($i < $request->parcelas) {
        $i = $i + 1;
        $vencimentos[$i] = Carbon::today()->addMonths($i);
      }
      return view('contas.parcelas')->with('contato', $contato)->with('conta', $conta)->with('vencimentos', $vencimentos)->with('parcela', $parcela);
    }
    return redirect()->action('ContasController@index');
  }

  public function add_4(request $request, $id, $conta_id){
    $conta= Contas::find($conta_id);
    foreach ($request->parcela as $key => $parcela) {
      $parcela1 = new Contas;
      $parcela1->contatos_id = $conta->contatos_id;
      $parcela1->nome = $conta->nome." ".$key." de ".sizeof($request->parcela);
      $parcela1->valor = $parcela;
      $parcela1->vencimento = $request->vencimento[$key];
      $parcela1->descricao = "";
      $parcela1->tipo = $conta->tipo;
      $conta->dm = $conta->dm;
      $parcela1->estado = "0";
      if ($request->desconto[$key]!=""){
        $parcela1->desconto = $request->desconto[$key];
      } else {
        $parcela1->desconto = null;
      }
      $parcela1->pagamento = $request->forma[$key];
      $parcela1->referente = $conta->id;
      $parcela1->save();
    }
    #return "ok";
    return redirect()->action('ContasController@index');
  }
}
