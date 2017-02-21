<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tickets as Tickets;
use App\Contatos as Contatos;
use App\Andamentos as Andamentos;
use Log;
use Auth;
use Redirect;
use Carbon\Carbon;

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
    return view('tickets.novo');
  }
  public function salvar(request $request){
    $ticket=new Tickets;
    $ticket->contatos_id= $request->contatos_id;
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

    return view('tickets.novo')->with('ticket', $ticket);
  }
  public function editar_salvar($id, request $request){
    $ticket = Tickets::find($id);
    Log::info('Mostando ticket -> "'.$ticket.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    $ticket->status=$request->status;
    $ticket->descricao=$request->descricao;
    $ticket->save();
    return redirect()->action('TicketsController@index');
  }
  public function andamento($id){
    $ticket = Tickets::find($id);
    if($ticket->status=="Resolvido"){
      return Redirect::back()->withErrors(['O ticket já está resolvido.']);
    }
    Log::info('Adicionando andamento -> "'.$ticket.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    return view('tickets.andamento')->with('ticket', $ticket);
  }

  public function andamento_salvar($id, request $request){
    Log::info('Adicionando andamento -> , para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    if($request->estado=="Resolvido"){
      $ticket=tickets::find($id);
      $ticket->status=$request->estado;
      $ticket->solucao=$request->descricao;
      $ticket->save();

    }
    else{
      $andamento=new andamentos;
      $andamento->tickets_id=$id;
      $andamento->titulo=$request->titulo;
      $andamento->data=$request->data;
      $andamento->descricao=$request->descricao;
      $andamento->estado=$request->estado;
      $andamento->save();
    }

    return redirect()->action('TicketsController@index');
  }
    //
}
