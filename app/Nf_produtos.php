<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Nf_entradas;
use App\Produtos;

class Nf_produtos extends Model
{
  public function nf()
  {
      return $this->belongsTo('App\Nf_entradas', 'notas_id');
  }
  public function produto()
  {
      return $this->belongsTo('App\Produtos', 'produtos_id');
  }
}
