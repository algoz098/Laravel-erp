<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefones extends Model
{
    protected $table = 'telefones';

    public function contatos()
    {
        return $this->belongsTo('App\Contatos');
    }
}
