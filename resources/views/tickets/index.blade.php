@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-book fa-1x"></i> Lista de Tickets
        </div>
        <div class="panel-body">
          <div class="row" id="secondNavbar">
            Ferramentas
          </div>
          <div class="row">
            @foreach ($tickets as $key => $ticket)
              <div class="row list-contacts">
                <div class="col-md-1">
                  {{$ticket->id}}
                </div>
                <div class="col-md-2">
                  {{$ticket->contato->nome}}
                </div>
                <div class="col-md-2">
                  {{$ticket->solucao}}
                </div>
                <div class="col-md-7">
                  {{$ticket->descricao}}
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
