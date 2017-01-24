<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contas_consumos extends Model
{
  public function contas()
  {
      return $this->belongsTo('App\Contas');
  }
}
