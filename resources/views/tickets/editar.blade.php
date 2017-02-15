@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-book"></i> Adicionar Ticket</div>
    <form method="POST" action="{{url('novo/tickets')}}/{{$ticket->id}}/edit">
      {{csrf_field()}}
      <div class="panel-body">
        <div class="row" id="secondNavbar">
          <div class="col-md-4 pull-right text-right">
            <a href="{{url('lista/tickets')}}" class="btn btn-warning"><i class="fa fa-book"></i> Voltar a lista</a>
            <a href="{{url('novo/tickets')}}" class="btn btn-warning"><i class="fa fa-book"></i> Voltar a seleção</a>
            <button class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="form-group">
                  <label for="contato">Contato:</label>
                  <input type="text" value="{{$ticket->contato->nome}}" disabled class="form-control" id="contato">
                </div>
                <div class="form-group">
                  <label for="Status">Estado:</label>
                  <select class="form-control" name="status" id="status">
                    <option selected value="{{$ticket->status}}">{{$ticket->status}}</option>
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
                    {!!$ticket->descricao!!}
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
