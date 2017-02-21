<?php
  use Carbon\Carbon;
?>
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
              <div class="col-md-4 pull-right text-right">
                @botaoLista(tickets*fa-book)
                @botaoSalvar
              </div>
            </div>
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
        </div>
      </div>
    </div>
  </form>
@endsection
