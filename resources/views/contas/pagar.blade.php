<?php
use Carbon\Carbon;
?>
@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-usd fa-1x"></i> Pagamento de conta
        </div>
        <div class="panel-body">
          <form method="POST" action="{{ url('/lista/contas') }}/{{$conta->id}}/pago">
            {{ csrf_field() }}
            <div class="row" id="secondNavbar">
              <div class="col-md-4 text-right pull-right">
                @botaoLista(contas*fa-usd)
                @botaoSalvar
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <strong>Dados da conta</strong>
                    Id: {{$conta->id}}, {{$conta->nome}}, R$ {{$conta->valor}}, {{$conta->contatos->nome}}
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-md-6">
                        @selecionaBanco
                      </div>
                      <div class="col-md-6">
                        @campoDinheiro(Valor pago:*valor*$conta->valor)
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
