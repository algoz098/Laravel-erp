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
                    @else
                      @selecionaFilial
                    @endif
                    <div class="form-group">
                      <label>Codigo</label>
                      @if (isset($estoque))
                        <input type="text" class="form-control" name="barras" id="barras" value="{{$estoque->barras}}">
                      @else
                        <input type="text" class="form-control" name="barras" id="barras">
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="form-group">
                      <label>Tipo</label>
                      @if (isset($estoque))
                        <input type="text" class="form-control" name="tipo" id="tipo" value="{{$estoque->tipo}}">
                      @else
                        <input type="text" class="form-control" name="tipo" id="tipo">
                      @endif
                    </div>
                    <div class="form-group">
                      <label>Nome do produto</label>
                      @if (isset($estoque))
                        <input type="text" class="form-control" name="nome" id="nome" value="{{$estoque->nome}}">
                      @else
                        <input type="text" class="form-control" name="nome" id="nome">
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="form-group">
                      <label>Valor</label>
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">R$</span>
                        @if (isset($estoque))
                          <input type="text" class="form-control" name="valor_custo" id="valor" value="{{$estoque->valor_custo}}">
                        @else
                          <input type="text" class="form-control" name="valor_custo" id="valor">
                        @endif
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Quantidade</label>
                      @if (isset($estoque))
                        <div class="row">
                          <div class="col-md-8">
                            <input type="text" class="form-control" name="quantidade" id="quantidade" value="{{$estoque->quantidade}}">
                          </div>
                          <div class="col-md-4">
                            <select class="form-control" name="unidade">
                              <option selected>{{$estoque->unidade}} (atual)</option>
                              <option value="Uni.">Uni.</option>
                              <option value="Kg">Kg</option>
                              <option value="Lts">Lts</option>
                              <option value="Pç">Pç</option>
                            </select>
                          </div>
                      @else
                        <div class="row">
                          <div class="col-md-8">
                            <input type="text" class="form-control" name="quantidade" id="quantidade">
                          </div>
                          <div class="col-md-4">
                            <select class="form-control" name="unidade">
                              <option selected>- Escolha -</option>
                              <option value="Uni.">Uni.</option>
                              <option value="Kg">Kg</option>
                              <option value="Lts">Lts</option>
                              <option value="Pç">Pç</option>
                            </select>
                          </div>
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Campos especificos</h3>
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-md-2 pull-right text-right">
                        <div class="panel panel-default">
                          <div class="panel-body">
                            <a class="btn btn-danger" onclick="remove()">
                              <i class="fa fa-minus"></i>
                            </a>
                            <a class="btn btn-success" onclick="add()">
                              <i class="fa fa-plus"></i>
                            </a>
                          </div>
                          <div class="panel-heading">Controle</div>
                        </div>
                      </div>
                      <span id="mais">
                        @if (isset($estoque))
                          @foreach ($estoque->campos as $key => $campo)
                            <input type="hidden" class="form-control" name="campo_id_edit[{{$key}}]" id="campo_id" value="{{$campo->id}}">
                            <div class="3397 col-md-9" id="linha{{$key}}">
                              <div class="panel panel-default">
                                <div class="panel-body">
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label for="text" id="numeroText">Nome do campo</label>
                                      <input type="text" class="form-control" name="campo_nome_edit[{{$key}}]" id="campo_nome" value="{{$campo->nome}}">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label for="text">Valor do campo</label>
                                      <input type="text" class="form-control"  name="campo_valor_edit[{{$key}}]" id="campo_valor" value="{{$campo->valor}}">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          @endforeach
                        @endif
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="text">Descrição </label>
                  <textarea class="form-control" id="texto" rows="2" name="descricao"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <script>
  $(document).ready(function(){
    window.i = 0;
    @if (isset($estoque))
    @else
      add();
    @endif
  });
  function add() {
    var $clone = $($('#ToClone').html());
    $('#campo_nome', $clone).attr('name', 'campo_nome['+i+']');
    $('#campo_valor', $clone).attr('name', 'campo_valor['+i+']');
    $('.3397', $clone).attr('id', 'linha'+i);
    i = i + 1;
    $clone.appendTo('#mais');
  }
  function remove() {
    if (i<0){}else {
      $('#linha'+i).remove();
      if(i>0){
        i = i - 1;
      }
    }
  }
  </script>
  <script id="ToClone" type="text/template">
  <span>
    <div class="3397 col-md-9" id="a">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="col-md-3">
            <div class="form-group">
              <label for="text" id="numeroText">Nome do campo</label>
              <input type="text" class="form-control" value="" name="campo_nome" id="campo_nome">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="text">Valor do campo</label>
              <input type="text" class="form-control" value="" name="campo_valor" id="campo_valor">
            </div>
          </div>
        </div>
      </div>
    </div>
  </span>
  </script>
@endsection
