<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as User;
use App\Contatos as Contatos;
use App\Attachments as Attachs;
use App\Users_permissions as Roles;
use App\Erp_configs as Configs;
use App\Combobox_texts as Comboboxes;
use Response;
use File;
use Storage;
use ZipArchive;
use Artisan;
use DateTime;
use Log;
use Auth;
use Config;

class AdminController  extends BaseController
{
  public function __construct(){
     parent::__construct();
  }

  public function usuarios(request $request){

    Log::info('!!!ADMIN!!! Mostrando index, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $contatos = contatos::has('user')->with('user')->paginate(15);

    return $contatos;
  }

  public function usuarios_editar($id){
    $usuario = User::with('trabalho')->find($id);
    // $matriz = Contatos::find(1);
    //
    // $filiais[]=$matriz;
    // foreach ($matriz->to as $key => $relacao) {
    //   if ($relacao->from_text="Filial"){
    //     $filiais[] = $relacao;
    //   }
    // }

    Log::info('!!!ADMIN!!! Editando usuario de -> "'.$usuario.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return $usuario;
  }

  public function usuarios_salvar(Request $request, $id){
    $user = User::find($id);
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->ativo = $request->ativo;
    $user->save();

    Log::info('!!!ADMIN!!! Salvando usuario -> "'.$user.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return $user;
  }












  public function img_destaque(){
    $imagem_destaque = Configs::where('field', 'img_destaque')->pluck('options')->first();
    $attach = Attachs::find($imagem_destaque);

    if ($imagem_destaque!=""){
      $path = storage_path() . '/' .'app/'. $attach->path;
    }
    if ($imagem_destaque==""){
      $path = public_path('img_destaque.jpeg');
    }

    if(!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
  }


  public function configuration(){
    Log::info('!!!ADMIN!!! Mostrando configuration, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $configs = Configs::all();
    $field_codigo = Configs::where('field', "field_codigo")->first();
    if (!isset($field_codigo)) {
      $field_codigo = new Configs;
      $field_codigo->field = "field_codigo";
      $field_codigo->text = 'Campo "Codigo"';
      $field_codigo->value = '1';
      $field_codigo->options = '';
      $field_codigo->save();

    }
    $img_destaque = Configs::where('field', "img_destaque")->first();
    if (!isset($img_destaque)) {
      $img_destaque = new Configs;
      $img_destaque->field = "img_destaque";
      $img_destaque->text = 'Imagem de destaque';
      $img_destaque->value = '';
      $img_destaque->options = '';
      $img_destaque->save();

    }
    $modulo_atendimentos = Configs::where('field', "modulo_atendimentos")->first();
    if (!isset($modulo_atendimentos)) {
      $modulo_atendimentos = new Configs;
      $modulo_atendimentos->field = "modulo_atendimentos";
      $modulo_atendimentos->text = 'MODULO "ATENDIMENTOS"';
      $modulo_atendimentos->value = '1';
      $modulo_atendimentos->options = '';
      $modulo_atendimentos->save();
    }
    $modulo_contas = Configs::where('field', "modulo_contas")->first();
    if (!isset($modulo_contas)) {
      $modulo_contas = new Configs;
      $modulo_contas->field = "modulo_contas";
      $modulo_contas->text = 'Modulo "Contas"';
      $modulo_contas->value = '1';
      $modulo_contas->options = '';
      $modulo_contas->save();
    }
    $modulo_bancos = Configs::where('field', "modulo_bancos")->first();
    if (!isset($modulo_bancos)) {
      $modulo_bancos = new Configs;
      $modulo_bancos->field = "modulo_bancos";
      $modulo_bancos->text = 'Modulo "Bancos"';
      $modulo_bancos->value = '1';
      $modulo_bancos->options = '';
      $modulo_bancos->save();
    }
    $modulo_tickets = Configs::where('field', "modulo_tickets")->first();
    if (!isset($modulo_tickets)) {
      $modulo_tickets = new Configs;
      $modulo_tickets->field = "modulo_tickets";
      $modulo_tickets->text = 'MODULO "Tickets"';
      $modulo_tickets->value = '1';
      $modulo_tickets->options = '';
      $modulo_tickets->save();
    }

    $modulo_caixas = Configs::where('field', "modulo_caixas")->first();
    if (!isset($modulo_caixas)) {
      $modulo_caixas = new Configs;
      $modulo_caixas->field = "modulo_caixas";
      $modulo_caixas->text = 'Modulo "Caixas"';
      $modulo_caixas->value = '1';
      $modulo_caixas->options = '';
      $modulo_caixas->save();
    }

    $modulo_vendas = Configs::where('field', "modulo_vendas")->first();
    if (!isset($modulo_vendas)) {
      $modulo_vendas = new Configs;
      $modulo_vendas->field = "modulo_vendas";
      $modulo_vendas->text = 'Modulo "Vendas"';
      $modulo_vendas->value = '1';
      $modulo_vendas->options = '';
      $modulo_vendas->save();
    }

    $modulo_estoques = Configs::where('field', "modulo_estoques")->first();
    if (!isset($modulo_estoques)) {
      $modulo_estoques = new Configs;
      $modulo_estoques->field = "modulo_estoques";
      $modulo_estoques->text = 'Modulo "Estoques"';
      $modulo_estoques->value = '1';
      $modulo_estoques->options = '';
      $modulo_estoques->save();
    }

    $modulo_frotas = Configs::where('field', "modulo_frotas")->first();
    if (!isset($modulo_frotas)) {
      $modulo_frotas = new Configs;
      $modulo_frotas->field = "modulo_frotas";
      $modulo_frotas->text = 'Modulo "Frotas"';
      $modulo_frotas->value = '1';
      $modulo_frotas->options = '';
      $modulo_frotas->save();
    }

    $matriz = Contatos::find(1);
    return view('admin.configuration')->with('configs', $configs)
                                      ->with('field_codigo', $field_codigo)
                                      ->with('img_destaque', $img_destaque)
                                      ->with('modulo_atendimentos', $modulo_atendimentos)
                                      ->with('modulo_tickets', $modulo_tickets)
                                      ->with('modulo_contas', $modulo_contas)
                                      ->with('modulo_caixas', $modulo_caixas)
                                      ->with('modulo_vendas', $modulo_vendas)
                                      ->with('modulo_estoques', $modulo_estoques)
                                      ->with('modulo_frotas', $modulo_frotas)
                                      ->with('modulo_bancos', $modulo_bancos)
                                      ->with('matriz', $matriz);
  }
  public function configuration_save(request $request){
    #return $request->img_destaque;
    Log::info('!!!ADMIN!!! Salvando configuration, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $configs = Configs::all();

    $field_codigo = Configs::where('field', 'field_codigo')->first();
    $field_codigo->value = $request->field_codigo;
    $field_codigo->save();

    $modulo_atendimentos = Configs::where('field', "modulo_atendimentos")->first();
    $modulo_atendimentos->value = $request->modulo_atendimentos;
    $modulo_atendimentos->save();

    $modulo_tickets = Configs::where('field', "modulo_tickets")->first();
    $modulo_tickets->value = $request->modulo_tickets;
    $modulo_tickets->save();

    $modulo_contas = Configs::where('field', "modulo_contas")->first();
    $modulo_contas->value = $request->modulo_contas;
    $modulo_contas->save();

    $modulo_caixas = Configs::where('field', "modulo_caixas")->first();
    $modulo_caixas->value = $request->modulo_caixas;
    $modulo_caixas->save();

    $modulo_vendas = Configs::where('field', "modulo_vendas")->first();
    $modulo_vendas->value = $request->modulo_vendas;
    $modulo_vendas->save();

    $modulo_estoques = Configs::where('field', "modulo_estoques")->first();
    $modulo_estoques->value = $request->modulo_estoques;
    $modulo_estoques->save();

    $modulo_frotas = Configs::where('field', "modulo_frotas")->first();
    $modulo_frotas->value = $request->modulo_frotas;
    $modulo_frotas->save();

    $img_destaque = Configs::where('field', 'img_destaque')->first();
    if ($request->img_destaque!=""){
      $attach = Attachs::find($request->img_destaque);
      $img_destaque->value = $attach->name;
      $img_destaque->options = $request->img_destaque;
      $img_destaque->save();
    }

    return redirect()->action('AdminController@configuration');
  }



    public function access($id){
      $contato = Contatos::find($id);
      return view('admin.access')->with('contato', $contato);
      $perms = $contato->user->perms;
      if (!isset($contato->user->perms["admin"])){
        $perms = array("admin" => "0");
      }
      if ($perms["admin"]=='1'){
        $valor="0";
        Log::info('!!!ADMIN!!! Removendo admin do usuario -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      } else{
        $valor="1";
        Log::info('!!!ADMIN!!! Dando admin ao usuario -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      }

      $perms["admin"]=$valor;
      $contato->user->perms = $perms;
      $contato->user->save();
      $contatos = contatos::all();

      return view('admin.index')->with('contatos', $contatos);
    }

    public function access_post(Request $request, $id){
      $contato = Contatos::find($id);
      $a['admin'] = $request->admin;

      $a['contatos']['leitura'] = $request->contatos['leitura'];
      $a['contatos']['adicao'] = $request->contatos['adicao'];
      $a['contatos']['edicao'] = $request->contatos['edicao'];

      $a['tickets']['leitura'] = $request->tickets['leitura'];
      $a['tickets']['adicao'] = $request->tickets['adicao'];
      $a['tickets']['edicao'] = $request->tickets['edicao'];

      $a['atendimentos']['leitura'] = $request->atendimentos['leitura'];
      $a['atendimentos']['adicao'] = $request->atendimentos['adicao'];
      $a['atendimentos']['edicao'] = $request->atendimentos['edicao'];

      $a['contas']['leitura'] = $request->contas['leitura'];
      $a['contas']['adicao'] = $request->contas['adicao'];
      $a['contas']['edicao'] = $request->contas['edicao'];

      $a['bancos']['leitura'] = $request->bancos['leitura'];
      $a['bancos']['adicao'] = $request->bancos['adicao'];
      $a['bancos']['edicao'] = $request->bancos['edicao'];

      $a['vendas']['leitura'] = $request->vendas['leitura'];
      $a['vendas']['adicao'] = $request->vendas['adicao'];
      $a['vendas']['edicao'] = $request->vendas['edicao'];

      $a['caixas']['leitura'] = $request->caixas['leitura'];
      $a['caixas']['adicao'] = $request->caixas['adicao'];
      $a['caixas']['edicao'] = $request->caixas['edicao'];

      $a['estoques']['leitura'] = $request->estoques['leitura'];
      $a['estoques']['adicao'] = $request->estoques['adicao'];
      $a['estoques']['edicao'] = $request->estoques['edicao'];

      $a['frotas']['leitura'] = $request->frotas['leitura'];
      $a['frotas']['adicao'] = $request->frotas['adicao'];
      $a['frotas']['edicao'] = $request->frotas['edicao'];

      $contato->user->perms = json_decode(json_encode($a), true);
      $contato->user->save();
      return redirect()->action('AdminController@index');

    }
    public function access_delete($id, $id_access){
      $role = Roles::find($id_access);
      $role->delete();

      $contatos = contatos::all();

      return view('admin.index')->with('contatos', $contatos);
    }

    public function update_index(){
      $file = base_path() . "/manifest.json";
      $manifest = json_decode(file_get_contents($file), true);
      $remoto = json_decode(file_get_contents("http://www.webgs.com.br/clientes/erp/manifest.json"), true);
      Log::info('!!!ADMIN!!! Visualizando update, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      return view('admin.update')->with('manifest', $manifest)->with('remoto', $remoto);
    }

    public function update_do(){
      Log::info('!!!ADMIN!!! Realizando update, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

      $storage = storage_path();
      $base = base_path();
      $url = "http://www.webgs.com.br/clientes/erp";
      $json_remoto = json_decode(file_get_contents("http://www.webgs.com.br/clientes/erp/manifest.json"), true);
      $file_local= $storage.'/'.$json_remoto["versao"].".zip";
      $file = $json_remoto["versao"].".zip";
      if (!File::exists($file_local))
      {
        $download = file_put_contents($file_local, file_get_contents($url."/".$file));
      }
      $zip = new ZipArchive;
      if ($zip->open($file_local) === TRUE) {
          $zip->extractTo($base);
          $zip->close();
      } else {
          return 'Erro ao aplicar atualização';
      }
      $manifest_local = base_path() . "/manifest.json";
      $manifest = json_decode(file_get_contents($manifest_local), true);

      $migrate = Artisan::call('migrate');
      $migrate = Artisan::call('view:clear');
      return view('admin.update')->with('manifest', $manifest)->with('remoto', $json_remoto);
    }

    public function backup_index(){
      Log::info('!!!ADMIN!!! Visualizando BKPs, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

      if(!File::exists(storage_path('backups/'))){
        File::makeDirectory(storage_path('backups/'), 0775);
      }
      $files = File::Files(storage_path('backups/'));
      foreach ($files as $key => $file) {
        $backups[]=basename($file, ".zip");
      }
      if (isset($backups)){
        $ultimo = DateTime::createFromFormat('Y-m-d-His', end($backups));
      } else {
        $backups = 0;
        $ultimo = 0;
      }
      return view('admin.backup')->with('backups', $backups)->with('ultimo', $ultimo);
    }
    public function backup_download($file){
      Log::info('!!!ADMIN!!! Download de BKP -> "'.$file.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $pathToFile = storage_path('backups').'/'.$file.'.zip';
      return response()->download($pathToFile);
    }
    public function backup_do(){
      Log::info('!!!ADMIN!!! Realizando BKP, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
       Artisan::call('backup:run');
       $files = File::Files(storage_path('backups/'));
       foreach ($files as $key => $file) {
         $backups[]=basename($file, ".zip");
       }
       if (isset($backups)){
         $ultimo = DateTime::createFromFormat('Y-m-d-His', end($backups));
       } else {
         $backups = 0;
         $ultimo = 0;
       }
       return view('admin.backup')->with('backups', $backups)->with('ultimo', $ultimo);
    }
    public function logs(){
      Log::info('!!!ADMIN!!! Mostrando logs, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

      $path = storage_path() . '/' .'logs/laravel.log';

      if(!File::exists($path)) abort(404);

      $file = File::get($path);
      $type = File::mimeType($path);

      $remove = "\n";

      $split = explode($remove, $file);
      foreach ($split as $key => $line) {
        $invalid[] = strpos($line, "ERROR:");
        $invalid[] = strpos($line, "#");
        $invalid[] = strpos($line, "Next");
        $invalid[] = strpos($line, "Stack");
        #return $invalid;
        if (!in_array(true, $invalid)) {
          $result[] = $line;
        }
      }
      #return $result;
      return view('admin.logs')->with('logs', $result);
    }
    public function combobox(){
      Log::info('!!!ADMIN!!! Mostrando edicao de combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

      $comboboxes = Comboboxes::orderBy('combobox_textable_type', 'text')->get();
      return view('admin.combobox')->with('comboboxes', $comboboxes);
    }
    public function combobox_lista_contas(){
      Log::info('!!!ADMIN!!! Mostrando edicao de combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

      return view('admin.combobox.selecionar_conta');
    }
    public function combobox_lista_contas_search(request $request){
      Log::info('!!!ADMIN!!! Mostrando edicao de combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $comboboxes = Comboboxes::where('combobox_textable_type', 'App\Contas')->get();

      return view('admin.combobox.lista_conta')
        ->with('opcoes', $comboboxes);
    }

    public function combobox_novo(){
      Log::info('!!!ADMIN!!! Mostrando novo combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      return view('admin.combobox_novo');
    }
    public function combobox_novo_telefone(){
      Log::info('!!!ADMIN!!! Mostrando novo combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      return view('admin.combobox_novo_telefone');
    }
    public function combobox_novo_relacao(){
      Log::info('!!!ADMIN!!! Mostrando novo combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      return view('admin.combobox_novo_relacao');
    }
    public function combobox_novo_atend(){
      Log::info('!!!ADMIN!!! Mostrando novo combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      return view('admin.combobox_novo_atend');
    }
    public function combobox_novo_contas(){
      Log::info('!!!ADMIN!!! Mostrando novo combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      return view('admin.combobox_novo_contas');
    }
    public function combobox_novo_caixas(){
      Log::info('!!!ADMIN!!! Mostrando novo combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      return view('admin.combobox_novo_caixas');
    }
    public function combobox_novo_consumos(){
      Log::info('!!!ADMIN!!! Mostrando novo combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      return view('admin.combobox_novo_consumos');
    }
    public function combobox_novo_formas(){
      Log::info('!!!ADMIN!!! Mostrando novo combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      return view('admin.combobox_novo_formas');
    }
    public function combobox_novo_medidas(){
      Log::info('!!!ADMIN!!! Mostrando novo combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      return view('admin.combobox_novo_medidas');
    }
    public function combobox_novo_embalagens(){
      Log::info('!!!ADMIN!!! Mostrando novo combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      return view('admin.combobox_novo_embalagens');
    }
    public function combobox_edit($id){
      Log::info('!!!ADMIN!!! Mostrando ediçao combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

      $combobox = Comboboxes::find($id);
      if($combobox->combobox_textable_type=="App\Relacionamento"){
        return view('admin.combobox_novo_relacao')->with("combobox", $combobox);
      }
      if($combobox->combobox_textable_type=="App\Atendimentos"){
        return view('admin.combobox_novo_atend')->with("combobox", $combobox);
      }
      if($combobox->combobox_textable_type=="App\Contas"){
        return view('admin.combobox_novo_contas')->with("combobox", $combobox);
      }
      if($combobox->combobox_textable_type=="App\Contas\Formas"){
        return view('admin.combobox_novo_formas')->with("combobox", $combobox);
      }
      if($combobox->combobox_textable_type=="App\Caixas"){
        return view('admin.combobox_novo_caixas')->with("combobox", $combobox);
      }
      if($combobox->combobox_textable_type=="App\Telefones"){
        return view('admin.combobox_novo_telefone')->with("combobox", $combobox);
      }
      if($combobox->combobox_textable_type=="App\Consumos"){
        return view('admin.combobox_novo_consumos')->with("combobox", $combobox);
      }
      if($combobox->combobox_textable_type=="App\Produtos\Medidas"){
        return view('admin.combobox_novo_medidas')->with("combobox", $combobox);
      }
      if($combobox->combobox_textable_type=="App\Produtos\Embalagens"){
        return view('admin.combobox_novo_embalagens')->with("combobox", $combobox);
      }
    }
    public function combobox_salvar(request $request){
      #return $request;
      Log::info('!!!ADMIN!!! Salvando novo combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      foreach ($request->text as $key => $text) {
        $combobox = New Comboboxes;
        $combobox->combobox_textable_id = "1";
        if($request->tipo[$key]=="Telefones" or $request->tipo[$key]=="Contas" or $request->tipo[$key]=="Caixas"  ){
          $combobox->combobox_textable_type = "App\\".$request->tipo[$key];
          $combobox->field= $request->field[$key];
          $combobox->text = $request->text[$key];
          $combobox->value = $request->text[$key];
        }
        if($request->tipo[$key]=="Relacionamento" or $request->tipo[$key]=="Consumos"  or $request->tipo[$key]=="Produtos\Medidas" or $request->tipo[$key]=="Produtos\Embalagens" ){
          $combobox->combobox_textable_type = "App\\".$request->tipo[$key];
          $combobox->field= "tipo";
          $combobox->text=$request->text[$key];
          $combobox->value=$request->value[$key];
        }
        if($request->tipo[$key]=="Atendimentos" or $request->tipo[$key]=="Contas\Formas"){
          $combobox->combobox_textable_type = "App\\".$request->tipo[$key];
          $combobox->field= "tipo";
          $combobox->text=$request->text[$key];
          $combobox->value=$request->text[$key];
        }
        $combobox->save();
      }
      return redirect()->action('AdminController@combobox');
    }
    public function combobox_atualizar(request $request, $id){
      Log::info('!!!ADMIN!!! Salvando novo combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $combobox = Comboboxes::find($id);
      $combobox->combobox_textable_id = "1";
      if ($request->field){
        $combobox->field= $request->field;
      }
      if ($request->text){
        $combobox->text=$request->text;
      }
      if ($request->value){
        $combobox->value=$request->value;
      }
      $combobox->save();
      return redirect()->action('AdminController@combobox');
    }
    public function combobox_delete($id){
      $combobox = Comboboxes::withTrashed()->find($id);
      if ($combobox->trashed()) {
        $combobox->restore();
        Log::info('Restaurando opcao do combobox -> "'.$combobox.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      } else {
        Log::info('Deletando opcao do combobox -> "'.$combobox.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
        $combobox->delete();
      }
      return redirect()->action('AdminController@combobox');
    }
}
