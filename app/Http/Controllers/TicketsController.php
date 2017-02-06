<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tickets as Tickets;
use App\Contatos as Contatos;

class TicketsController extends BaseController
{
  public function __construct(){
     parent::__construct();
  }

  public function index(){
    $tickets=Tickets::all();
    return view('tickets.index')
                ->with('tickets', $tickets);
  }
  public function novo(){
    $contatos=Contatos::all();
    return view('tickets.novo')->with("contatos",$contatos);
  }
  public function novo_2($id){
    $contato=Contatos::find($id);
    return view('tickets.novo_2')->with("contato",$contato);
  }


    //
}
