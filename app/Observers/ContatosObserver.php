<?php

namespace App\Observers;

use App\Contatos;
use Auth;

class ContatosObserver
{

    public function creating(Contatos $contato)
    {
      if (!isset(Auth::user()->perms["contatos"]["adicao"]) or Auth::user()->perms["contatos"]["adicao"]!=1){
        return false;
      }
    }
    public function deleting(Contatos $user)
    {
      if (!isset(Auth::user()->perms["contatos"]["edicao"]) or Auth::user()->perms["contatos"]["edicao"]!=1){
        return false;
      }
    }
    public function restoring(Contatos $user)
    {
      if (!isset(Auth::user()->perms["contatos"]["edicao"]) or Auth::user()->perms["contatos"]["edicao"]!=1){
        return false;
      }
    }
    public function updating(Contatos $user)
    {
      if (!isset(Auth::user()->perms["contatos"]["edicao"]) or Auth::user()->perms["contatos"]["edicao"]!=1){
        return false;
      }
    }
}
