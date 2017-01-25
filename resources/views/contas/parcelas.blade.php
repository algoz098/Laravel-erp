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
          <form method="POST" action="{{ url('/novo/contas') }}/{{$contato->id}}/parcelas/{{$conta->id}}">
            <div class="row">
              <div class="col-md-4 text-right pull-right">
                <a class="btn btn-warning" href="{{ url('lista/contas')}}" ><i class="fa fa-usd"></i> Voltar a Lista</a>
                <a href="{{ url('/novo/contas') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Reselecionar cliente</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</a>
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
                    <label>Conta referente</label>
                    <input type="text" class="form-control" id="contato" value="{{$conta->nome}}" disabled>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Valor total</label>
                    <input type="text" class="form-control" id="contato" value="{{$conta->valor}}" disabled>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <h3>Parcelas</h3>
                </div>
              </div>
              @foreach($vencimentos as $key => $vencimento)
                <div class="row list-contacts">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Vencimento: {{$conta->nome}} {{$key}}-{{$loop->count}}</label>
                      <input string="numeric" class="form-control " id="datepicker{{$key}}" name="vencimento[{{$key}}]" value="{{$vencimento}}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Valor</label>
                      <input string="numeric" class="form-control " id="datepicker{{$key}}" name="parcela[{{$key}}]" value="{{$parcela}}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Desconto</label>
                      <input type="numeric" class="form-control" id="desconto" name="desconto[{{$key}}]" placeholder="Valor">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Formas de pagamento</label>
                      <select class="form-control" id="forma" name="forma[{{$key}}]">
                        <option value="0" {{{$conta->pagamento=="0" ? "selected" : ""}}}>Dinheiro</option>
                        <option value="1" {{{$conta->pagamento=="1" ? "selected" : ""}}}>Cartão de credito</option>
                        <option value="2" {{{$conta->pagamento=="2" ? "selected" : ""}}}>Cartão de debito</option>
                        <option value="3" {{{$conta->pagamento=="3" ? "selected" : ""}}}>Cheque</option>
                        <option value="4" {{{$conta->pagamento=="4" ? "selected" : ""}}}>Deposito em conta</option>
                      </select>
                    </div>
                  </div>
                </div>
                <script language="javascript">
                  $( function() {
                    $("#datepicker{{$key}}" ).datepicker({ dateFormat: 'yy-mm-dd' });
                  } );
                </script>
              @endforeach
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
