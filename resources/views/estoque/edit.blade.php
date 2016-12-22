<?php
use Carbon\Carbon;
?>
@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-bell-o fa-1x"></i> Novo estoque
        </div>
        <form method="POST" action="{{ url('/lista/estoque/'.$estoque->id.'/editar') }}">
        <div class="panel-body">
          <div class="row ">
            <div class="col-md-3 pull-right text-right">
              <a href="{{url()->previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Voltar</a>
              <button type="submit" class="btn btn-success" id="enviar" >Enviar</button>
            </div>
          </div>
          <div class="row">
              <div class="col-md-4">
                {{ csrf_field() }}
                <div class="form-group">
                  <label>Estoque para</label>
                  <input type="text" class="form-control" name="contato" id="contato" value="{{$estoque->contato->nome}}" disabled>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Codigo de barras</label>
                  <input type="text" class="form-control" name="barras" id="barras" value="{{$estoque->barras}}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Quantidade</label>
                  <input type="text" class="form-control" name="quantidade" id="quantidade" value="{{$estoque->quantidade}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Nome</label>
                  <input type="text" class="form-control" name="nome" id="nome" value="{{$estoque->nome}}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Valor de custo</label>
                  <input type="text" class="form-control" name="valor_custo" id="valor" value="{{$estoque->valor_custo}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Descrição</label>
                  <textarea class="form-control" rows="5" name="descricao">{{$estoque->descricao}}</textarea>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-success" id="enviar" >Enviar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection
