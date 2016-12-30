<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Est_movimentacoes;
use App\Contatos;

class Vendas extends Model
{
    use SoftDeletes;

    public function movs()
    {
        return $this->hasMany('App\Est_movimentacoes');
    }
    public function funcionario()
    {
        return $this->belongsTo('App\Contatos', 'funcionario_id');
    }
    public function comprador()
    {
        return $this->belongsTo('App\Contatos', 'comprador_id');
    }
}
