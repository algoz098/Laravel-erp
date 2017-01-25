<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Combobox_texts extends Model
{
  use SoftDeletes;
  public function used()
  {
      return $this->morphTo();
  }
}
