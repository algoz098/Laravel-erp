<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contatos;
use App\Produtos;

class Estoque extends Model
{
  use SoftDeletes;
  protected $table = 'estoque';

  public function contato()
  {
    return $this->belongsTo('App\Contatos', 'contatos_id');
  }
  public function produto()
  {
    return $this->belongsTo('App\Produtos', 'produtos_id');
  }
  public function attachs()
  {
      return $this->morphMany('App\Attachments', 'attachmentable');
  }
}
