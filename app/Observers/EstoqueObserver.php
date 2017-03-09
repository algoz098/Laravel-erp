<?php

namespace App\Observers;

use App\Estoque;
use Auth;

class EstoqueObserver
{

    public function creating(Estoque $contato)
    {
      if (!isset(Auth::user()->perms["estoque"]["adicao"]) or Auth::user()->perms["estoque"]["adicao"]!=1){
        return false;
      }
    }
    public function deleting(Estoque $user)
    {
      if (!isset(Auth::user()->perms["estoque"]["edicao"]) or Auth::user()->perms["estoque"]["edicao"]!=1){
        return false;
      }
    }
    public function restoring(Estoque $user)
    {
      if (!isset(Auth::user()->perms["estoque"]["edicao"]) or Auth::user()->perms["estoque"]["edicao"]!=1){
        return false;
      }
    }
    public function updating(Estoque $user)
    {
      if (!isset(Auth::user()->perms["estoque"]["edicao"]) or Auth::user()->perms["estoque"]["edicao"]!=1){
        return false;
      }
    }
}
