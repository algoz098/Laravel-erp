<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Contatos;
use App\Attachments;

class Bancos extends Model
{
  use SoftDeletes;

  public function filial()
  {
      return $this->belongsTo('App\Contatos', 'filial_id');
  }
  public function contas()
  {
    return $this->hasMany('App\Contas', 'bancos_id');
  }
  public function banco()
  {
    return $this->belongsTo('App\Contatos', 'contatos_id');
  }
  public function attachs()
  {
    return $this->morphMany('App\Attachments', 'attachmentable');
  }
}
