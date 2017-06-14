<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Produtos as Produtos;
use App\Semelhantes_externos as Externos;
use App\Estoque_campos as Campos;

use Log;
use Auth;

class ProdutosController extends Controller
{

  public function busca(request $request)
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
    $produtos = $produtos->with('tipo.grupo', 'armazenagens');
    $produtos = $produtos->orderBy('nome', 'asc')->paginate(15);

    if (isset($externos)){
      foreach ($externos as $key => $externo) {
        $produtos->push($externo->produto);
      }
    }
    return $produtos;
    return view('estoque.produto.lista')
                ->with('produtos', $produtos);
  }

  public function delete($id)
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
    return ;
  }

  public function editar($id)
  {
    if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.edicao')]);
    }
    Log::info('Criando novo produto, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $produto = produtos::with('semelhantes_from', 'semelhantes_to', 'armazenagens', 'campos', 'estoques', 'externos', 'fabricante', 'tipo')->find($id);

    return $produto;
  }

  public function salva(request $request)
  {
    if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.adicao')]);
    }
    Log::info('Salvando novo produto, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    $this->validate($request, [
        'fabricante_id' => 'required',
    ]);


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
    $produto->produtos_tipo_id = $request->produtos_tipo_id;
    $produto->nome = $request->nome;
    $produto->unidade = $request->unidade;
    $produto->embalagem = $request->embalagem;
    $produto->fabricante_id = $request->fabricante_id;
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

    $produto->semelhantes_to()->detach();
    if($request->semelhantes_to){

      foreach ($request->semelhantes_to as $key => $semelhante) {

        if (isset($semelhante['produtos_id'])){
          $produto->semelhantes_to()->attach($semelhante['produtos_id']);
        }

      }
    }

    if(isset($request->externos)){
      foreach ($request->externos as $key => $ext) {

        if (isset($ext['id'])) {
          $externo = Externos::find($ext['id']);
        } else {
          $externo = new Externos;
          $externo->produtos_id = $produto->id;
        }

        $externo->codigo = $ext['codigo'];
        $externo->nome = $ext['nome'];
        $externo->origem = $ext['origem'];
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

    return $produto;
  }

  public function atualizar($id, request $request)
  {
    Log::info('Atualizando novo produto, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
      return redirect()->action('HomeController@index')
                       ->withErrors([__('messages.perms.edicao')]);
    }

    $this->validate($request, [
        'fabricante_id' => 'required',
    ]);

    $produto = Produtos::find($id);

    $produto->barras = $request->barras;
    $produto->produtos_tipo_id = $request->produtos_tipo_id;
    $produto->nome = $request->nome;
    $produto->unidade = $request->unidade;
    $produto->embalagem = $request->embalagem;
    $produto->fabricante_id = $request->fabricante_id;
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

    $produto->semelhantes_to()->detach();
    if($request->semelhantes_to){

      foreach ($request->semelhantes_to as $key => $semelhante) {

        if (isset($semelhante['produtos_id'])){
          $produto->semelhantes_to()->attach($semelhante['produtos_id']);
        }

      }
    }

    if(isset($request->externos)){
      foreach ($request->externos as $key => $ext) {

        if (isset($ext['id'])) {
          $externo = Externos::find($ext['id']);
        } else {
          $externo = new Externos;
          $externo->produtos_id = $produto->id;
        }

        $externo->codigo = $ext['codigo'];
        $externo->nome = $ext['nome'];
        $externo->origem = $ext['origem'];
        $externo->save();
      }
    }
    if(isset($request->campos)){
      foreach ($request->campos as $key => $c) {

        if (array_key_exists('id', $c)) {
          $campo = Campos::find($c['id']);
        } else {
          $campo = new Campos;
          $campo->estoque_id = $produto->id;
        }

        $campo->tipo = "0";
        $campo->nome = $c['nome'];
        $campo->valor = $c['valor'];
        $campo->save();
      }
    }

    return $produto;
  }

  public function externo_delete($id, $id_externo){
    $externo = Externos::find($id_externo);

    $externo->delete();

    return;
  }

  public function campo_delete($id, $id_campo){
    $campo = Campos::find($id_campo);

    $campo->delete();

    return;
  }

}
