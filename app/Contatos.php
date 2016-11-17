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
}
