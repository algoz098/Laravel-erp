<?php
use Carbon\Carbon;
?>
@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-bell-o fa-1x"></i> Criar novo produto ao estoque
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-3 text-right pull-right">
              <a class="btn btn-warning" href="{{ url('lista/estoque')}}" ><i class="fa fa-bell-o"></i> Voltar a Lista</a>
            </div>
          </div>
          <div class="row pull-center">
            <div class="col-md-12">
              <form method="POST" action="{{ url('/novo/estoque/busca') }}">
                <div class="form-group form-inline text-center">
                  {{ csrf_field() }}
                  <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca" size="10">
                  <button type="submit" class="btn btn-success" id="buscar" >Buscar</button>
                </div>
              </form>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5">
              @foreach($contatos as $key => $contato)
                <div class="row list-contacts">
                  <div class="col-md-2 text-right">
                    <a class="btn btn-info" onclick="
                                                      $('#form').show();
                                                      $('#contato').val('{{$contato->nome}}');
                                                      $('#contatos_id').val('{{$contato->id}}');
                    ">
                      <i class="fa fa-gear"></i>
                    </a>
                  </div>
                  <div class="col-md-10">
                    {{str_limit($contato->nome, 45)}}
                  </div>
                </div>
              @endforeach
              <div class="row">
                <div class="col-md-12 text-center">
                  {{ $contatos->links() }}
                </div>
              </div>
            </div>
            <form method="POST" action="{{ url('/novo/estoque') }}">
              <div class="col-md-7" style="display: none;" id="form">
                {{ csrf_field() }}
                <div class="form-group">
                  <label>Estoque para</label>
                  <input type="text" class="form-control" name="contato" id="contato" value="" disabled>
                  <input type="hidden" class="form-control" name="contatos_id" id="contatos_id" value="">
                </div>
                <div class="form-group">
                  <label>Nome</label>
                  <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome">
                </div>
                <div class="form-group">
                  <label>Valor</label>
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">R$</span>
                    <input type="text" class="form-control" name="valor_custo" id="valor" placeholder="Valor de custo">
                  </div>
                </div>
                <div class="form-group">
                  <label>Quantidade</label>
                  <input type="text" class="form-control" name="quantidade" id="quantidade" placeholder="Quantidade">
                </div>
                <div class="form-group">
                  <label>Codigo</label>
                  <input type="text" class="form-control" name="barras" id="barras" placeholder="Codigo">
                </div>
                <div class="form-group">
                  <label for="text">Descrição </label>
                  <textarea class="form-control" id="texto" rows="2" name="descricao"></textarea>
                </div>
                <button type="submit" class="btn btn-success" id="enviar" >Enviar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
