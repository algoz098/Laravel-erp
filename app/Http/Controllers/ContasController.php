<?php

namespace App\Http\Controllers;
use Datetime;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Contas as Contas;
use App\Bancos as Bancos;
use App\Contatos as Contatos;
use App\Contas_consumos as consumos;
use App\Combobox_texts as Comboboxes;
use App\Discriminacoes as Discs;
use Log;

class ContasController  extends BaseController
{
  public function __construct(){
     parent::__construct();
  }

  public function search(Request $request){
    if (!isset(Auth::user()->perms["contas"]["leitura"]) or Auth::user()->perms["contas"]["leitura"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.leitura')]);
    }
    $contas = Contas::query();
    $contas = $contas->orderBy('vencimento', 'desc');
    $contas = $contas->with('contato', 'banco.banco');
    // if ($request->data_de){
    //   $data_de = DateTime::createFromFormat('d-m-Y', $request->data_de);
    //   $data_de = $data_de->format('Y-m-d');
    //   if (!$request->data_ate){
    //     $contas = $contas->whereDate('vencimento', '>=', $data_de);
    //   }
    // }
    // if ($request->data_de and $request->data_ate){
    //   $data_ate = DateTime::createFromFormat('d-m-Y', $request->data_ate);
    //   $data_ate = $data_ate->format('Y-m-d');
    //   $contas = $contas->whereBetween('vencimento', [$data_de, $data_ate]);
    // }
    // if ($request->debito){
    //   $contas = $contas->orWhere('tipo', '0');
    // }
    // if ($request->credito){
    //   $contas = $contas->orWhere('tipo', '1');
    // }
    // if ($request->vencer){
    //   $contas = $contas->orWhere('vencimento', '>', Carbon::today()->toDateString());
    // }
    // if ($request->vencido){
    //   $contas = $contas->orWhere('vencimento', '<', Carbon::today()->toDateString());
    // }
    // if ($request->pago){
    //   $contas = $contas->orWhere('estado', '1');
    // }
    // if ($request->pagar){
    //   $contas = $contas->orWhere('estado', '0');
    // }
    // if (!empty($request->valor)){
    //   $contas = $contas->orWhere('valor', '>', $request->valor);
    // }
    // if (!empty($request->referencia)){
    //   $contas = $contas->whereRaw('id = referente');
    // }
    // if (!empty($request->parcelas)){
    //   $contas = $contas->whereRaw('id != referente');
    // }
    // if (!empty($request->contato)){
    //   $contatos = Contatos::where('nome', 'like', '%' .  $request->contato . '%')
    //                         ->orWhere('sobrenome', 'like', '%' .  $request->contato . '%')
    //                         ->orWhere('endereco', 'like', '%' .  $request->contato . '%')
    //                         ->orWhere('cpf', 'like', '%' .  $request->contato . '%')
    //                         ->orWhere('cidade', 'like', '%' .  $request->contato . '%')
    //                         ->orWhere('uf', 'like', '%' .  $request->contato . '%')
    //                         ->orWhere('bairro', 'like', '%' .  $request->contato . '%')
    //                         ->orWhere('cep', 'like', '%' .  $request->contato . '%')
    //                         ->get();
    //     $a = 0;
    //     while ($a < count($contatos)) {
    //       $contas = $contas->orWhere('contatos_id', '=', $contatos[$a]->id);
    //       $a++;
    //     }
    // }
    #return $contas->toSql();
    $contas = $contas->paginate(100);
    $deletados = 0;
    $total_debito = Contas::where('tipo', '!=', '1')->where('estado', '1')->sum('valor');
    $total_credito = Contas::where('tipo', '1')->where('estado', '1')->sum('valor');
    $total_apagar = Contas::where('tipo', '!=', '1')->where('estado', '0')->sum('valor');
    $total_areceber = Contas::where('tipo', '1')->where('estado', '0')->sum('valor');
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Contas')->get();

    $retorno['contas'] = $contas;
    // $retorno['total_debito'] = $total_debito;
    // $retorno['total_credito'] = $total_credito;
    // $retorno['total_apagar'] = $total_apagar;
    // $retorno['total_areceber'] = $total_areceber;
    // $retorno['comboboxes'] = $comboboxes;
    return $contas;

    return view('contas.lista')->with('contas', $contas)
                                ->with('deletados', $deletados)
                                ->with('total_debito', $total_debito)
                                ->with('total_credito', $total_credito)
                                ->with('total_apagar', $total_apagar)
                                ->with('total_areceber', $total_areceber)
                                ->with('comboboxes', $comboboxes);

  }

  public function detalhes($id){
    if (!isset(Auth::user()->perms["bancos"]["leitura"]) or Auth::user()->perms["bancos"]["leitura"]!=1){
      return response()->json([__('messages.perms.leitura')], 403);
    }
    $conta=Contas::with('contato', 'banco', 'attachs')->find($id);
    return $conta;
    // return view('contas.detalhes')->with('conta', $conta);

  }

  public function salva(request $request){
    if (!isset(Auth::user()->perms["contas"]["adicao"]) or Auth::user()->perms["contas"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    $this->validate($request, [
        'tipo' => 'required',
        'contatos_id' => 'required',
        'nome' => 'required|max:50',
        'valor' => 'required|numeric',
    ]);
    $conta = new Contas;
    $conta->contatos_id = $request->contatos_id;
    $conta->nome = $request->nome;
    $conta->valor = $request->valor;
    $date_temp = $request->vencimento;
    $conta->vencimento = $date_temp;
    $conta->descricao = $request->descricao;
    $conta->tipo = $request->tipo;
    $conta->dm = $request->dm;
    $conta->usuarios_id = Auth::user()->contato->id;
    $conta->estado = $request->estado;
    if (!$request->desconto){
      $conta->desconto = "0";
    } else {
      $conta->desconto = $request->desconto;
    }
    $conta->save();
    $conta->referente = $conta->id;
    if ($request->estado!="0" and $request->estado!="1"){
      $conta->estado="0";
    }
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
    // if ($request->parcelas>0){
    //   $conta->valor = $request->cheio - $request->valor_entrada;
    //   if ($request->valor_entrada<="0"){
    //     $conta->estado = "1";
    //   }
    //   $conta->save();
    //   $valor_restante = $request->cheio - $request->valor_entrada;
    //   $i = 0;
    //
    //   $parcela = $valor_restante/$request->parcelas;
    //   while ($i < $request->parcelas) {
    //     $i = $i + 1;
    //     $vencimentos[$i] = Carbon::today()->addMonths($i);
    //   }
    //   $contato = Contatos::find($request->contatos_id);
    //   #return $contato;
    //   return view('contas.parcelas')->with('contato', $contato)
    //                                 ->with('conta', $conta)
    //                                 ->with('vencimentos', $vencimentos)
    //                                 ->with('parcela', $parcela);
    // }
    return ;
  }

  public function editar($id){
    if (!isset(Auth::user()->perms["contas"]["edicao"]) or Auth::user()->perms["contas"]["edicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.edicao')]);
    }
    $conta = Contas::with('contato', 'attachs')->find($id);
    // $comboboxes = comboboxes::where('combobox_textable_type', 'App\Consumos')->get();
    // $comboboxes2 = comboboxes::where('combobox_textable_type', 'App\Contas\Formas')->get();
    // if ($conta->tipo==2){
    //   $is_consumos = 1;
    // } else {
    //   $is_consumos = 0;
    // }
    Log::info('Adicionar CONSUMOS passo 2, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return $conta;
    return view('contas.valores')->with('comboboxes', $comboboxes)
                                 ->with('conta', $conta)
                                 ->with('comboboxes2', $comboboxes2)
                                 ->with('is_consumos', $is_consumos);
  }

  public function atualiza($id, request $request){
    if (!isset(Auth::user()->perms["contas"]["adicao"]) or Auth::user()->perms["contas"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    $this->validate($request, [
        'tipo' => 'required',
        'contatos_id' => 'required',
        'nome' => 'required|max:50',
        'valor' => 'required|numeric',
    ]);
    $conta = Contas::find($id);
    $conta->nome = $request->nome;
    $conta->valor = $request->valor;
    $date_temp = $request->vencimento;
    $conta->vencimento = $date_temp;
    $conta->descricao = $request->descricao;
    $conta->tipo = $request->tipo;
    $conta->dm = $request->dm;
    $conta->usuarios_id = Auth::user()->contato->id;
    $conta->estado = $request->estado;
    if (!$request->desconto){
      $conta->desconto = "0";
    } else {
      $conta->desconto = $request->desconto;
    }
    $conta->save();
    $conta->referente = $conta->id;
    if ($request->estado!="0" and $request->estado!="1"){
      $conta->estado="0";
    }
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
    // if ($request->parcelas>0){
    //   $conta->valor = $request->cheio - $request->valor_entrada;
    //   if ($request->valor_entrada<="0"){
    //     $conta->estado = "1";
    //   }
    //   $conta->save();
    //   $valor_restante = $request->cheio - $request->valor_entrada;
    //   $i = 0;
    //
    //   $parcela = $valor_restante/$request->parcelas;
    //   while ($i < $request->parcelas) {
    //     $i = $i + 1;
    //     $vencimentos[$i] = Carbon::today()->addMonths($i);
    //   }
    //   $contato = Contatos::find($request->contatos_id);
    //   #return $contato;
    //   return view('contas.parcelas')->with('contato', $contato)
    //                                 ->with('conta', $conta)
    //                                 ->with('vencimentos', $vencimentos)
    //                                 ->with('parcela', $parcela);
    // }
    return ;
  }
  public function pago($id, request $request){
    if (!isset(Auth::user()->perms["contas"]["edicao"]) or Auth::user()->perms["contas"]["edicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.edicao')]);
    }
    $conta = Contas::find($id);
    $conta->bancos_id = $request->bancos_id;
    $conta->estado = '1';
    $banco = Bancos::find($request->bancos_id);
    $valor= 0;
    $parcela_nao_paga = FALSE;
    $parcela_paga = FALSE;
    foreach ($conta->parcelas as $key => $parcela) {
      if($parcela->estado=='0' ){
        $parcela_nao_paga = TRUE;
        $valor = $parcela->valor;
        $parcela->estado =='1';
        $parcela->save();
      } else {
        $parcela_paga = TRUE;
      }
    }
    if ($parcela_paga and $parcela_nao_paga) {
      if ($conta->tipo == "1"){
        $banco->valor = $banco->valor+$valor;
      } else {
        $banco->valor = $banco->valor-$valor;
      }
    } elseif ($parcela_paga and !$parcela_nao_paga) {
      # Todas as parcelas pagas, apenas validando
    } else {
      if ($conta->tipo == "1"){
        $banco->valor = $banco->valor+$request->valor;
      } else {
        $banco->valor = $banco->valor-$request->valor;
      }
    }

    $banco->save();
    $conta->save();
    return ;
  }
  public function delete($id){
    if (!isset(Auth::user()->perms["contas"]["edicao"]) or Auth::user()->perms["contas"]["edicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.edicao')]);
    }
    $conta = Contas::withTrashed()->find($id);

    if ($conta->trashed()) {
      Log::info('Restaurando conta -> "'.$conta.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $conta->restore();
    } else {
      Log::info('Deletando conta -> "'.$conta.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $conta->delete();
    }
    return ;
  }










  public function index(){
    Log::info('Vendo contas, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    if (!isset(Auth::user()->perms["contas"]["leitura"]) or Auth::user()->perms["contas"]["leitura"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.leitura')]);
    }
    $contas = Contas::paginate(15);
    $deletados = 0;
    $total_debito = Contas::where('tipo', '!=', '1')->where('estado', '1')->sum('valor');
    $total_credito = Contas::where('tipo', '1')->where('estado', '1')->sum('valor');
    $total_apagar = Contas::where('tipo', '!=', '1')->where('estado', '0')->sum('valor');
    $total_areceber = Contas::where('tipo', '1')->where('estado', '0')->sum('valor');
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Contas')->get();

    return view('contas.index')->with('contas', $contas)
                                ->with('deletados', $deletados)
                                ->with('total_debito', $total_debito)
                                ->with('total_credito', $total_credito)
                                ->with('total_apagar', $total_apagar)
                                ->with('total_areceber', $total_areceber)
                                ->with('comboboxes', $comboboxes);
  }

  public function attachs($id){
    $conta=Contas::find($id);
    $contato_id = $conta->contatos->id;
    return view('contas.attachs')->with('attachs', $conta->attachs)->with('conta_id', $id)->with('contato_id', $contato_id);

  }

  public function novo(){
    Log::info('Adicionando contas, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    if (!isset(Auth::user()->perms["contas"]["adicao"]) or Auth::user()->perms["contas"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    $contatos = Contatos::paginate(15);
    return view('contas.contatos')->with('contatos', $contatos);
  }
  public function consumos_novo(){
    Log::info('Adicionando consumo, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    if (!isset(Auth::user()->perms["contas"]["adicao"]) or Auth::user()->perms["contas"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    $contatos = Contatos::paginate(15);
    $is_consumos = 1;
    return view('contas.contatos')->with('contatos', $contatos)->with('is_consumos', $is_consumos);
  }

  public function pagar($id){
    if (!isset(Auth::user()->perms["contas"]["edicao"]) or Auth::user()->perms["contas"]["edicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.edicao')]);
    }
    $conta = Contas::find($id);
    return view('contas.pagar')->with('conta', $conta);
  }


  public function add_2(request $request){
    if (!isset(Auth::user()->perms["contas"]["adicao"]) or Auth::user()->perms["contas"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Contas')->get();
    $comboboxes2 = comboboxes::where('combobox_textable_type', 'App\Contas\Formas')->get();
    Log::info('Adicionar CONTA passo 2, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('contas.valores')->with('comboboxes', $comboboxes)->with('comboboxes2', $comboboxes2);
  }
  public function consumos_novo2(){
    if (!isset(Auth::user()->perms["contas"]["adicao"]) or Auth::user()->perms["contas"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Consumos')->get();
    $comboboxes2 = comboboxes::where('combobox_textable_type', 'App\Contas\Formas')->get();
    $is_consumos = 1;
    Log::info('Adicionar CONSUMOS passo 2, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('contas.valores')->with('comboboxes', $comboboxes)
                                 ->with('comboboxes2', $comboboxes2)
                                 ->with('is_consumos', $is_consumos);
  }


  // public function atualiza( $id, request $request){
  //   if (!isset(Auth::user()->perms["contas"]["edicao"]) or Auth::user()->perms["contas"]["edicao"]!=1){
  //     return redirect()->action('HomeController@index')
  //                      ->withErrors([__('messages.perms.edicao')]);
  //   }
  //   $this->validate($request, [
  //       'contatos_id' => 'required',
  //       'nome' => 'required|max:50',
  //       'cheio' => 'required|numeric',
  //   ]);
  //   $conta = Contas::find($id);
  //   $conta->contatos_id = $request->contatos_id;
  //   $conta->nome = $request->nome;
  //   $conta->valor = $request->cheio;
  //   $date_temp = date_create($request->vencimento);
  //   $conta->vencimento = $date_temp;
  //   $conta->descricao = $request->descricao;
  //   $conta->tipo = $request->tipo;
  //   $conta->dm = $request->dm;
  //   $conta->usuarios_id = Auth::user()->contato->id;
  //   $conta->estado = $request->estado;
  //   if (!$request->desconto){
  //     $conta->desconto = "0";
  //   } else {
  //     $conta->desconto = $request->desconto;
  //   }
  //   $conta->pagamento = $request->forma;
  //   $conta->save();
  //   $conta->referente = $conta->id;
  //   if ($request->estado!="0" and $request->estado!="1"){
  //     $conta->estado="0";
  //   }
  //   $conta->save();
  //   if ($request->tipo=="2"){
  //     foreach ($request->disc_text as $key => $text) {
  //       $disc = new Discs;
  //       $disc->contas_id = $conta->id;
  //       $disc->nome = $request->disc_text[$key];
  //       $disc->valor = $request->disc_valor[$key];
  //       $disc->save();
  //     }
  //     foreach ($request->disc_text_edit as $key2 => $text2) {
  //       $disc = new Discs;
  //       $disc->contas_id = $conta->id;
  //       $disc->nome = $request->disc_text_edit[$key2];
  //       $disc->valor = $request->disc_valor_edit[$key2];
  //       $disc->save();
  //     }
  //   }
  //   Log::info('Adicionar CONTA passo 3, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
  //   if ($request->parcelas>0){
  //     $conta->valor = $request->cheio - $request->valor_entrada;
  //     if ($request->valor_entrada<="0"){
  //       $conta->estado = "1";
  //     }
  //     $conta->save();
  //     $valor_restante = $request->cheio - $request->valor_entrada;
  //     $i = 0;
  //
  //     $parcela = $valor_restante/$request->parcelas;
  //     while ($i < $request->parcelas) {
  //       $i = $i + 1;
  //       $vencimentos[$i] = Carbon::today()->addMonths($i);
  //     }
  //     $contato = Contatos::find($request->contatos_id);
  //     #return $contato;
  //     return view('contas.parcelas')->with('contato', $contato)
  //                                   ->with('conta', $conta)
  //                                   ->with('vencimentos', $vencimentos)
  //                                   ->with('parcela', $parcela);
  //   }
  //   return redirect()->action('ContasController@index');
  // }

  public function consumos_novo3(request $request){
    if (!isset(Auth::user()->perms["contas"]["adicao"]) or Auth::user()->perms["contas"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    $this->validate($request, [
        'contatos_id' => 'required',
        'nome' => 'required|max:50',
        'valor' => 'required|numeric',
    ]);
    $contato = Contatos::find($request->contatos_id);
    $conta = new Contas;
    $conta->contatos_id = $contato->id;
    $conta->usuarios_id = Auth::user()->contato->id;
    $conta->nome = $request->nome;
    $conta->valor = $request->cheio;
    $date_temp = $request->vencimento;
    $conta->vencimento = $date_temp;
    $conta->descricao = $request->descricao;
    $conta->tipo = "2";
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
    if ($request->estado!="0" and $request->estado!="1"){
      $conta->estado="0";
    }
    $conta->save();
    $consumo = new Consumos;
    $consumo->contas_id = $conta->id;
    $consumo->mes = $request->mes;
    $consumo->codigo = $request->codigo;
    $consumo->consumo = $request->consumo;
    $consumo->cat = $request->cat;
    $consumo->valor_anterior = $request->valor_anterior;
    $consumo->valor_atual = $request->valor_atual;
    $consumo->sub_item1 = $request->sub_item1;
    $consumo->sub_item2 = $request->sub_item2;
    $consumo->save();
    foreach ($request->disc_text as $key => $text) {
      $disc = new Discs;
      $disc->contas_id = $conta->id;
      $disc->nome = $request->disc_text[$key];
      $disc->valor = $request->disc_valor[$key];
      $disc->save();
    }
    Log::info('Adicionar CONSUMO passo 3, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    if ($request->parcelas>0){
      $conta->valor = $request->cheio - $request->valor_entrada;
      if ($request->valor_entrada<="0"){
        $conta->estado = "1";
      }
      $conta->save();
      $valor_restante = $request->cheio - $request->valor_entrada;
      $i = 0;

      $parcela = $valor_restante/$request->parcelas;
      while ($i < $request->parcelas) {
        $i = $i + 1;
        $vencimentos[$i] = Carbon::today()->addMonths($i);
      }
      return view('contas.parcelas')->with('contato', $contato)->with('conta', $conta)->with('vencimentos', $vencimentos)->with('parcela', $parcela);
    }
    return redirect()->action('ContasController@index');
  }


  public function add_4(request $request, $conta_id){
    if (!isset(Auth::user()->perms["contas"]["adicao"]) or Auth::user()->perms["contas"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    $conta= Contas::find($conta_id);
    $conta->valor = "0";
    $conta->save();
    foreach ($request->parcela as $key => $parcela) {
      $parcela1 = new Contas;
      $parcela1->contatos_id = $conta->contatos_id;
      $parcela1->nome = $conta->nome." ".$key." de ".sizeof($request->parcela);
      $parcela1->valor = $parcela;
      $parcela1->vencimento = $request->vencimento[$key];
      $parcela1->descricao = "";
      $parcela1->usuarios_id = Auth::user()->contato->id;
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
