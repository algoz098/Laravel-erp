<?php
use Carbon\Carbon;
?>
@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-money fa-1x"></i> Fechamento de caixa
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-3 text-right pull-right">
              <a class="btn btn-warning" href="{{ url('lista/caixa')}}" ><i class="fa fa-money"></i> Voltar a Lista</a>
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
          @foreach($caixas as $key => $caixa)
            <div class="row list-contacts">
              <div class="col-md-1">
                <a href="{{ url('/lista/caixa/fechar/')}}/{{$caixa->id}}" class="btn btn-info">
                  <i class="fa fa-ban"></i>
                </a>
              </div>
              <div class="col-md-1">
                <span class="label label-info">ID: {{$caixa->id}}</label>
              </div>
              <div class="col-md-2">
                <span class="label label-info">{{$caixa->created_at}}</label>
              </div>
              <div class="col-md-2">
                @if ($caixa->att==1)
                  <span class="label label-danger">Existem pendenciais</label>
                @else
                  <span class="label label-success">Nenhuma pendencia</label>
                @endif
              </div>
              <div class="col-md-1">
                @if ($caixa->estado==0)
                  <span class="label label-primary">Aberto</label>
                @else
                  <span class="label label-success">Fechado</label>
                @endif
              </div>
              <div class="col-md-4 text-right pull-right">
                <span class="label label-info">{{$caixa->filial->nome}}</label>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection
