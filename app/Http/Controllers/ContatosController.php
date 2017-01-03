<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use DB;
use Auth;
use Intervention\Image\ImageManagerStatic as Image;
use App\Contatos as Contatos;
use App\Telefones as Telefones;
use App\Attachments as Attachs;
use Log;
use Carbon\Carbon;

class ContatosController extends Controller
{
  public function show()
  {
    Log::info('Lista de contatos para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    $contatos = contatos::paginate(15);
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Contatos::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    return view('contatos.list')->with('contatos', $contatos)->with('deletados', $deletados);
  }

  public function search( Request $request)
  {
    Log::info('Busca de contatos usando -> "'.$request->busca.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
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
    if (is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1){
        $deletados = Contatos::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    return view('contatos.list')->with('contatos', $contatos)->with('deletados', $deletados);
  }

  public function showNovo()
  {
    Log::info('Criando novo contato, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
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
    $contato->obs = $request->obs;
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

    Log::info('Busca de contatos usando -> "'.$request.'", resultando em -> "'.$contato.'" para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());


    return redirect()->action('ContatosController@show');
  }
  public function showId( $id )
  {
    $contato = contatos::find($id);
    Log::info('Detalhes de contato -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('contatos.new')->with('contato', $contato);
  }

  public function update( Request $request, $id )
  {
    $contato = contatos::find($id);

    Log::info('Atualizar contato de -> "'.$contato.'" novo -> "'.$request.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

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
    $contato->obs = $request->obs;
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

    return redirect()->action('ContatosController@show');
  }

  public function telefones_get( $id, $id_telefone )
  {
    Log::info('Editar telefone de contato id:'.$id.' telefone id "'.$id_telefone.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    $telefone = Telefones::find($id_telefone);
    return view('contatos.phone')->with('telefone', $telefone);
  }

  public function telefones_post( Request $request, $id, $id_telefone )
  {
    $telefone = Telefones::find($id_telefone);
    $telefone->numero = $request->numero;
    $telefone->tipo = $request->tipo;
    $telefone->update();

    Log::info('Salvar telefone de contato(id:'.$id.') resultando -> "'.$telefone.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return redirect()->action('ContatosController@show');
  }

  public function telefones( $id )
  {
    $contato = Contatos::find($id);
    Log::info('Criando novo telefone para contato-> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('contatos.newphone')->with('contato', $contato);
  }

  public function telefones_new( Request $request, $id )
  {
    $telefone = new Telefones;
    $telefone->contatos_id = $id;
    $telefone->tipo = $request->tipo;
    $telefone->numero = $request->numero;
    $telefone->save();

    Log::info('Salvo telefone para contato(id'.$id.') resultando em-> "'.$telefone.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return redirect()->action('ContatosController@show');
  }

  public function telefones_delete( $id, $id_telefone )
  {
    $telefone = Telefones::find($id_telefone);

    Log::info('Deletando telefone para contato(id'.$id.') refente -> "'.$telefone.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    $telefone->delete();

    return redirect()->action('ContatosController@show');
  }

  public function relacoes( $id)
  {
    $contato = Contatos::find($id);
    Log::info('Ver relacionamentos do contato -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('contatos.relacoes')->with('contato', $contato);
  }

  public function relacoes_novo( $id)
  {
    $contato = Contatos::find($id);

    Log::info('Novo relacionamento para contato -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    $contatos = Contatos::paginate(15);
    return view('contatos.relacoesnovo')->with('contato', $contato)->with('contatos', $contatos);
  }

  public function relacoes_busca( Request $request, $id)
  {
    $contato = Contatos::find($id);
    if (!empty($request->busca)){
      $contatos = Contatos::where('nome', 'like', '%' .  $request->busca . '%')
                            ->orWhere('sobrenome', 'like', '%' .  $request->busca . '%')
                            ->paginate(15);
    } else {
      $contatos = Contatos::paginate(15);
    }

    Log::info('Novo relacionamento com busca -> "'.$request->busca.'", para contato -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

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

    Log::info('Salvando relacionamento do contato -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return redirect()->action('ContatosController@show');
  }

  public function relacoes_delete( $id, $relacao_id){
    $relation = DB::table('contatos_pivot')->where('id', '=', $relacao_id)->delete();

    $contato = Contatos::find($id);

    Log::info('Deletar relacionamento do contato -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return redirect()->action('ContatosController@show');
  }
  public function delete($id){
    $contato = Contatos::withTrashed()->find($id);

    if ($contato->trashed()) {
      $contato->restore();
      Log::info('Restaurando contato -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    } else {
      Log::info('Deletando contato -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $contato->delete();
    }
    return redirect()->action('ContatosController@show');
  }

  public function attach(request $request, $id){
    $attach = new Attachs;
    $attach->attachmentable_id = $id;
    $attach->attachmentable_type = "App\Contatos";
    $attach->name = $request->name;
    $attach->path = $request->file->store('public');
    $attach->save();

    $path = storage_path() . '/' .'app/'. $attach->path;
    $file = Image::make($path);
    if ($file->width() > 1100){
      $file->resize("1100", null, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
      });
      $file->save();
    }
    Log::info('Anexando arquivo para contato -> "'.$id.'", anexo -> "'.$attach.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return redirect()->action('ContatosController@show');
  }
}
