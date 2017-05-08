<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contatos as Contatos;
use App\Estoque as Estoque;
use Carbon\Carbon;
use App\Estoque_campos as Campos;
use App\Nf_entradas as nf_entradas;
use App\Nf_produtos as nf_produtos;
use App\Produtos as Produtos;
use App\Produtos_grupos as Grupos;
use App\Produtos_tipos as Tipos;
use App\Semelhantes_externos as Externos;
use App\Combobox_texts as Comboboxes;
use Log;
use Auth;
class EstoqueController  extends BaseController
{
  public function __construct(){
     parent::__construct();
  }

  public function index()
  {
    Log::info('Vendo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.leitura')]);
    }
    $estoques = Estoque::paginate(30);
    $total= Estoque::count();
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Estoque::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    return view('estoque.index')->with('estoques', $estoques)->with('deletados', $deletados)->with('total', $total);
  }

  public function novo()
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    $contatos = Contatos::paginate(15);
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.novo')->with('contatos', $contatos);
  }

  public function nf_entrada_lista()
  {
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.leitura')]);
    }
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.nf.index');
  }
  public function nf_entrada_busca(request $request)
  {
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.leitura')]);
    }
    $nfs = nf_entradas::all();

    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.nf.lista')->with('nfs', $nfs);
  }
  public function nf_entrada()
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.nf.entrada');
  }
  public function nf_entrada_editar($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    $nf = nf_entradas::find($id);
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.nf.entrada')->with('nf', $nf);
  }
  public function nf_entrada_salva(request $request )
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    $nf = new nf_entradas;
    $nf->filiais_id = $request->filiais_id;
    $nf->fornecedor_id = $request->contatos_id;
    $nf->numero = $request->numero_nota;
    $nf->total = $request->total_nota;
    $nf->frete = $request->frete_nota;
    $nf->transportadora = $request->transportadora;
    $nf->seguro = $request->seguro;
    $nf->icms = $request->icms_substituicao;
    $nf->acrescimo = $request->acrescimo;
    $nf->desconto = $request->desconto;
    $nf->obs = $request->obs;
    $nf->criado_por = Auth::user()->contato->id;
    $nf->save();
    foreach ($request->nota_produto_id as $key => $produto_id) {
      $nfp = new nf_produtos;
      $nfp->notas_id = $nf->id;
      $nfp->produtos_id = $request->nota_produto_id[$key];
      $nfp->ncm = $request->ncmNota[$key];
      $nfp->quantidade = $request->qtdNota[$key];
      $nfp->tipo = $request->tipoNota[$key];
      $nfp->valor = $request->valorUniNota[$key];
      $nfp->icms = $request->IcmsUniNota[$key];
      $nfp->ipi = $request->IpiUniNota[$key];
      $nfp->total_icms = $request->IcmsTotalNota[$key];
      $nfp->total_ipi = $request->IpiTotalNota[$key];
      $nfp->total = $request->valorTotalNota[$key];
      $nfp->save();

      $estoque = $nf->filial->estoque->where('produtos_id', $nfp->produto->id)->first();
      if (is_null($estoque)){
        $estoque = new Estoque;
        $estoque->contatos_id = $nf->filial->id;
        $estoque->produtos_id = $nfp->id;
      }
      $estoque->quantidade = $estoque->quantidade+$nfp->quantidade;
      $estoque->save();

    }

    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.nf.index');
  }
  public function nf_entrada_atualiza($id, request $request )
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    $nf = nf_entradas::find($id);
    $nf->filiais_id = $request->filiais_id;
    $nf->fornecedor_id = $request->contatos_id;
    $nf->numero = $request->numero_nota;
    $nf->total = $request->total_nota;
    $nf->frete = $request->frete_nota;
    $nf->transportadora = $request->transportadora;
    $nf->seguro = $request->seguro;
    $nf->icms = $request->icms_substituicao;
    $nf->acrescimo = $request->acrescimo;
    $nf->desconto = $request->desconto;
    $nf->obs = $request->obs;
    $nf->criado_por = Auth::user()->contato->id;
    $nf->save();
    foreach ($request->nota_produto_id as $key => $produto_id) {
      $nfp = new nf_produtos;
      $nfp->notas_id = $nf->id;
      $nfp->produtos_id = $request->nota_produto_id[$key];
      $nfp->ncm = $request->ncmNota[$key];
      $nfp->quantidade = $request->qtdNota[$key];
      $nfp->tipo = $request->tipoNota[$key];
      $nfp->valor = $request->valorUniNota[$key];
      $nfp->icms = $request->IcmsUniNota[$key];
      $nfp->ipi = $request->IpiUniNota[$key];
      $nfp->total_icms = $request->IcmsTotalNota[$key];
      $nfp->total_ipi = $request->IpiTotalNota[$key];
      $nfp->total = $request->valorTotalNota[$key];
      $nfp->save();

      $estoque = $nf->filial->estoque->where('produtos_id', $nfp->produto->id)->first();
      if (is_null($estoque)){
        $estoque = new Estoque;
        $estoque->contatos_id = $nf->filial->id;
        $estoque->produtos_id = $nfp->id;
      }
      $estoque->quantidade = $estoque->quantidade+$nfp->quantidade;
      $estoque->save();

    }

    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.nf.index');
  }
  public function detalhes($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return response()->json([__('messages.perms.leitura')], 403);
    }
    $estoque = estoque::Find($id);
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.detalhes')->with('estoque', $estoque);
  }

  public function grupo_selecionar()
  {
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return response()->json([__('messages.perms.leitura')], 403);
    }
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.grupos.selecionar');
  }
  public function tipo_selecionar()
  {
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return response()->json([__('messages.perms.leitura')], 403);
    }
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.tipos.selecionar');
  }
  public function grupo_busca(request $request)
  {
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return response()->json([__('messages.perms.leitura')], 403);
    }
    $grupos = Grupos::all();
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.grupos.lista')->with('grupos', $grupos);
  }
  public function tipo_busca(request $request)
  {
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return response()->json([__('messages.perms.leitura')], 403);
    }
    if ($request->id!=""){
      $tipos = Tipos::where('produtos_grupos_id', 'like', $request->id)->get();
      if (!count($tipos)){
        $erro = "Nenhum tipo encontrado";
        return view('estoque.tipos.lista')->with('tipos', $tipos)->with('erro', $erro);

      }
    } else {
      $tipos = Tipos::all();
    }
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.tipos.lista')->with('tipos', $tipos);
  }
  public function grupo_novo()
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return response()->json([__('messages.perms.adicao')], 403);
    }
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.grupos.novo');
  }
  public function grupo_edit($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
      return response()->json([__('messages.perms.edicao')], 403);
    }
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $grupo = Grupos::find($id);
    return view('estoque.grupos.novo')->with('grupo', $grupo);
  }
  public function tipo_novo($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return response()->json([__('messages.perms.adicao')], 403);
    }
    $grupo = Grupos::find($id);
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.tipos.novo')->with("grupo", $grupo);
  }
  public function tipo_editar($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return response()->json([__('messages.perms.adicao')], 403);
    }
    $tipo = Tipos::find($id);
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.tipos.novo')->with("tipo", $tipo);
  }
  public function grupo_salva(request $request)
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
  public function tipo_salva(request $request)
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return response()->json([__('messages.perms.adicao')], 403);
    }
    if ($request->tipos_id!=""){
      $tipo = tipos::find($request->tipos_id);

    } else {
      $tipo = new tipos;
    }
    $tipo->produtos_grupos_id = $request->grupos_id;
    $tipo->nome = $request->nome;
    $tipo->save();
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return response()->json([__('messages.adicao.sucesso')], 201);
  }

  public function save(request $request)
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    $this->validate($request, [
        'filiais_id' => 'required',
        'produtos_id' => 'required',
        'quantidade' => 'required',
    ]);
    $estoque = new Estoque;
    $estoque->contatos_id = $request->filiais_id;
    $estoque->produtos_id = $request->produtos_id;
    $estoque->quantidade = $request->quantidade;
    $estoque->save();
    Log::info('Salvando estoque -> "'.$estoque.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return redirect()->action('EstoqueController@index');
  }

  public function edit($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.edicao')]);
    }
    $estoque = Estoque::find($id);

    Log::info('Editar estoque -> "'.$estoque.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return view('estoque.novo')->with('estoque', $estoque);
  }
  public function edit_save(request $request, $id)
  {
    if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.edicao')]);
    }
    $this->validate($request, [
        'filiais_id' => 'required',
        'produtos_id' => 'required',
        'quantidade' => 'required',
    ]);
    $estoque = Estoque::find($id);
    $estoque->contatos_id = $request->filiais_id;
    $estoque->produtos_id = $request->produtos_id;
    $estoque->quantidade = $request->quantidade;

    $estoque->save();
    Log::info('Salvando estoque -> "'.$estoque.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return redirect()->action('EstoqueController@index');
  }

  public function search( Request $request)
  {
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.leitura')]);
    }
    $estoques = Estoque::query();
    if ($request->estocado){
      $estoques = $estoques->orWhere('quantidade', '>', '0');
    }
    if ($request->falta){
      $estoques = $estoques->orWhere('quantidade', '<=', '0');
    }
    if (!empty($request->valor)){
      $estoques = $estoques->orWhere('valor_custo', '>', $request->valor);
    }
    if (!empty($request->codigo)){
      $estoques = $estoques->orWhere('barras', $request->codigo);
    }
    if (!empty($request->nome)){
      $estoques = $estoques->orWhere('nome', 'like', '%' . $request->nome . '%');
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
          $estoques = $estoques->orWhere('contatos_id', '=', $contatos[$a]->id);
          $a++;
        }
    }
    $estoques = $estoques->paginate(30);
    Log::info('Vendo estoque com busca -> "'.$request.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $total= Estoque::count();
    $deletados = 0;
    return view('estoque.lista')
      ->with('estoques', $estoques)
      ->with('total', $total)
      ->with('deletados', $deletados);
  }

  public function delete($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.edicao')]);
    }
    $estoque = Estoque::withTrashed()->find($id);
    if ($estoque->trashed()){
      Log::info('Restaurando estoque -> "'.$estoque.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $estoque->restore();
    }else{
      Log::info('Deletando estoque -> "'.$estoque.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $estoque->delete();
    }
    return redirect()->action('EstoqueController@index');
  }

  public function produto_campos_delete($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.edicao')]);
    }
    $campo = Campos::withTrashed()->find($id);
    if ($campo->trashed()){
      $campo->restore();
    }else{
      $campo->delete();
    }
  }
  public function produto_delete($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.edicao')]);
    }
    $produto = Produtos::withTrashed()->find($id);
    if ($produto->trashed()){
      $produto->restore();
    }else{
      $produto->delete();
    }
    return redirect()->action('EstoqueController@produto_index');
  }
  public function produto_externos_delete($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.edicao')]);
    }
    $campo = Campos::find($id);
    $campo->delete();
  }

  public function produto_novo()
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Produtos\Medidas')->get();
    $embalagens = comboboxes::where('combobox_textable_type', 'App\Produtos\Embalagens')->get();

    Log::info('Criando novo produto, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.produto.novo')
      ->with('embalagens', $embalagens)
      ->with('medidas', $comboboxes);
  }
  public function produto_editar($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.edicao')]);
    }
    Log::info('Criando novo produto, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $produto = produtos::find($id);
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Produtos\Medidas')->get();
    $embalagens = comboboxes::where('combobox_textable_type', 'App\Produtos\Embalagens')->get();
    return view('estoque.produto.novo')
      ->with('medidas', $comboboxes)
      ->with('embalagens', $embalagens)
      ->with('produto', $produto);
  }
  public function produto_salva(request $request)
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    Log::info('Salvando novo produto, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $produto = new Produtos;
    if (Produtos::where('barras', $request->barras)->first()){
      return redirect()->back();
    }
    if ($request->barras=="" or !isset($request->barras)){
      $i = 0;
      while ($i < 1) {
        $barras = rand(10000000, 99999999);
        $produto_achado = Produtos::where('barras', $barras)->first();
        if ($produto_achado==""){
          $i++;
        }
      }
    } else {
      $barras = $request->barras;
    }
    $produto->barras = $barras;
    $produto->produtos_tipo_id = $request->produtos_grupos_id;
    $produto->nome = $request->nome;
    $produto->unidade = $request->unidade;
    $produto->embalagem = $request->embalagem;
    $produto->fabricante_id = $request->contatos_id;
    $produto->custo = $request->custo;
    $produto->margem = $request->margem;
    $produto->venda = $request->venda;
    $produto->qtd_minima = $request->minimo;
    $produto->qtd_maxima = $request->maximo;
    $produto->estado = $request->estado;
    // $produto->ncm = $request->ncm;
    $produto->peso = $request->peso;
    $produto->aplicacao = $request->aplicacao;
    $produto->estado = $request->estado;
    $produto->save();
    if(isset($request->armazenagem)){
      $data = [
        $produto->id =>
        [
          'filiais_id' => Auth::user()->trabalho_id,
          'local' => $request->armazenagem,
        ]
      ];
      $produto->armazenagens()->sync($data, true);
    }
    if($request->semelhante_id){
      foreach ($request->semelhante_id as $key => $semelhante) {
        $produto->semelhantes_to()->sync([$semelhante]);
      }
    }
    if(isset($request->codigoExterno)){
      foreach ($request->codigoExterno as $key => $cod_externo) {
        $externo = new Externos;
        $externo->produtos_id = $produto->id;
        $externo->codigo = $request->codigoExterno[$key];
        $externo->nome = $request->nomeExterno[$key];
        $externo->origem = $request->origemExterno[$key];
        $externo->save();
      }
    }
    if(isset($request->campo_nome_edit)){
      foreach ($request->campo_nome_edit as $key => $value) {
        $campo = Campos::find($request->campo_id_edit[$key]);
        $campo->tipo = $request->tipo;
        $campo->nome = $request->campo_nome_edit[$key];
        $campo->valor = $request->campo_valor_edit[$key];
        $campo->save();
      }
    }
    if(isset($request->campo_nome)){
      foreach ($request->campo_nome as $key => $value) {
        $campo = new Campos;
        $campo->estoque_id = $produto->id;
        $campo->tipo = $request->tipo;
        $campo->nome = $request->campo_nome[$key];
        $campo->valor = $request->campo_valor[$key];
        $campo->save();
      }
    }

    return redirect()->action('EstoqueController@produto_index');
  }
  public function produto_atualiza($id, request $request)
  {
    Log::info('Atualizando novo produto, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.edicao')]);
    }
    $produto = Produtos::find($id);
    if (Produtos::where('barras', $request->barras)->first() and $produto->barras!=$request->barras){
      return redirect()->back();
    }
    if ($request->barras=="" or !isset($request->barras)){
      $i = 0;
      while ($i < 1) {
        $barras = rand(10000000, 99999999);
        $produto_achado = Produtos::where('barras', $barras)->first();
        if ($produto_achado==""){
          $i++;
        }
      }
    } else {
      $barras = $request->barras;
    }
    $produto->barras = $barras;
    $produto->produtos_tipo_id = $request->produtos_grupos_id;
    $produto->nome = $request->nome;
    $produto->unidade = $request->unidade;
    $produto->embalagem = $request->embalagem;
    $produto->fabricante_id = $request->contatos_id;
    $produto->custo = $request->custo;
    $produto->margem = $request->margem;
    $produto->venda = $request->venda;
    $produto->qtd_minima = $request->minimo;
    $produto->qtd_maxima = $request->maximo;
    $produto->estado = $request->estado;
    // $produto->ncm = $request->ncm;
    $produto->peso = $request->peso;
    $produto->aplicacao = $request->aplicacao;
    $produto->save();
    if(isset($request->armazenagem)){
      $data = [
        $produto->id =>
        [
          'filiais_id' => Auth::user()->trabalho_id,
          'local' => $request->armazenagem,
        ]
      ];
      $produto->armazenagens()->sync($data, true);
    }
    if($request->semelhante_id){
      foreach ($request->semelhante_id as $key => $semelhante) {
        $produto->semelhantes_to()->sync([$semelhante]);
      }
    }
    if($request->semelhante_id_from){
      foreach ($request->semelhante_id_from as $key => $semelhante) {
        $produto->semelhantes_from()->sync([$semelhante]);
      }
    }
    if($request->semelhante_id_to){
      foreach ($request->semelhante_id_to as $key => $semelhante) {
        $produto->semelhantes_to()->sync([$semelhante]);
      }
    }
    if(isset($request->codigoExterno)){
      foreach ($request->codigoExterno as $key => $cod_externo) {
        $externo = new Externos;
        $externo->produtos_id = $produto->id;
        $externo->codigo = $request->codigoExterno[$key];
        $externo->nome = $request->nomeExterno[$key];
        $externo->origem = $request->origemExterno[$key];
        $externo->save();
      }
    }
    if(isset($request->codigoExterno)){
      foreach ($request->codigoExterno as $key => $cod_externo) {
        $externo = new Externos;
        $externo->produtos_id = $produto->id;
        $externo->codigo = $request->codigoExterno[$key];
        $externo->nome = $request->nomeExterno[$key];
        $externo->origem = $request->origemExterno[$key];
        $externo->save();
      }
    }
    if(isset($request->campo_nome_edit)){
      foreach ($request->campo_nome_edit as $key => $value) {
        $campo = Campos::find($request->campo_id_edit[$key]);
        $campo->tipo = "0";
        $campo->nome = $request->campo_nome_edit[$key];
        $campo->valor = $request->campo_valor_edit[$key];
        $campo->save();
      }
    }
    if(isset($request->campo_nome)){
      foreach ($request->campo_nome as $key => $value) {
        $campo = new Campos;
        $campo->estoque_id = $produto->id;
        $campo->tipo = "0";
        $campo->nome = $request->campo_nome[$key];
        $campo->valor = $request->campo_valor[$key];
        $campo->save();
      }
    }

    return redirect()->action('EstoqueController@produto_index');
  }
  public function produto_selecionar()
  {
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.leitura')]);
    }
    Log::info('Selecionar produto, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $produtos = Produtos::OrderBy('barras', 'asc')->paginate(15);
    return view('estoque.produto.selecionar')->with('produtos', $produtos);
  }

  public function produto_index()
  {
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.leitura')]);
    }
    Log::info('produto index, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.produto.index');
  }
  public function produto_detalhes($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.leitura')]);
    }
    Log::info('produto index, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $produto = Produtos::Find($id);
    return view('estoque.produto.detalhes')
      ->with('produto', $produto);
  }
  public function produto_busca(request $request)
  {
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.leitura')]);
    }
    Log::info('Busca de modal produto, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $produtos = Produtos::query();
    if (!empty($request->busca)){
      $produtos = $produtos->orWhere('nome', 'like', '%' .  $request->busca . '%');
      $produtos = $produtos->orWhere('barras', 'like', '%' .  $request->busca . '%');
      $produtos = $produtos->orWhere('id', 'like', '%' .  $request->busca . '%');
    }
    if(!empty($request->aplicacaoBusca)){
      $produtos = $produtos->orWhere('aplicacao', 'like', '%' .  $request->aplicacaoBusca . '%');
    }
    if(!empty($request->subgrupoBusca)){
      $a = $request->subgrupoBusca;
      $produtos = $produtos->orWhere('produtos_tipo_id', $request->subgrupoBusca);
    }
    if(!empty($request->codigoBusca)){
      $produtos = $produtos->orWhere('barras', $request->codigoBusca);
      $produtos = $produtos->orWhere('nome', $request->codigoBusca);
      $externos = Externos::where('codigo', $request->codigoBusca)->get();
    }
    if(!empty($request->fabricanteBusca)){

      $contatos = Contatos::where('nome', 'like', '%' .  $request->fabricanteBusca . '%')
                            ->orWhere('sobrenome', 'like', '%' .  $request->fabricanteBusca . '%')
                            ->orWhere('endereco', 'like', '%' .  $request->fabricanteBusca . '%')
                            ->orWhere('cpf', 'like', '%' .  $request->fabricanteBusca . '%')
                            ->orWhere('cidade', 'like', '%' .  $request->fabricanteBusca . '%')
                            ->orWhere('uf', 'like', '%' .  $request->fabricanteBusca . '%')
                            ->orWhere('bairro', 'like', '%' .  $request->fabricanteBusca . '%')
                            ->orWhere('cep', 'like', '%' .  $request->fabricanteBusca . '%')
                            ->get();
        $a = 0;
        while ($a < count($contatos)) {
          $produtos = $produtos->orWhere('fabricante_id', '=', $contatos[$a]->id);
          $a++;
        }
    }
    $produtos = $produtos->orderBy('nome', 'asc')->get();

    if (isset($externos)){
      foreach ($externos as $key => $externo) {
        $produtos->push($externo->produto);
      }
    }
    #return $produtos;
    return view('estoque.produto.lista')
                ->with('produtos', $produtos);
  }

  public function produto_selecionar_novo()
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    Log::info('Modal novo produto, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Produtos\Medidas')->get();
    $embalagens = comboboxes::where('combobox_textable_type', 'App\Produtos\Embalagens')->get();
    return view('estoque.produto.parte_novo')
      ->with('embalagens', $embalagens)
      ->with('medidas', $comboboxes);
  }
  public function produto_selecionar_salvar(request $request)
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    Log::info('Modal novo produto, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    Log::info('Salvando novo produto, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $produto = new Produtos;
    if (Produtos::where('barras', $request->barras)->first()){
      return redirect()->back();
    }
    if ($request->barras=="" or !isset($request->barras)){
      $i = 0;
      while ($i < 1) {
        $barras = rand(10000000, 99999999);
        $produto_achado = Produtos::where('barras', $barras)->first();
        if ($produto_achado==""){
          $i++;
        }
      }
    } else {
      $barras = $request->barras;
    }
    $produto->barras = $barras;
    $produto->grupo = $request->grupo;
    $produto->tipo = $request->tipo;
    $produto->nome = $request->nome;
    $produto->unidade = $request->unidade;
    $produto->custo = $request->custo;
    $produto->save();
    if(isset($request->campo_nome_edit)){
      foreach ($request->campo_nome_edit as $key => $value) {
        $campo = Campos::find($request->campo_id_edit[$key]);
        $campo->tipo = $request->tipo;
        $campo->nome = $request->campo_nome_edit[$key];
        $campo->valor = $request->campo_valor_edit[$key];
        $campo->save();
      }
    }
    if(isset($request->campo_nome)){
      foreach ($request->campo_nome as $key => $value) {
        $campo = new Campos;
        $campo->estoque_id = $produto->id;
        $campo->tipo = $request->tipo;
        $campo->nome = $request->campo_nome[$key];
        $campo->valor = $request->campo_valor[$key];
        $campo->save();
      }
    }

  }
  public function gerar_barras()
  {
    if (!isset(Auth::user()->perms["estoques"]["leitura"]) or Auth::user()->perms["estoques"]["leitura"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.leitura')]);
    }
    Log::info('gerar codigo de barras, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $i=0;
    while ($i < 1) {
      $barras = rand(10000000, 99999999);
      $produto = Produtos::where('barras', $barras)->first();
      if ($produto==""){
        $i++;
      }
    }
    return $barras;
  }
}
