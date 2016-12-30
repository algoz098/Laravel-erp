<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachments extends Model
{
  use SoftDeletes;
  public function anex()
  {
      return $this->morphTo();
  }
}
