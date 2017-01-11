<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contas;

class Discriminacoes extends Model
{
  public function conta()
  {
      return $this->belongsTo('App\Contas');
  }
}
