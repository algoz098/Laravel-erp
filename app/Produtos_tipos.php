<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Produtos_grupos;
use App\Produtos;

class Produtos_tipos extends Model
{
  public function grupo()
  {
    return $this->belongsTo('App\Produtos_grupos', 'produtos_grupos_id');
  }
  public function produtos()
  {
    return $this->hasMany('App\Produtos', 'produtos_tipo_id');
  }
}
