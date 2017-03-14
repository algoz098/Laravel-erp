<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contatos as Contatos;
use App\Estoque as Estoque;
use Carbon\Carbon;
use App\Estoque_campos as Campos;
use App\Produtos as Produtos;
use App\Produtos_grupos as Grupos;
use App\Produtos_tipos as Tipos;
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
  public function tipo_novo($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return response()->json([__('messages.perms.adicao')], 403);
    }
    $grupo = Grupos::find($id);
    Log::info('Criando novo estoque, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.tipos.novo')->with("grupo", $grupo);
  }
  public function grupo_salva(request $request)
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return response()->json([__('messages.perms.adicao')], 403);
    }
    $grupo = new Grupos;
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
    $tipo = new tipos;
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


  public function produto_novo()
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    Log::info('Criando novo produto, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('estoque.produto.novo');
  }
  public function produto_editar($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.edicao')]);
    }
    Log::info('Criando novo produto, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $produto = produtos::find($id);
    return view('estoque.produto.novo')->with('produto', $produto);
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
    $produto->qtd_minima = $request->qtd_minima;
    $produto->qtd_maxima = $request->qtd_maxima;
    $produto->estado = $request->estado;
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

    return redirect()->action('EstoqueController@index');
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

    return redirect()->action('EstoqueController@index');
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

    $produtos = $produtos->orderBy('nome', 'asc')->get();
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
    return view('estoque.produto.parte_novo');
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
