<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estoque_campos extends Model
{
  public function estoque()
  {
      return $this->belongsTo('App\Estoque', 'estoque_id');
  }
}
