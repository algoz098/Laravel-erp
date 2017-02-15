@extends('main')
@section('content')
  <form method="POST" action="{{url('lista/tickets')}}/{{$ticket->id}}/andamento">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading ">
            <i class="fa fa-file-text-o fa-1x"></i> Adicionar andamento de Tickets
          </div>
          <div class="panel-body">
            <div class="row" id="secondNavbar">
              <div class="col-md-1 pull-right text-right">
                  <button type="submit" class="btn btn-success">
                    <i class="fa fa-check"></i> Salvar
                  </button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="contato">Contato:</label>
                  <input type="text" value="{{$ticket->contato->nome}}" disabled class="form-control" id="contato">
                </div>
                <div class="form-group">
                  <label for="Titulo">Ticket:</label>
                  <input type="text" value="{{str_limit(strip_tags($ticket->descricao),45)}}" disabled class="form-control" id="ticket">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="contato">Data:</label>
                  <input type="text" value="" class="form-control datepicker" id="data" name="data" >
                </div>
                <div class="form-group">
                  <label for="contato">Titulo:</label>
                  <input type="text" value="" class="form-control" id="titulo" name="titulo" >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-10">
                <div class="form-group">
                  <label for="Descricao">Descrição:</label>
                  <textarea  name="descricao">
                  </textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection
