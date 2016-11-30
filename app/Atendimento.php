<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contatos;

class Atendimento extends Model
{
  protected $table = 'atendimentos';

  public function contatos()
  {
      return $this->belongsTo('App\Contatos');
  }
}
