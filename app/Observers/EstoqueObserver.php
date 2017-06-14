<?php

namespace App\Observers;

use App\Estoque;
use Auth;

class EstoqueObserver
{

    public function creating(Estoque $contato)
    {
      if (!isset(Auth::user()->perms["estoques"]["adicao"]) or Auth::user()->perms["estoques"]["adicao"]!=1){
        return false;
      }
    }
    public function deleting(Estoque $user)
    {
      if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
        return false;
      }
    }
    public function restoring(Estoque $user)
    {
      if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
        return false;
      }
    }
    public function updating(Estoque $user)
    {
      if (!isset(Auth::user()->perms["estoques"]["edicao"]) or Auth::user()->perms["estoques"]["edicao"]!=1){
        return false;
      }
    }
}
