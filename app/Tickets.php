<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Contatos;

class Tickets extends Model
{
    use SoftDeletes;

    public function contato()
    {
        return $this->belongsTo('App\Contatos', 'contatos_id');
    }
}
