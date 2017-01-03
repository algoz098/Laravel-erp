<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as User;
use App\Contatos as Contatos;
use App\Users_permissions as Roles;

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
      $user->email = $request->email;
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
}
