<?php

namespace App\Observers;

use App\Contas;
use Auth;

class ContasObserver
{

    public function creating(Contas $contato)
    {
      if (!isset(Auth::user()->perms["contas"]["adicao"]) or Auth::user()->perms["contas"]["adicao"]!=1){
        return false;
      }
    }
    public function deleting(Contas $user)
    {
      if (!isset(Auth::user()->perms["contas"]["edicao"]) or Auth::user()->perms["contas"]["edicao"]!=1){
        return false;
      }
    }
    public function restoring(Contas $user)
    {
      if (!isset(Auth::user()->perms["contas"]["edicao"]) or Auth::user()->perms["contas"]["edicao"]!=1){
        return false;
      }
    }
    public function updating(Contas $user)
    {
      if (!isset(Auth::user()->perms["contas"]["edicao"]) or Auth::user()->perms["contas"]["edicao"]!=1){
        return false;
      }
    }
}
