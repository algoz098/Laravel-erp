<?php

namespace App\Observers;

use App\Frotas;
use Auth;

class FrotasObserver
{

    public function creating(Frotas $contato)
    {
      if (!isset(Auth::user()->perms["frotas"]["adicao"]) or Auth::user()->perms["frotas"]["adicao"]!=1){
        return false;
      }
    }
    public function deleting(Frotas $user)
    {
      if (!isset(Auth::user()->perms["frotas"]["edicao"]) or Auth::user()->perms["frotas"]["edicao"]!=1){
        return false;
      }
    }
    public function restoring(Frotas $user)
    {
      if (!isset(Auth::user()->perms["frotas"]["edicao"]) or Auth::user()->perms["frotas"]["edicao"]!=1){
        return false;
      }
    }
    public function updating(Frotas $user)
    {
      if (!isset(Auth::user()->perms["frotas"]["edicao"]) or Auth::user()->perms["frotas"]["edicao"]!=1){
        return false;
      }
    }
}
