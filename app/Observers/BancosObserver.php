<?php

namespace App\Observers;

use App\Bancos;
use Auth;

class BancosObserver
{

    public function creating(Bancos $contato)
    {
      if (!isset(Auth::user()->perms["bancos"]["adicao"]) or Auth::user()->perms["bancos"]["adicao"]!=1){
        return false;
      }
    }
    public function deleting(Bancos $user)
    {
      if (!isset(Auth::user()->perms["bancos"]["edicao"]) or Auth::user()->perms["bancos"]["edicao"]!=1){
        return false;
      }
    }
    public function restoring(Bancos $user)
    {
      if (!isset(Auth::user()->perms["bancos"]["edicao"]) or Auth::user()->perms["bancos"]["edicao"]!=1){
        return false;
      }
    }
    public function updating(Bancos $user)
    {
      if (!isset(Auth::user()->perms["bancos"]["edicao"]) or Auth::user()->perms["bancos"]["edicao"]!=1){
        return false;
      }
    }
}
