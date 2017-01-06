<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Movs;

class Movs_prestacao extends Model
{
    protected $table = 'movs_prestacao';
    public function mov()
    {
        return $this->belongsTo('App\Movs', 'movs_id');
    }
}
