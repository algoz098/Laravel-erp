<?php
use Carbon\Carbon;
?>
@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-usd fa-1x"></i> Nova provisão de contas
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-3 text-right pull-right">
              <a class="btn btn-warning" href="{{ url('lista/contas')}}" ><i class="fa fa-usd"></i> Voltar a Lista</a>
            </div>
          </div>
          <div class="row pull-center">
            <div class="col-md-12">
              <form method="POST" action="{{ url('/novo/contas/busca') }}">
                <div class="form-group form-inline text-center">
                  {{ csrf_field() }}
                  <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca" size="10">
                  <button type="submit" class="btn btn-success" id="buscar" >Buscar</button>
                </div>
              </form>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="row list-contacts">
                <div class="col-md-3">
                  Opções
                </div>
                <div class="col-md-5">
                  Razão Social
                </div>
                <div class="col-md-3">
                  Nome Fantasia
                </div>
                <div class="col-md-1">
                  Detalhes
                </div>
              </div>
              @foreach($contatos as $key => $contato)
                <div class="row list-contacts">
                  <div class="col-md-1">
                    <a class="btn btn-info" href="{{ url('/novo/contas')}}/{{$contato->id}}">
                      <i class="fa fa-gear"></i>
                    </a>
                  </div>
                  <div class="col-md-6">
                    {{$contato->nome}}
                    @if ($contato->tipo=="1"){{ $contato->sobrenome }}@endif
                    @if ($contato->id=="1")<span class="label label-danger">Matriz</span> @endif
                  </div>
                  <div class="col-md-4">
                     @if ($contato->tipo!="1"){{ $contato->sobrenome }}@endif
                  </div>
                  <div class="col-md-1">
                    <span class="label label-primary">{{date('d/m/Y', strtotime($contato->created_at))}}</label>
                  </div>
                </div>
              @endforeach
            </div>
            <!-- <form method="POST" action="{{ url('/novo/contas') }}">
              <div class="col-md-4" style="display: none;" id="form">
                {{ csrf_field() }}
                <div class="form-group">
                  <label>Conta para</label>
                  <input type="text" class="form-control" name="contato" id="contato" value="" disabled>
                  <input type="hidden" class="form-control" name="contatos_id" id="contatos_id" value="">
                </div>
                <div class="form-group">
                  <label>Nome</label>
                  <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome">
                </div>
                <div class="form-group">
                  <label>Valor</label>
                  <input type="text" class="form-control" name="val" id="valor" placeholder="Valor">
                </div>
                <div class="form-group">
                  <label>Vencimento</label>
                  <input type="text" class="form-control datepicker" name="venc" value="{{Carbon::now()}}" id="datepicker">
                </div>
                <div class="form-group">
                  <label for="text">Descrição </label>
                  <textarea class="form-control" id="texto" rows="2" name="descricao"></textarea>
                </div>
                <div class="form-group">
                  <label for="text">Tipo</label>
                  <select class="form-control" id="tipo" name="tipo">
                    <option value="0" selected>Saida</option>
                    <option value="1">Entrada</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="text">Estado</label>
                  <select class="form-control" id="estado" name="estado">
                    <option value="0" selected>A pagar</option>
                    <option value="1">Pago</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="text">Parcelamento</label>
                  <select class="form-control" id="parcelar" name="parcelas" onchange="parcela(this);">
                    <option value="0" selected>Não</option>
                    <option value="1" >Sim</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-success" id="enviar" >Enviar</button>
              </div>
              <div class="col-md-4" style="display: none;" id="parcelamento">
                <div class="form-group">
                  <label for="text">Quantidade de parcelas </label>
                  <div class="row">

                    <div class="col-md-4">
                      <span class="btn btn-danger" onclick="parcelamentoRemove()">
                        <i class="fa fa-minus"></i>
                      </span>
                      <span class="btn btn-success" onclick="parcelamentoAdd()">
                        <i class="fa fa-plus"></i>
                      </span>
                    </div>
                    <div class="col-md-8">
                      <input type="number" class="form-control" name="parcelas" id="parcelas" value="0" disabled>
                    </div>
                  </div>

                </div>
                <div class="row panel panel-default" id="maisParcelas">
                  <div class="panel-body">
                    <div class="form-group">
                      <label>Vencimento da Entrada</label>
                      <input type="text" class="form-control datepicker" name="vencimento[0]" value="{{Carbon::now()}}" id="parcela-vencimento">
                    </div>
                    <div class="form-group">
                      <label>Valor da Entrada</label>
                      <input type="text" class="form-control" name="valor[0]" value="" id="parcela-valor">
                    </div>
                  </div>
                </div>
                <div id="mais"></span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    $( function() {
      $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
    } );
</script>
<script language="javascript">
    function parcela(selected) {
      if (selected.value=="1"){
        $('#parcelamento').show();
      }
    }
    function parcelamentoAdd() {
      var i = 0;
      i = parseInt($('#parcelas').val())+1;
      var $clone = $($('#ToClone').html());
      $('#vencimentoTexto', $clone).text('Vencimento '+i);
      $('#parcelamentos', $clone).attr('id', 'parcelamentos'+i);
      $('#vencimentoData', $clone).attr('name', 'vencimento['+i+']');
      $('#valorTexto', $clone).text('Valor '+i);
      $('#valorNumero', $clone).attr('name', 'valor['+i+']');
      //$('#vencimentoData', $clone).addClass('datepicker'+i);
      $clone.appendTo('#mais');
      $('#parcelas').val(i);
      $( function() {
        $( ".datepicker"+i ).datepicker({ dateFormat: 'yy-mm-dd' });
      } );
    }
    function parcelamentoRemove() {
      var i = 0;
      i = parseInt($('#parcelas').val());
      $('#parcelamentos'+i).remove();
      i = i-1;
      $('#parcelas').val(i);
    }
  </script>

  <script id="ToClone" type="text/template">
    <div>
      <div class="row panel panel-default" id="parcelamentos">
        <div class="panel-body">

          <div class="form-group">
            <label id="vencimentoTexto">Vencimento 0</label>
            <input type="text" class="form-control " name="parcela[0]" value="{{Carbon::now()}}" id="vencimentoData">
          </div>
          <div class="form-group">
            <label id="valorTexto">Valor 0</label>
            <input type="text" class="form-control" name="parcela[0]" value="" id="valorNumero">
          </div>
        </div>
      </div>
    </div>
  </script>-->
@endsection
