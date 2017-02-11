<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contatos;
use Illuminate\Database\Eloquent\SoftDeletes;

class Frotas extends Model
{
  use SoftDeletes;
  public function contato()
  {
      return $this->belongsTo('App\Contatos', 'contatos_id');
  }
  public function attachs()
  {
      return $this->morphMany('App\Attachments', 'attachmentable');
  }
}
