<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Telefones;
use App\Atendimento;
use App\Contas;
use App\Estoque;
use App\Attachments;
use App\Caixas;
use App\Vendas;
use App\Funcionarios;
use App\Frotas;

class Contatos extends Model
{
    use SoftDeletes;
    protected $table = 'contatos';
    protected $dates = ['deleted_at'];

    public function telefones()
    {
        return $this->hasMany('App\Telefones');
    }
    public function caixas()
    {
        return $this->hasMany('App\Caixas', 'filial_id');
    }

    public function atendimento()
    {
      return $this->hasMany('App\Atendimento');
    }

    public function from()
    {
      return $this->belongsToMany('App\Contatos', 'contatos_pivot', 'from_id', 'to_id')->withPivot('from_text', 'to_text', 'id');
    }

    public function to()
    {
      return $this->belongsToMany('App\Contatos', 'contatos_pivot', 'to_id', 'from_id')->withPivot('to_text', 'from_text', 'id');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function contas()
    {
      return $this->hasMany('App\Contas');
    }

    public function estoque()
    {
      return $this->hasMany('App\Estoque');
    }

    public function vendas()
    {
      return $this->hasMany('App\Vendas', 'funcionario_id');
    }

    public function attachsToo()
    {
        return $this->hasMany('App\Attachments', 'contatos_id');
    }

    public function attachs()
    {
        return $this->morphMany('App\Attachments', 'attachmentable');
    }

    public function funcionario()
    {
        return $this->hasOne('App\Funcionarios');
    }
    public function tickets()
    {
      return $this->hasMany('App\Tickets');
    }
    public function frotas()
    {
        return $this->hasMany('App\Frotas');
    }
}
