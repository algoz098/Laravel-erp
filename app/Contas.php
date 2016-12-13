<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contatos;

class Contas extends Model
{
  use SoftDeletes;
  protected $table = 'contas';
  protected $dates = ['deleted_at'];

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
