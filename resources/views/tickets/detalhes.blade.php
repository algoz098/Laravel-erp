<div class="modal-dialog  modal-lg extra" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="addTelefonesLabel">Detalhes Ticket: {{$ticket->id}}</h4>
    </div>
    <div class="modal-body">
      <div class="row text-center">
        <div class="col-md-4">
          <div class="form-group">
            <label for="Estado">Estado:</label>
            <div>{{$ticket->status}}</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="contato">Contato:</label>
            <div>{{$ticket->contato->nome}}</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="Data">Data:</label>
            <div>{{date('H:i d/m/Y', strtotime($ticket->created_at))}}</div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="Descricao">Descrição:</label>
            <div>{!!$ticket->descricao!!}</div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="Descricao">Andamentos:</label>
            @foreach ($ticket->andamentos as $key => $andamento)
              <div class="row list-contacts" >
                <div class="col-md-2">
                  <span class="label label-info">
                    {{$andamento->data}}
                  </span>
                </div>
                <div class="col-md-2">
                  <span class="label label-info">
                    {{$andamento->titulo}}
                  </span>
                </div>
                <div class="col-md-8 panel-collapse collapse in">
                  <button class="btn btn-success btn-xs" data-toggle="collapse" data-target="#descricao{{$andamento->id}}" aria-expanded="" aria-controls="descricao{{$andamento->id}}">
                    Ver mais
                  </button>
                </div>
              </div>
              <div class="collapse" id="descricao{{$andamento->id}}">
                <br>
                <div class="well">
                  {!!$andamento->descricao!!}
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="Solucao">Solução:</label>
            <div>{!!$ticket->solucao!!}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      <a href="{{ url('novo/tickets') }}/{{$ticket->id}}/edit"><button type="submit" class="btn btn-primary">Editar</button></a>
    </div>
  </div>
</div>
