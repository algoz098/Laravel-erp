<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contatos;
use App\Discriminacoes;

class Contas extends Model
{
  use SoftDeletes;
  protected $table = 'contas';
  protected $dates = ['deleted_at'];

  public function contatos()
  {
      return $this->belongsTo('App\Contatos');
  }
  public function attachs()
  {
      return $this->morphMany('App\Attachments', 'attachmentable');
  }
  public function consumo()
  {
      return $this->hasOne('App\Contas_consumos');
  }
  public function parcelas()
  {
      return $this->hasMany('App\Contas', 'referente');
  }
  public function discs()
  {
      return $this->hasMany('App\Discriminacoes');
  }

  public function referencia()
  {
      return $this->belongsTo('App\Contas', 'referente');
  }
}
