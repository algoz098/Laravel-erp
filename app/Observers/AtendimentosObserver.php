<?php

namespace App\Observers;

use App\Atendimento;
use Auth;

class AtendimentosObserver
{

    public function creating(Atendimento $contato)
    {
      if (!isset(Auth::user()->perms["atendimentos"]["adicao"]) or Auth::user()->perms["atendimentos"]["adicao"]!=1){
        return false;
      }
    }
    public function deleting(Atendimento $user)
    {
      if (!isset(Auth::user()->perms["atendimentos"]["edicao"]) or Auth::user()->perms["atendimentos"]["edicao"]!=1){
        return false;
      }
    }
    public function restoring(Atendimento $user)
    {
      if (!isset(Auth::user()->perms["atendimentos"]["edicao"]) or Auth::user()->perms["atendimentos"]["edicao"]!=1){
        return false;
      }
    }
    public function updating(Atendimento $user)
    {
      if (!isset(Auth::user()->perms["atendimentos"]["edicao"]) or Auth::user()->perms["atendimentos"]["edicao"]!=1){
        return false;
      }
    }
}
