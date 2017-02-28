<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Estoque;
use App\Campos;

class Produtos extends Model
{
  public function campos()
  {
    return $this->hasMany('App\Estoque_campos', 'estoque_id');
  }
  public function estoques()
  {
    return $this->hasMany('App\Estoque');
  }
}
