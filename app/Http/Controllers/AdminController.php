<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as User;
use App\Contatos as Contatos;
use App\Users_permissions as Roles;
use App\Erp_configs as Configs;
use App\Combobox_texts as Comboboxes;
use File;
use Storage;
use ZipArchive;
use Artisan;
use DateTime;
use Log;
use Auth;

class AdminController extends Controller
{

  public function index(){

    Log::info('!!!ADMIN!!! Mostrando index, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $contatos = contatos::all();
    return view('admin.index')->with('contatos', $contatos);
  }

  public function configuration(){
    Log::info('!!!ADMIN!!! Mostrando configuration, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $configs = Configs::all();
    $field_codigo = Configs::where('field', "field_codigo")->first();
    return view('admin.configuration')->with('configs', $configs)
                                      ->with('field_codigo', $field_codigo);
  }
  public function configuration_save(request $request){
    #return $request->codigo;
    Log::info('!!!ADMIN!!! Salvando configuration, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $configs = Configs::all();
    $field_codigo = Configs::where('field', 'field_codigo')->first();
    $field_codigo->value = $request->codigo;
    $field_codigo->save();
    return view('admin.configuration')->with('configs', $configs)
                                      ->with('field_codigo', $field_codigo);
  }

  public function user_edit($id){
    $contato = Contatos::find($id);
    $matriz = Contatos::find(1);

    $filiais[]=$matriz;
    foreach ($matriz->to as $key => $relacao) {
      if ($relacao->from_text="Filial"){
        $filiais[] = $relacao;
      }
    }

    Log::info('!!!ADMIN!!! Editando usuario de -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return view('admin.useredit')->with('contato', $contato)->with('filiais', $filiais);
  }

    public function user_modify(Request $request, $id){
      $contato = Contatos::find($id);
      if ($contato->user){
        $user = User::find($contato->user->id);
      } else{
        $user = new User;
        $user->contatos_id = $id;
        $user->perms = "{}";
      }
      $user->user = $request->email;
      $user->password = bcrypt($request->password);
      $user->ativo = $request->ativo;
      $user->trabalho_id = $request->filial;
      $user->save();

      Log::info('!!!ADMIN!!! Salvando usuario -> "'.$user.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

      $contatos = contatos::all();
      return view('admin.index')->with('contatos', $contatos);
    }

    public function access($id){
      $contato = Contatos::find($id);

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
      if ($contato->user->perms["admin"]==1){
        $contato->user->perms["admin"]=0;
        Log::info('!!!ADMIN!!! Removendo admin do usuario -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      } else{
        $contato->user->perms["admin"]=1;
        Log::info('!!!ADMIN!!! Dando admin ao usuario -> "'.$contato.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      }
      #$contato->user->perms = $request->role;
      $contato->user->save();
      $contatos = contatos::all();
      return view('admin.index')->with('contatos', $contatos);

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
       Artisan::call('backup:run', ['--only-db' => true]);
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
    }
    public function combobox_salvar(request $request){
      #return $request;
      Log::info('!!!ADMIN!!! Salvando novo combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      foreach ($request->text as $key => $text) {
        $combobox = New Comboboxes;
        $combobox->combobox_textable_id = "1";
        if($request->tipo[$key]=="Telefones" or $request->tipo[$key]=="Contas" or $request->tipo[$key]=="Caixas"){
          $combobox->combobox_textable_type = "App\\".$request->tipo[$key];
          $combobox->field= $request->field[$key];
          $combobox->text = $request->text[$key];
          $combobox->value = $request->text[$key];
        }
        if($request->tipo[$key]=="Relacionamento"){
          $combobox->combobox_textable_type = "App\\".$request->tipo[$key];
          $combobox->field= "tipo";
          $combobox->text=$request->text[$key];
          $combobox->value=$request->value[$key];
        }
        if($request->tipo[$key]=="Atendimentos"){
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
      #Log::info('!!!ADMIN!!! Deletando opçao '.$id.' combobox, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
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
