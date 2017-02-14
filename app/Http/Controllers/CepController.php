<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CepController extends Controller
{
  public function buscacep($cep)
  {
    $json = file_get_contents('http://ceps.webgs.com.br/cep/'.$cep);

    return $json;
  }
}
