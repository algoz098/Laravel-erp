<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Estoque;
use App\Campos;
use App\Produtos_tipos;
use App\Contatos;

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
  public function fabricante()
  {
    return $this->belongsTo('App\Contatos', 'fabricante_id');
  }
  public function tipos()
  {
    return $this->belongsTo('App\Produtos_tipos', 'produtos_tipo_id');
  }
}
