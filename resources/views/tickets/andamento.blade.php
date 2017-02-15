@extends('main')
@section('content')
  <form method="POST" action="{{url('novo/tickets')}}/{{$ticket->id}}/andamento">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading ">
            <i class="fa fa-file-text-o fa-1x"></i> Adicionar andamento de Tickets
          </div>
          <div class="panel-body">
            <div class="row" id="secondNavbar">
              <div class="col-md-1 pull-right text-right">
                  <button class="btn btn-success"><i class="fa fa-check"></i> Novo</a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="contato">Contato:</label>
                  <input type="text" value="{{$ticket->contato->nome}}" disabled class="form-control" id="contato">
                </div>
                <div class="form-group">
                  <label for="Titulo">Titulo:</label>
                  <input type="text" value="{{str_limit(strip_tags($ticket->descricao),45)}}" disabled class="form-control" id="contato">
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection
