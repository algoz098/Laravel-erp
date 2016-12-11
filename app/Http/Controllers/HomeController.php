<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contatos as contatos;
use App\Funcionarios as Funcionarios;
use App\Contas as Contas;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $contatos = contatos::all();
      $funcionarios = Funcionarios::all();
      $contas = Contas::all();
      return view('dashboard.index')->with('contatos', $contatos)->with('funcionarios', $funcionarios)->with('contas', $contas);
    }
}
