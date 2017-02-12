<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contatos;
use App\frotas;
use Illuminate\Database\Eloquent\SoftDeletes;

class Abastecimentos extends Model
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
}
