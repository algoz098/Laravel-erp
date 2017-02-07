<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tickets as Tickets;
use App\Contatos as Contatos;
use Log;
use Auth;

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
  public function detalhes($id){
    $ticket=Tickets::find($id);
    return view('tickets.detalhes')->with("ticket", $ticket);
  }
  public function novo(){
    $contatos=Contatos::paginate(15);
    return view('tickets.novo')->with("contatos",$contatos);
  }
  public function novo_2($id){
    $contato=Contatos::find($id);
    return view('tickets.novo_2')->with("contato",$contato);
  }
  public function salvar($id, request $request){
    $ticket=new Tickets;
    $ticket->contatos_id=$id;
    $ticket->status=$request->status;
    $ticket->descricao=$request->descricao;
    $ticket->save();
    return redirect()->action('TicketsController@index');
  }
  public function delete($id){
    $ticket = Tickets::withTrashed()->find($id);
    Log::info('Deletando Ticket -> "'.$ticket.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    if ($ticket->trashed()) {
      $ticket->restore();
    } else {
      $ticket->delete();
    }
    return redirect()->action('TicketsController@index');
  }

  public function editar($id){
    $ticket = Tickets::find($id);
    Log::info('Mostando ticket -> "'.$ticket.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return view('tickets.editar')->with('ticket', $ticket);
  }
  public function editar_salvar($id, request $request){
    $ticket = Tickets::find($id);
    Log::info('Mostando ticket -> "'.$ticket.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $ticket->status=$request->status;
    $ticket->descricao=$request->descricao;
    $ticket->save();
    return redirect()->action('TicketsController@index');
  }
    //
}
