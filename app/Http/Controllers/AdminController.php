<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as User;
use App\Contatos as Contatos;
use App\Users_permissions as Roles;

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
}
