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
              <div class="col-md-4 text-right pull-right">
                <a class="btn btn-warning" href="{{ url('lista/contas')}}" ><i class="fa fa-usd"></i> Voltar a Lista</a>
                <a href="{{ url('/novo/contas') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Reselecionar cliente</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-arrow-right"></i> Parcelas</a>
              </div>
            </div>
            {{ csrf_field() }}
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Provisão para</label>
                    <input type="text" class="form-control" id="contato" value="{{$contato->nome}}" disabled>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Tipo</label>
                    <select class="form-control" id="tipo" name="tipo">
                      <option value="0" selected>Saida</option>
                      <option value="1">Entrada</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
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
                    <input type="numeric" class="form-control" id="cheio" name="cheio" placeholder="Valor">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="cheio">Desconto</label>
                    <input type="numeric" class="form-control" id="desconto" name="desconto" placeholder="Valor">
                  </div>
                </div>
                <div class="col-md-3  ">
                  <div class="form-group">
                    <label for="parcelas">Quantidade de parcelas</label>
                    <input type="numeric" class="form-control" id="parcelas" name="parcelas" placeholder="Numero">
                  </div>
                </div>
                <div class="col-md-3  ">
                  <div class="form-group">
                    <label for="parcelas">D.M. Numero de documento</label>
                    <input type="numeric" class="form-control" id="dm" name="dm" placeholder="D.M.">
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
@endsection
