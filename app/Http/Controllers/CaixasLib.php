<?php
namespace App\Http\Controllers;
Use Carbon\Carbon;
use Auth;
use App\Caixas as Caixas;

class CaixasLib {
  public function isOpen() {
    $abertura = Caixas::whereRaw('date(created_at) = ?', [Carbon::today()])
                    ->orderBy('created_at', 'aaaa')
                    ->where('filial_id', Auth::user()->trabalho_id)
                    ->where('tipo', '0')
                    ->first();
    $fechamento = Caixas::whereRaw('date(created_at) = ?', [Carbon::today()])
                    ->orderBy('created_at', 'aaaa')
                    ->where('filial_id', Auth::user()->trabalho_id)
                    ->where('tipo', '1')
                    ->first();

    if (!is_null($abertura) and is_null($fechamento)){
      return true;
    }
    if (strtotime($abertura->created_at) > strtotime($fechamento->created_at)){
      return true;
    }
    return false;
  }

  public function isClosed() {
    $abertura = Caixas::whereRaw('date(created_at) = ?', [Carbon::today()])
                    ->orderBy('created_at', 'aaaa')
                    ->where('filial_id', Auth::user()->trabalho_id)
                    ->where('tipo', '0')
                    ->first();
    $fechamento = Caixas::whereRaw('date(created_at) = ?', [Carbon::today()])
                    ->orderBy('created_at', 'aaaa')
                    ->where('filial_id', Auth::user()->trabalho_id)
                    ->where('tipo', '1')
                    ->first();

    if (!is_null($fechamento) and is_null($abertura)){
      return true;
    }
    if (!is_null($abertura)){
      if (strtotime($abertura->created_at) < strtotime($fechamento->created_at)){
        return true;
      }
    }
    return false;
  }
}
