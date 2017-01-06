<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contatos;
use App\Vendas;

class Caixas extends Model
{
    use SoftDeletes;

    public function filial()
    {
        return $this->belongsTo('App\Contatos', 'filial_id');
    }

    public function funcionario()
    {
        return $this->belongsTo('App\Contatos', 'funcionario_id');
    }

    public function movs()
    {
        return $this->hasMany('App\Movs', 'caixas_id');
    }
}
