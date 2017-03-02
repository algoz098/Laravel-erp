<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contatos;

class Bancos extends Model
{
  use SoftDeletes;

  public function contato()
  {
      return $this->belongsTo('App\Contatos', 'contatos_id');
  }
  public function contas()
  {
    return $this->hasMany('App\Contas', 'bancos_id');
  }
}
