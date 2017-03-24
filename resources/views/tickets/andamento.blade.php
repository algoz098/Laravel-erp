<?php
  use Carbon\Carbon;
?>
<div class="modal-dialog  modal-lg extra" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="addTelefonesLabel">Detalhes Ticket: {{$ticket->id}}</h4>
    </div>
    <div class="modal-body">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="Contato">Contato:</label>
            <input type="text" value="{{$ticket->contato->nome}}" disabled class="form-control" id="contato">
          </div>
          <div class="form-group">
            <label for="Ticket">Ticket:</label>
            <input type="text" value="{{str_limit(strip_tags($ticket->descricao),45)}}" disabled class="form-control" id="ticket">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="Data">Data:</label>
            <input type="text" class="form-control" name="data" value="{{Carbon::now()}}" id="datepicker">
          </div>
          <div class="form-group">
            <label for="Titulo">Titulo:</label>
            <input type="text" value="" class="form-control" id="titulo" name="titulo" >
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="Estado">Estado:</label>
            <select class="form-control" name="estado" id="estado">
              <option selected>Em andamento</option>
              <option value="Resolvido">Resolvido</option>
              <option value="Em Andamento">Em Andamento</option>
              <option value="Respondido">Respondido</option>
              <option value="Aberto">Aberto</option>
            </select>
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
    <div class="modal-footer">
      @botaoFecharModal
    </div>
  </div>
</div>
