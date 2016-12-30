<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Estoque;
use App\Vendas;

class Est_movimentacoes extends Model
{
  use SoftDeletes;
  public function venda()
  {
      return $this->belongsTo('App\Vendas', 'vendas_id');
  }
  public function estoque()
  {
      return $this->belongsTo('App\Estoque', 'estoque_id');
  }
}
