<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Produtos;
class Estoque_campos extends Model
{
  public function produto()
  {
      return $this->belongsTo('App\Produtos', 'estoque_id');
  }
}
