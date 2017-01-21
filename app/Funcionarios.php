<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contatos;

class Funcionarios extends Model
{
    protected $table = 'funcionarios';

    public function contato()
    {
        return $this->belongsTo('App\Contatos');
    }
}
