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
class AdminController extends Controller
{
    public function index(){
      $contatos = contatos::all();
      return view('admin.index')->with('contatos', $contatos);
    }

    public function user_edit($id){
      $contato = Contatos::find($id);
      return view('admin.useredit')->with('contato', $contato);;
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
      $user->save();

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
      } else{
        $valor="1";
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
      } else{
        $contato->user->perms["admin"]=1;
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
      return view('admin.update')->with('manifest', $manifest)->with('remoto', $remoto);
    }

    public function update_do(){
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
      $pathToFile = storage_path('backups').'/'.$file.'.zip';
      return response()->download($pathToFile);
    }
    public function backup_do(){
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

}
