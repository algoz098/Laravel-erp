<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Telefones;

class Contatos extends Model
{
    protected $table = 'contatos';

    public function telefones()
    {
        return $this->hasMany('App\Telefones');
    }

    public function from()
    {
      return $this->belongsToMany('App\Contatos', 'contatos_pivot', 'from_id', 'to_id')->withPivot('from_text', 'to_text', 'id');
    }

    public function to()
    {
      return $this->belongsToMany('App\Contatos', 'contatos_pivot', 'to_id', 'from_id')->withPivot('to_text', 'from_text', 'id');
    }
}
