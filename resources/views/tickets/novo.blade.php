@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-book"></i> Adicionar Ticket</div>
    @if(isset($ticket))
      <form method="POST" action="{{url('novo/tickets')}}/{{$ticket->id}}/edit">
    @else
      <form method="POST" action="{{url('novo/tickets')}}">
    @endif
      {{csrf_field()}}
      <div class="panel-body">
        <div class="row" id="secondNavbar">
          <div class="col-md-4 pull-right text-right">
            @botaoLista(tickets*fa-book)
            @botaoSalvar
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="panel panel-default">
              <div class="panel-body">
                @if (isset($ticket))
                  @selecionaContato(Contato:*$ticket->contato->id*$ticket->contato->nome)
                @else
                  @selecionaContato(Contato:)
                @endif
                <div class="form-group">
                  <label for="Status">Estado:</label>
                  <select class="form-control" name="status" id="status" >
                    @if (isset($ticket))
                      <option value="{{$ticket->status}}" selected>{{$ticket->status}} (Atual)</option>
                    @else
                      <option selected>Aberto</option>
                    @endif
                    <option value="Aberto">Aberto</option>
                    <option value="Respondido">Respondido</option>
                    <option value="Em processo">Em processo</option>
                    <option value="Atendido">Atendido</option>
                    <option value="Concluido">Concluido</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="form-group">
                  <label for="Descricao">Descrição:</label>
                  <textarea  name="descricao">
                    {{isset($ticket->descricao)?$ticket->descricao:""}}
                  </textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection
