<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contatos as contatos;
use App\Funcionarios as Funcionarios;
use App\Contas as Contas;
use App\Atendimento as Atendimento;
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
      if (isset(Auth::user()->perms["contatos"]["leitura"]) and Auth::user()->perms["contatos"]["leitura"]==1){
        $contatos = contatos::all();
        $funcionarios = Funcionarios::all();
      } else {
        $contatos = 0;
        $funcionarios = 0;
      }
      if (isset(Auth::user()->perms["atendimentos"]["leitura"]) and Auth::user()->perms["atendimentos"]["leitura"]==1){
        $atendimentos = Atendimento::select('contatos_id', 'created_at')
        ->get()
        ->groupBy(function($date) {
          return Carbon::parse($date->created_at)->format('m'); // grouping by years
          //return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });
      } else {
        $atendimentos = 0;
      }
      if (isset(Auth::user()->perms["contas"]["leitura"]) and Auth::user()->perms["contas"]["leitura"]==1){
        $contas = Contas::all();
      } else {
        $contas = 0;
      }
      Log::info('Vendo dashboard, para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

      return view('dashboard.index')->with('contatos', $contatos)
                                    ->with('funcionarios', $funcionarios)
                                    ->with('atendimentos', $atendimentos)
                                    ->with('contas', $contas);
    }
}
