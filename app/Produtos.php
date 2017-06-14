<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Estoque;
use App\Campos;
use App\Produtos_tipos;
use App\Contatos;
use App\Semelhantes_externos;

class Produtos extends Model
{
  use SoftDeletes;
  public function semelhantes_from()
  {
    return $this->belongsToMany('App\Produtos', 'produtos_semelhantes', 'produtos_id_1', 'produtos_id_2');
  }
  public function semelhantes_to()
  {
    return $this->belongsToMany('App\Produtos', 'produtos_semelhantes', 'produtos_id_2', 'produtos_id_1');
  }
  public function armazenagens()
  {
    return $this->belongsToMany('App\Contatos', 'armazenagens', 'produtos_id', 'filiais_id')->withPivot('local');
  }
  public function campos()
  {
    return $this->hasMany('App\Estoque_campos', 'estoque_id');
  }
  public function estoques()
  {
    return $this->hasMany('App\Estoque');
  }
  public function externos()
  {
    return $this->hasMany('App\Semelhantes_externos');
  }
  public function fabricante()
  {
    return $this->belongsTo('App\Contatos', 'fabricante_id');
  }
  public function tipo()
  {
    return $this->belongsTo('App\Produtos_tipos', 'produtos_tipo_id');
  }
}
