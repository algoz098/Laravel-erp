<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contatos;

class Contas extends Model
{
  protected $table = 'contas';

  public function contatos()
  {
      return $this->belongsTo('App\Contatos');
  }

  public function parcelas()
  {
      return $this->hasMany('App\Contas', 'referente');
  }

  public function referencia()
  {
      return $this->belongsTo('App\Contas', 'referente');
  }
}
