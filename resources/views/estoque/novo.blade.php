<?php
use Carbon\Carbon;
?>
@extends('main')
@section('content')
  @if (isset($estoque))
    <form method="POST" action="{{ url('/novo/estoque') }}/{{$estoque->id}}">
  @else
    <form method="POST" action="{{ url('/novo/estoque') }}">
  @endif
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading ">
            <i class="fa fa-bell-o fa-1x"></i> Criar novo produto ao estoque
          </div>
          <div class="panel-body">
            <div class="row" id="secondNavbar">
              <div class="col-md-3 text-right pull-right">
                @botaoLista(estoque*fa-bell-o)
                @botaoSalvar
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                    @if (isset($estoque))
                      @selecionaFilial($estoque->contato->id*$estoque->contato->nome)
                      @selecionaProduto($estoque->produto->id*$estoque->produto->nome)
                    @else
                      @selecionaFilial
                      @selecionaProduto
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="form-group">
                      <label>Qtd em estoque</label>
                      <input type="text" class="form-control" id="quantidade" name="quantidade"  value="{{isset($estoque->quantidade) ? $estoque->quantidade : ""}}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

@endsection
