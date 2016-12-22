<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
  public function anex()
  {
      return $this->morphTo();
  }
}
