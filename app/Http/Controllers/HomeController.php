<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contatos as contatos;
use App\Funcionarios as Funcionarios;
use App\Contas as Contas;
use Carbon\Carbon;
use Log;
use Auth;

class HomeController  extends BaseController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      parent::__construct();
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
      Log::info('Vendo dashboard, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

      return view('dashboard.index')->with('contatos', $contatos)->with('funcionarios', $funcionarios)->with('contas', $contas);
    }
}
