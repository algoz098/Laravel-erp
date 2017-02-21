<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contatos;
use App\Estoque_campos;

class Estoque extends Model
{
  use SoftDeletes;
  protected $table = 'estoque';

  public function contato()
  {
    return $this->belongsTo('App\Contatos', 'contatos_id');
  }
  public function campos()
  {
    return $this->hasMany('App\Estoque_campos');
  }
  public function attachs()
  {
      return $this->morphMany('App\Attachments', 'attachmentable');
  }
}
