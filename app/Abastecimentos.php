<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contatos;
use App\frotas;
use App\Contas;
use Illuminate\Database\Eloquent\SoftDeletes;

class abastecimentos extends Model
{
  use SoftDeletes;
  public function por()
  {
      return $this->belongsTo('App\Contatos', 'abastecido_por');
  }
  public function em()
  {
      return $this->belongsTo('App\Contatos', 'abastecido_em');
  }
  public function frota()
  {
      return $this->belongsTo('App\Frotas', 'frotas_id');
  }
  public function conta()
  {
      return $this->belongsTo('App\Contas', 'contas_id');
  }
}
