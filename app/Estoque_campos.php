<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Produtos;
class Estoque_campos extends Model
{
  use SoftDeletes;
  public function produto()
  {
      return $this->belongsTo('App\Produtos', 'estoque_id');
  }
}
