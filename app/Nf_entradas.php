<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Nf_produtos;
use App\Contatos;

class Nf_entradas extends Model
{
  public function filial()
  {
      return $this->belongsTo('App\Contatos', 'filiais_id');
  }
  public function fornecedor()
  {
      return $this->belongsTo('App\Contatos', 'fornecedor_id');
  }
  public function criador()
  {
      return $this->belongsTo('App\Contatos', 'criado_por');
  }
  public function nf_produtos()
  {
      return $this->hasMany('App\Nf_produtos', 'notas_id');
  }
}
