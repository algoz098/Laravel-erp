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
use App\Funcionarios as Funcionarios;
use App\Erp_configs as Configs;
use App\User as User;
use App\Combobox_texts as Comboboxes;
use Log;
use Carbon\Carbon;

class ContatosController extends BaseController
{
  public function __construct(){
     parent::__construct();
  }
  public function selecionar()
  {
    Log::info('Selecionar de contatos para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $contatos = contatos::orderBy('nome', 'asc')->paginate(15);
    return view('contatos.selecionar')
                ->with('contatos', $contatos);
  }
  public function show()
  {
    Log::info('Lista de contatos para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $contatos = contatos::orderBy('nome', 'asc')->paginate(15);
    $total= contatos::count();
    $empresas = contatos::where('tipo', '0')->count();
    $pessoas = contatos::where('tipo', '1')->count();
    $deletados = 0;
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Relacionamento')->get();
    return view('contatos.list')
                ->with('contatos', $contatos)
                ->with('deletados', $deletados)
                ->with('total', $total)
                ->with('empresas', $empresas)
                ->with('pessoas', $pessoas)
                ->with('comboboxes', $comboboxes);
  }

  public function search( Request $request)
  {
    #return $request->busca;
    Log::info('Busca de contatos usando -> "'.$request->busca.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $contatos = Contatos::query();
    if ($request->data_de and !$request->data_ate){
      $contatos = $contatos->whereBetween('created_at', [$request->data_de, Carbon::today()]);
    }
    if ($request->data_de and $request->data_ate){
      $contatos = $contatos->whereBetween('created_at', [$request->data_de, $request->data_ate]);
    }
    if (!empty($request->relacao)){
      $a = $request->relacao;
      $contatos = $contatos->whereHas('from', function ($query) use ($a){
        $query->where('from_text', 'like', '%'.$a.'%');
      });
    }
    if (!empty($request->busca)){
      $contatos = $contatos->orWhere('nome', 'like', '%' .  $request->busca . '%');
      $contatos = $contatos->orWhere('sobrenome', 'like', '%' .  $request->busca . '%');
      $contatos = $contatos->orWhere('endereco', 'like', '%' .  $request->busca . '%');
      $contatos = $contatos->orWhere('cpf', 'like', '%' .  $request->busca . '%');
      $contatos = $contatos->orWhere('cidade', 'like', '%' .  $request->busca . '%');
      $contatos = $contatos->orWhere('uf', 'like', '%' .  $request->busca . '%');
      $contatos = $contatos->orWhere('bairro', 'like', '%' .  $request->busca . '%');
      $contatos = $contatos->orWhere('cep', 'like', '%' .  $request->busca . '%');
    }
    $contatos = $contatos->orderBy('nome', 'asc')->paginate(15);
    if ((is_array(Auth::user()->perms) and Auth::user()->perms["admin"]==1) and $request->deletados){
        $deletados = Contatos::onlyTrashed()->get();
    } else {
      $deletados = 0;
    }
    $empresas = contatos::where('tipo', '0')->count();
    $pessoas = contatos::where('tipo', '1')->count();
    $total= contatos::count();
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Relacionamento')->get();
    return view('contatos.list')->with('contatos', $contatos)->with('deletados', $deletados)
    ->with('total', $total)
    ->with('empresas', $empresas)
    ->with('pessoas', $pessoas)
    ->with('comboboxes', $comboboxes);
  }

  public function detalhes($id){
    $contato = contatos::find($id);
    return view('contatos.detalhes')->with('contato', $contato);
  }

  public function funcionarios_novo()
  {
    Log::info('Criando novo contato, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Relacionamento')->get();
    $comboboxes_telefones = comboboxes::where('combobox_textable_type', 'App\Telefones')->get();
    $a = "Filial";
    $filiais = Contatos::whereHas('from', function ($query) use ($a){
                      $query->where('from_text', 'like', '%'.$a.'%');
                    })->get();
    $is_funcionario = 1;
    $field_codigo = Configs::where('field', 'field_codigo')->first();
    return view('contatos.new')->with('is_funcionario', $is_funcionario)
                               ->with('filiais', $filiais)
                               ->with('field_codigo', $field_codigo)
                               ->with('comboboxes', $comboboxes)
                               ->with('comboboxes_telefones', $comboboxes_telefones);
  }

  public function showNovo()
  {
    Log::info('Criando novo contato, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Relacionamento')->get();
    $comboboxes_telefones = comboboxes::where('combobox_textable_type', 'App\Telefones')->get();
    $field_codigo = Configs::where('field', 'field_codigo')->first();
    return view('contatos.new')->with('comboboxes', $comboboxes)
                                ->with('comboboxes_telefones', $comboboxes_telefones)
                                ->with('field_codigo', $field_codigo);
  }

  public function novo( Request $request )
  {
    $this->validate($request, [
        'nome' => 'required|max:50'
    ]);
    $contato = new Contatos;
    $contato->nome = $request->nome;
    $contato->cpf = $request->cpf;
    $contato->rg = $request->rg;
    $contato->sobrenome = $request->sobrenome;
    $contato->endereco = $request->endereco;
    $contato->numero = $request->numero;
    $contato->complemento = $request->complemento;
    $contato->bairro = $request->bairro;
    $contato->uf = $request->uf;
    $contato->cidade = $request->cidade;
    $contato->cep = $request->cep;
    $contato->sociabilidade = $request->sociabilidade;
    $contato->tipo = $request->tipo;
    $contato->obs = $request->obs;
    $contato->cod_prefeitura = $request->cod_prefeitura;
    $contato->codigo = $request->codigo;
    $contato->nascimento = $request->nascimento;
    if ($request->active){
        $contato->active = "4";
    } else {
      $contato->active="1";
    }
    $contato->save();
    foreach ($request->tipo_tel as $key => $tipo) {
      $telefone = new Telefones;
      $telefone->contatos_id = $contato->id;
      $telefone->tipo = $request->tipo_tel[$key];
      $telefone->numero = $request->numero_tel[$key];
      $telefone->contato = $request->contato_tel[$key];
      $telefone->setor = $request->setor_tel[$key];
      $telefone->ramal = $request->ramal_tel[$key];
      $telefone->save();
    }
    if ($request->is_funcionario!="1"){
      $combobox = Comboboxes::where('text', $request->relacao)->first();
      if ($combobox){
        $data = [
          $request->from_id =>
          [
            'from_text' => $combobox->text,
            'to_id' => 1,
            'to_text' => $combobox->value
          ]
        ];
        $contato->from()->sync($data, false);
      }
    } else {
      // CASO FOR CADASTRO DE FUNCIONARIO
      $data = [
        $request->filial =>
        [
          'from_text' => "Funcionario",
          'to_id' => 1,
          'to_text' => "Trabalho"
        ]
      ];
      $contato->from()->sync($data, false);
      $func = new Funcionarios;
      $func->contatos_id = $contato->id;
      $func->cargo = $request->cargo;
      $func->data_adm = $request->data_adm;
      $func->data_dem = $request->data_dem;
      $func->cnh = $request->cnh;
      $func->cnh_cat = $request->cnh_cat;
      $func->cnh_venc = $request->cnh_venc;
      $func->cart_trab_num = $request->cart_trab_num;
      $func->cart_trab_serie = $request->cart_trab_serie;
      $func->eleitor = $request->eleitor;
      $func->eleitor_sessao = $request->eleitor_sessao;
      $func->eleitor_zona = $request->eleitor_zona;
      $func->eleitor_exp = $request->eleitor_exp;
      $func->pis = $request->pis;
      $func->pis_banco = $request->pis_banco;
      $func->inss = $request->inss;
      $func->rg_exp = $request->rg_exp;
      $func->rg_pai = $request->rg_pai;
      $func->rg_mae = $request->rg_mae;
      $func->ajuda_custo = $request->ajuda_custo;
      $func->reservista = $request->reservista;
      $func->sal = $request->sal;
      $func->sal_real = $request->sal_real;
      $func->sal_inss = $request->sal_inss;
      $func->vt = $request->vt;
      $func->vt_percentual = $request->vt_percentual;
      $func->va = $request->va;
      $func->vr = $request->vr;
      $func->peri = $request->peri;
      $func->peri_percentual = $request->peri_percentual;
      $func->save();
      $user = new User;
      $user->email = $request->user;
      $user->password = bcrypt($request->password);
      $user->ativo = $request->ativo;
      if ($request->filial!=""){
        $user->trabalho_id = $request->filial;
      } else {
        $user->trabalho_id = 1;
      }
      $user->contatos_id = $contato->id;
      $user->perms="{}";
      $user->save();
    }

    Log::info('Busca de contatos usando -> "'.$request.'", resultando em -> "'.$contato.'" para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return redirect()->action('ContatosController@show');
  }
  public function showId( $id )
  {
    $contato = contatos::find($id);
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Relacionamento')->get();
    $comboboxes_telefones = comboboxes::where('combobox_textable_type', 'App\Telefones')->get();
    $field_codigo = Configs::where('field', 'field_codigo')->first();
    if($contato->funcionario){
      $is_funcionario = 1;
      $a = "Filial";
      $filiais = Contatos::whereHas('from', function ($query) use ($a){
                        $query->where('from_text', 'like', '%'.$a.'%');
                      })->get();
      return view('contatos.new')->with('contato', $contato)
                                 ->with('comboboxes', $comboboxes)
                                 ->with('comboboxes_telefones', $comboboxes_telefones)
                                 ->with('field_codigo', $field_codigo)
                                 ->with('is_funcionario', $is_funcionario)
                                 ->with('filiais', $filiais);
    }
    Log::info('Detalhes de contato -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return view('contatos.new')->with('contato', $contato)
                               ->with('comboboxes', $comboboxes)
                               ->with('field_codigo', $field_codigo)
                               ->with('comboboxes_telefones', $comboboxes_telefones);
  }

  public function update( Request $request, $id )
  {
    $this->validate($request, [
        'nome' => 'required|max:50',
    ]);
    $contato = contatos::find($id);

    Log::info('Atualizar contato de -> "'.$contato.'" novo -> "'.$request.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    $contato->nome = $request->nome;
    $contato->cpf = $request->cpf;
    $contato->rg = $request->rg;
    $contato->sobrenome = $request->sobrenome;
    $contato->endereco = $request->endereco;
    $contato->numero = $request->numero;
    $contato->complemento = $request->complemento;
    $contato->bairro = $request->bairro;
    $contato->uf = $request->uf;
    $contato->cidade = $request->cidade;
    $contato->cep = $request->cep;
    $contato->sociabilidade = $request->sociabilidade;
    $contato->tipo = $request->tipo;
    $contato->codigo = $request->codigo;
    $contato->nascimento = $request->nascimento;
    $contato->cod_prefeitura = $request->cod_prefeitura;
    $contato->obs = $request->obs;
    if ($request->active){
        $contato->active = "4";
    } else {
      $contato->active="1";
    }
    $contato->save();
    if ($request->id_tel){
      foreach ($request->tipo_id as $a => $tipo_id) {
        $telefone = Telefones::find($request->id_tel[$a]);
        $telefone->tipo = $request->tipo_id[$a];
        $telefone->numero = $request->numero_id[$a];
        $telefone->contato = $request->contato_id[$a];
        $telefone->setor = $request->setor_id[$a];
        $telefone->ramal = $request->ramal_id[$a];
        $telefone->save();
      }
    }
    if ($request->tipo_tel){
      foreach ($request->tipo_tel as $key => $tipo) {
        $telefone = new Telefones;
        $telefone->contatos_id = $contato->id;
        $telefone->tipo = $request->tipo_tel[$key];
        $telefone->numero = $request->numero_tel[$key];
        $telefone->contato = $request->contato_tel[$key];
        $telefone->setor = $request->setor_tel[$key];
        $telefone->ramal = $request->ramal_tel[$key];
        $telefone->save();
      }
    }
    if ($request->is_funcionario!="1"){
      $combobox = Comboboxes::where('text', $request->relacao)->first();
      if ($combobox){
        $data = [
          $request->from_id =>
          [
            'from_text' => $combobox->text,
            'to_id' => 1,
            'to_text' => $combobox->value
          ]
        ];
        $contato->from()->sync($data, false);
      }
    } else {
      // CASO FOR CADASTRO DE FUNCIONARIO
      $data = [
        $request->filial =>
        [
          'from_text' => "Funcionario",
          'to_id' => 1,
          'to_text' => "Trabalho"
        ]
      ];
      $contato->from()->sync($data, false);
      $func = Funcionarios::where('contatos_id', $id)->first();
      $func->contatos_id = $contato->id;
      $func->cargo = $request->cargo;
      $func->data_adm = $request->data_adm;
      $func->data_dem = $request->data_dem;
      $func->cnh = $request->cnh;
      $func->cnh_cat = $request->cnh_cat;
      $func->cnh_venc = $request->cnh_venc;
      $func->cart_trab_num = $request->cart_trab_num;
      $func->cart_trab_serie = $request->cart_trab_serie;
      $func->eleitor = $request->eleitor;
      $func->eleitor_sessao = $request->eleitor_sessao;
      $func->eleitor_zona = $request->eleitor_zona;
      $func->eleitor_exp = $request->eleitor_exp;
      $func->pis = $request->pis;
      $func->pis_banco = $request->pis_banco;
      $func->inss = $request->inss;
      $func->rg_exp = $request->rg_exp;
      $func->rg_pai = $request->rg_pai;
      $func->rg_mae = $request->rg_mae;
      $func->ajuda_custo = $request->ajuda_custo;
      $func->reservista = $request->reservista;
      $func->sal = $request->sal;
      $func->sal_real = $request->sal_real;
      $func->sal_inss = $request->sal_inss;
      $func->vt = $request->vt;
      $func->vt_percentual = $request->vt_percentual;
      $func->va = $request->va;
      $func->vr = $request->vr;
      $func->peri = $request->peri;
      $func->peri_percentual = $request->peri_percentual;
      $func->save();
      $contato->user->email = $request->user;
      $contato->user->password = bcrypt($request->password);
      $contato->user->ativo = $request->ativo;
      $contato->user->trabalho_id = $request->filial;
      $contato->user->contatos_id = $contato->id;
      $contato->user->perms="{}";
      $contato->user->save();
    }

    $combobox = Comboboxes::where('text', $request->relacao)->first();
    #return $combobox;
    if ($combobox){

      $data = [
        $request->from_id =>
        [
          'from_text' => $combobox->text,
          'to_id' => 1,
          'to_text' => $combobox->value
        ]
      ];
      $contato->from()->sync($data, false);
    }

    $contato->save();

    return redirect()->action('ContatosController@show');
  }

  /*
  public function telefones_get( $id, $id_telefone )
  {
    Log::info('Editar telefone de contato id:'.$id.' telefone id "'.$id_telefone.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    $telefone = Telefones::find($id_telefone);
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Telefones')->get();
    return view('contatos.phone')->with('telefone', $telefone)->with("comboboxes", $comboboxes);
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
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Telefones')->get();
    #return $comboboxes;
    $contato = Contatos::find($id);
    Log::info('Criando novo telefone para contato-> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('contatos.newphone')->with('contato', $contato)->with('comboboxes', $comboboxes);
  }
  public function telefones_new( Request $request, $id )
  {

    foreach ($request->tipo as $key => $tipo) {
      $telefone = new Telefones;
      $telefone->contatos_id = $id;
      $telefone->tipo = $request->tipo[$key];
      $telefone->numero = $request->numero[$key];
      $telefone->save();
    }
    Log::info('Salvo telefone para contato(id'.$id.') resultando em-> "'.$telefone.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return redirect()->action('ContatosController@show');
  }
  */
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
    $comboboxes = comboboxes::where('combobox_textable_type', 'App\Relacionamento')->get();
    return view('contatos.relacoesnovo')->with('contato', $contato)->with('contatos', $contatos)->with('comboboxes', $comboboxes);
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
  }

  public function relacoes_post( Request $request, $id)
  {
    $combobox = comboboxes::find($request->combobox_id);
    $contato = contatos::Find($id);
    $data = [
      $id =>
      [
        'from_text' => $combobox->text,
        'to_id' => $request->to_id,
        'to_text' => $combobox->value
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
  public function attachs_detalhes($id){
    $attachs = Contatos::find($id)->attachs;
    return view('contatos.attachs')->with('attachs', $attachs)->with('contato_id', $id);

  }
  public function attach(request $request, $id){
    $attach = new Attachs;
    $attach->attachmentable_id = $id;
    $attach->attachmentable_type = "App\Contatos";
    $attach->name = $request->name;
    $attach->path = $request->file->store('public');
    $attach->contatos_id = $id;
    $attach->save();

    $path = storage_path() . '/' .'app/'. $attach->path;
    $file = Image::make($path);
    /*if ($file->width() > 1100){
      $file->resize("1100", null, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
      });
      $file->save();
    }*/
    Log::info('Anexando arquivo para contato -> "'.$id.'", anexo -> "'.$attach.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return redirect()->action('ContatosController@show');
  }
}
