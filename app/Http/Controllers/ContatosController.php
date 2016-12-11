<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use DB;
use Auth;
use App\Contatos as Contatos;
use App\Telefones as Telefones;

class ContatosController extends Controller
{
  public function show()
  {
    $contatos = contatos::all();
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Contatos::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    return view('contatos.list')->with('contatos', $contatos)->with('deletados', $deletados);
  }

  public function search( Request $request)
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
                            ->get();
    } else {
      $contatos = Contatos::all();
    }
    return view('contatos.list')->with('contatos', $contatos);
  }

  public function showNovo()
  {
    return view('contatos.new');
  }

  public function novo( Request $request )
  {
    $contato = new Contatos;
    $contato->nome = $request->nome;
    $contato->cpf = $request->cnpj;
    $contato->rg = $request->ie;
    $contato->sobrenome = $request->sobrenome;
    $contato->endereco = $request->endereco;
    $contato->andar = $request->andar;
    $contato->sala = $request->sala;
    $contato->bairro = $request->bairro;
    $contato->uf = $request->uf;
    $contato->cidade = $request->cidade;
    $contato->cep = $request->cep;
    $contato->sociabilidade = $request->sociabilidade;
    $contato->tipo = $request->tipo;
    if ($request->active=="1"){
        $contato->active = "4";
    }
    $contato->save();
    if ($request->relacao=="0"){
      $data = [
        $contato->id =>
        [
          'from_text' => "Fornecedor",
          'to_id' => 1,
          'to_text' => "Cliente"
        ]
      ];

      $contato->from()->sync($data, false);
    }
    if ($request->relacao=="1"){
      $data = [
        $request->from_id =>
        [
          'from_text' => "Cliente",
          'to_id' => 1,
          'to_text' => "Fornecedor"
        ]
      ];

      $contato->from()->sync($data, false);
    }
    if ($request->relacao=="2"){
      $data = [
        $request->from_id =>
        [
          'from_text' => "Filial",
          'to_id' => 1,
          'to_text' => "Matriz"
        ]
      ];

      $contato->from()->sync($data, false);
    }
    $contatos = Contatos::all();
    return view('contatos.list')->with('contatos', $contatos);
  }
  public function showId( $id )
  {
    $contato = contatos::find($id);
    return view('contatos.new')->with('contato', $contato);
  }

  public function update( Request $request, $id )
  {
    $contato = contatos::find($id);
    $contato->nome = $request->nome;
    $contato->cpf = $request->cpf;
    $contato->rg = $request->rg;
    $contato->sobrenome = $request->sobrenome;
    $contato->endereco = $request->endereco;
    $contato->andar = $request->andar;
    $contato->sala = $request->sala;
    $contato->bairro = $request->bairro;
    $contato->uf = $request->uf;
    $contato->cidade = $request->cidade;
    $contato->cep = $request->cep;
    $contato->sociabilidade = $request->sociabilidade;
    $contato->tipo = $request->tipo;
    if ($request->active=="1"){
        $contato->active = "4";
    }
    $contato->save();
    if ($request->relacao=="0"){
      $data = [
        $contato->id =>
        [
          'from_text' => "Cliente",
          'to_id' => 1,
          'to_text' => "Fornecedor"
        ]
      ];

      $contato->from()->sync($data, false);
    }
    if ($request->relacao=="1"){
      $data = [
        $request->from_id =>
        [
          'from_text' => "Fornecedor",
          'to_id' => 1,
          'to_text' => "Cliente"
        ]
      ];

      $contato->from()->sync($data, false);
    }
    if ($request->relacao=="2"){
      $data = [
        $request->from_id =>
        [
          'from_text' => "Filial",
          'to_id' => 1,
          'to_text' => "Matriz"
        ]
      ];

      $contato->from()->sync($data, false);
    }

    $contato->save();
    $contatos = contatos::all();
    return view('contatos.list')->with('contatos', $contatos);
  }

  public function telefones_get( $id, $id_telefone )
  {
    $telefone = Telefones::find($id_telefone);
    return view('contatos.phone')->with('telefone', $telefone);
  }

  public function telefones_post( Request $request, $id, $id_telefone )
  {
    $telefone = Telefones::find($id_telefone);
    $telefone->numero = $request->numero;
    $telefone->tipo = $request->tipo;
    $telefone->update();
    return redirect()->route('contatos');
  }

  public function telefones( $id )
  {
    $contato = Contatos::find($id);
    return view('contatos.newphone')->with('contato', $contato);
  }

  public function telefones_new( Request $request, $id )
  {
    $telefone = new Telefones;
    $telefone->contatos_id = $id;
    $telefone->tipo = $request->tipo;
    $telefone->numero = $request->numero;
    $telefone->save();
    return redirect()->route('contatos');
  }

  public function telefones_delete( $id, $id_telefone )
  {
    $telefone = Telefones::find($id_telefone);
    $telefone->delete();
    return redirect()->route('contatos');
  }

  public function relacoes( $id)
  {
    $contato = Contatos::find($id);
    return view('contatos.relacoes')->with('contato', $contato);
  }

  public function relacoes_novo( $id)
  {
    $contato = Contatos::find($id);
    $contatos = Contatos::all();
    return view('contatos.relacoesnovo')->with('contato', $contato)->with('contatos', $contatos);
  }

  public function relacoes_busca( Request $request, $id)
  {
    $contato = Contatos::find($id);
    if (!empty($request->busca)){
      $contatos = Contatos::where('nome', 'like', '%' .  $request->busca . '%')
                            ->orWhere('sobrenome', 'like', '%' .  $request->busca . '%')
                            ->get();
    } else {
      $contatos = Contatos::all();
    }
    return view('contatos.relacoesnovo')->with('contato', $contato)->with('contatos', $contatos);
    #return $contatos;
  }

  public function relacoes_post( Request $request, $id)
  {
    $contato = contatos::Find($id);
    $data = [
      $id =>
      [
        'from_text' => $request->from_text,
        'to_id' => $request->to_id,
        'to_text' => $request->to_text
      ]
    ];
    $contato->from()->sync($data, false);

    $contatos = Contatos::all();

    return view('contatos.relacoes')->with('contato', $contato)->with('contatos', $contatos);
  }

  public function relacoes_delete( $id, $relacao_id){
    $relation = DB::table('contatos_pivot')->where('id', '=', $relacao_id)->delete();

    $contato = Contatos::find($id);
    $contatos = Contatos::all();

    return view('contatos.relacoes')->with('contato', $contato)->with('contatos', $contatos);
  }
  public function delete($id){
    $contato = Contatos::withTrashed()->find($id);

    if ($contato->trashed()) {
      $contato->restore();
    } else {
      $contato->delete();
    }
    $contatos = Contatos::all();
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Contatos::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    return view('contatos.list')->with('contatos', $contatos)->with('deletados', $deletados);
  }
}
