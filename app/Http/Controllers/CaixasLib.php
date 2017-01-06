<?php
namespace App\Http\Controllers;
Use Carbon\Carbon;
use Auth;
use App\Caixas as Caixas;
use App\Movs as Movs;

class CaixasLib {
  public function isOpen() {
    $abertura = Caixas::whereRaw('date(created_at) = ?', [Carbon::today()])
                    ->orderBy('created_at', 'aaaa')
                    ->where('filial_id', Auth::user()->trabalho_id)
                    ->where('estado', '0')
                    ->first();

    if (!is_null($abertura)){
      return true;
    }
    return false;
  }

  public function isClosed() {
    $abertura = Caixas::whereRaw('date(created_at) = ?', [Carbon::today()])
                    ->orderBy('created_at', 'aaaa')
                    ->where('filial_id', Auth::user()->trabalho_id)
                    ->where('estado', '1')
                    ->first();

    if (!is_null($abertura)){
      return true;
    }
    return false;
  }

  public function myCaixas() {
    $abertura = Caixas::whereRaw('date(created_at) = ?', [Carbon::today()])
                    ->orderBy('created_at', 'aaaa')
                    ->where('filial_id', Auth::user()->trabalho_id)
                    ->first();
    return $abertura;
  }
}
