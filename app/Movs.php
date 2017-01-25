<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Caixas;
use App\Movs_prestacao;
class Movs extends Model
{
  public function funcionario()
  {
      return $this->belongsTo('App\Caixas', 'Caixas_id');
  }
  public function prestacoes()
  {
      return $this->hasMany('App\Movs_prestacao', 'movs_id');
  }
}
