<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Tickets;

class Andamentos extends Model
{
  use SoftDeletes;

  public function ticket()
  {
    return $this->belongsTo('App\Tickets', 'tickets_id');
  }
}
