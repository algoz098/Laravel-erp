<?php

namespace App\Observers;

use App\Vendas;
use Auth;

class VendasObserver
{

    public function creating(Vendas $contato)
    {
      if (!isset(Auth::user()->perms["vendas"]["adicao"]) or Auth::user()->perms["vendas"]["adicao"]!=1){
        return false;
      }
    }
    public function deleting(Vendas $user)
    {
      if (!isset(Auth::user()->perms["vendas"]["edicao"]) or Auth::user()->perms["vendas"]["edicao"]!=1){
        return false;
      }
    }
    public function restoring(Vendas $user)
    {
      if (!isset(Auth::user()->perms["vendas"]["edicao"]) or Auth::user()->perms["vendas"]["edicao"]!=1){
        return false;
      }
    }
    public function updating(Vendas $user)
    {
      if (!isset(Auth::user()->perms["vendas"]["edicao"]) or Auth::user()->perms["vendas"]["edicao"]!=1){
        return false;
      }
    }
}
