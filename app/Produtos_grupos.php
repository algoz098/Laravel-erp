<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Produtos_tipos;

class Produtos_grupos extends Model
{
  public function tipos()
  {
    return $this->hasMany('App\Produtos_tipos', 'produtos_grupos_id');
  }
}
