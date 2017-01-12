<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contatos;

class Atendimento extends Model
{
  protected $table = 'atendimentos';

  use SoftDeletes;

  public function contatos()
  {
      return $this->belongsTo('App\Contatos');
  }
  public function attachs()
  {
      return $this->morphMany('App\Attachments', 'attachmentable');
  }
}
