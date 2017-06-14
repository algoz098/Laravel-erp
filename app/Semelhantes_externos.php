<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Produtos;

class Semelhantes_externos extends Model
{
  public function produto()
  {
    return $this->belongsTo('App\Produtos', 'produtos_id');
  }
}
