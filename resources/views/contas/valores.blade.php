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
          <form method="POST" action="{{ url('/novo/contas') }}/{{$contato->id}}/parcelas">
            <div class="row">
              <div class="col-md-12 text-right pull-right">
                <a class="btn btn-warning" href="{{ url('lista/contas')}}" ><i class="fa fa-usd"></i> Voltar a Lista</a>
                <a href="{{ url('/novo/contas') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Reselecionar cliente</a>
                <button type="submit" id="saveButton" class="btn btn-success"><i class="fa fa-check"></i> Salvar</a>
              </div>
            </div>
            {{ csrf_field() }}
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Provisão para</label>
                    <input type="text" class="form-control" id="contato" value="{{$contato->nome}}" disabled>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Tipo</label>
                    <select class="form-control" id="tipo" name="tipo" onchange="tipoChange()">
                      <option value="0" selected>Saida</option>
                      <option value="1">Entrada</option>
                      <option value="2">Conta de consumo</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Formas de pagamento</label>
                    <select class="form-control" id="forma" name="forma">
                      <option value="0" selected>Dinheiro</option>
                      <option value="1">Cartão de credito</option>
                      <option value="2">Cartão de debito</option>
                      <option value="3">Cheque</option>
                      <option value="4">Deposito em conta</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Referencia</label>
                    <select class="form-control" id="nome" name="nome">
                      <option value="" selected> - Escolha uma opção - </option>
                      @foreach($comboboxes as $key => $combobox)
                        <option value="{{$combobox->value}}">{{$combobox->text}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="cheio">Mes/Ano referente</label>
                    <input string="numeric" class="form-control datepicker2" id="mes_ano" name="mes_ano" placeholder="Mes/ano">
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="cheio">Vencimento</label>
                    <input string="numeric" class="form-control datepicker" id="vencimento" name="vencimento" value="{{Carbon::Now()}}">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="cheio">Valor cheio</label>
                    <div class="input-group">
                      <span class="input-group-addon" id="basic-addon1">R$</span>
                      <input type="text" class="form-control real-mask" name="cheio" id="cheio" placeholder="Valor">
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="cheio">Desconto</label>
                    <div class="input-group">
                      <span class="input-group-addon" id="basic-addon1">R$</span>
                      <input type="text" class="form-control real-mask" name="desconto" id="desconto" placeholder="Valor">
                    </div>
                  </div>
                </div>
                <div class="col-md-3  ">
                  <div class="form-group">
                    <label for="parcelas">Quantidade de parcelas</label>
                    <input type="numeric" class="form-control integer-mask" id="parcelas" name="parcelas" placeholder="Numero" onchange="parcelaChange()">
                  </div>
                </div>
                <div class="col-md-3  ">
                  <div class="form-group">
                    <label for="parcelas">D.M. Numero de documento</label>
                    <input type="numeric" class="form-control" id="dm" name="dm" placeholder="D.M.">
                  </div>
                </div>
              </div>
              <div class="row" id="discRow" style="display:none;">
                <hr>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="text">Discriminar cobrança.</label>
                    <input type="numeric" class="form-control" id="disc_text[0]" name="disc_text[0]" placeholder="Titulo da discriminação">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="text">Valor</label>
                    <div class="input-group">
                      <span class="input-group-addon" id="basic-addon1">R$</span>
                      <input type="text" class="form-control real-mask" name="disc_valor[0]" id="disc_valor" placeholder="valor da discriminação">
                    </div>
                  </div>
                </div>
                <div class="col-md-3 pull-right">
                  <a class="btn btn-danger" onclick="remove()">
                    <i class="fa fa-minus"></i>
                  </a>
                  <a class="btn btn-success" onclick="add()">
                    <i class="fa fa-plus"></i>
                  </a>
                </div>
              </div>
              <span id="mais"></span>
              <hr>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="text">Descrição </label>
                    <textarea class="form-control" id="texto" rows="2" name="descricao"></textarea>
                  </div>
                </div>
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
    $( function() {
      $( ".datepicker2" ).datepicker({ dateFormat: 'yy-mm' });
    } );

    function tipoChange(){
      var tipo = $('#tipo').val();
      var anterior = $('#saveButton').html();
      if(tipo==2){
        $('#discRow').show();
        $('#saveButton').html('<i class="fa fa-check"></i> Salvar');
      } else {
        $('#discRow').hide();
        //parcelaChange();
      }
    }

    function parcelaChange(){
      var value = parseInt($('#parcelas').val());
      if (value>0){
        $('#saveButton').html('<i class="fa fa-arrow-right"></i> Parcelas');
      } else {
        $('#saveButton').html('<i class="fa fa-check"></i> Salvar');
      }
    }
    window.i = 0;
    function add() {
      var $clone = $($('#ToClone').html());
      i = i + 1;
      $('#disc_text', $clone).attr('name', 'disc_text['+i+']');
      $('#disc_valor', $clone).attr('name', 'disc_valor['+i+']');
      $('.3397', $clone).attr('id', 'linha'+i);
      $clone.appendTo('#mais');
    }
    function remove() {
      $('#linha'+i).remove();
      i = i - 1;
    }
</script>
<script id="ToClone" type="text/template">
<div>
  <div class="row 3397" id="discRow">
    <hr>
    <div class="col-md-2">
      <div class="form-group">
        <label for="text">Discriminar cobrança.</label>
        <input type="numeric" class="form-control" id="disc_text" name="disc_text[0]" placeholder="Titulo da discriminação">
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="text">Valor</label>
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">R$</span>
          <input type="text" class="form-control real-mask" name="disc_valor[0]" id="disc_valor" placeholder="valor da discriminação">
        </div>
      </div>
    </div>
  </div>
</div>
</script>
@endsection
