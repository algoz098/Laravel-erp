<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contatos as contatos;
use App\Funcionarios as Funcionarios;

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
      return view('dashboard.index')->with('contatos', $contatos)->with('funcionarios', $funcionarios);
    }
}
