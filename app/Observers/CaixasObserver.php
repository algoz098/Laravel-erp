<?php

namespace App\Observers;

use App\Caixas;
use Auth;

class CaixasObserver
{

    public function creating(Caixas $contato)
    {
      if (!isset(Auth::user()->perms["caixas"]["adicao"]) or Auth::user()->perms["caixas"]["adicao"]!=1){
        return false;
      }
    }
    public function deleting(Caixas $user)
    {
      if (!isset(Auth::user()->perms["caixas"]["edicao"]) or Auth::user()->perms["caixas"]["edicao"]!=1){
        return false;
      }
    }
    public function restoring(Caixas $user)
    {
      if (!isset(Auth::user()->perms["caixas"]["edicao"]) or Auth::user()->perms["caixas"]["edicao"]!=1){
        return false;
      }
    }
    public function updating(Caixas $user)
    {
      if (!isset(Auth::user()->perms["caixas"]["edicao"]) or Auth::user()->perms["caixas"]["edicao"]!=1){
        return false;
      }
    }
}
