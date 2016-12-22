<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contatos;

class Estoque extends Model
{
  use SoftDeletes;
  protected $table = 'estoque';

  public function contato()
  {
    return $this->belongsTo('App\Contatos', 'contatos_id');
  }
}
