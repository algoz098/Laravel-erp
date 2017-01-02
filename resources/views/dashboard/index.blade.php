@extends('main')

@section('content')
  <?php
  use Carbon\Carbon;
  $a = 0;
  $b = 0;
  $c = 0;
  $d = 0;
  $saidas = 0;
  $saira = 0;
  $entradas = 0;
  $entrara = 0;
  foreach($contas as $key => $conta){
    if (strtotime($conta->vencimento)<strtotime(Carbon::now()) and $conta->estado!=1){
      $a = $a+1;
    } else{
      $b = $b+1;
    }
    if ($conta->tipo=="0"){
      $c = $c+1;
      if (strtotime($conta->vencimento)<strtotime(Carbon::now()) and $conta->estado=="1") {
        $saidas = $saidas + $conta->valor;
      } else {
        $saira = $saira + $conta->valor;
      }
    } else {
      $d = $d+1;
      if (strtotime($conta->vencimento)<strtotime(Carbon::now()) and $conta->estado=="1") {
        $entradas = $entradas + $conta->valor;
      } else {
        $entrara = $entrara + $conta->valor;
      }
    }
  }
  ?>
  <div class="row">
      <div class="col-md-3 ajuda-popover"
        data-content="Numero de contatos que você possui"
        data-placement="bottom">
          <div class="panel panel-default text-center">
              <div class="panel-heading"><i class="fa fa-users"></i> Contatos:</div>
              <div class="panel-body">
                  <span style="font-size: 2em;">{!! count($contatos) !!}</span><br>
                  <a href="{{ url('lista/contatos') }}">Ver lista</a>
              </div>
          </div>
      </div>
      <div class="col-md-4 ajuda-popover"
        data-content="Resumo das contas."
        data-placement="bottom">
          <div class="panel panel-default text-center">
              <div class="panel-heading"><i class="fa fa-usd"></i> Contas:</div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-4">
                    <span style="font-size: 2em;">{!! count($contas) !!}</span><br>
                  </div>
                  <div class="col-md-8">
                    <span class="label label-danger"><i class="fa fa-exclamation"></i> Vencidas: {{$a}} </span><br>
                    <span class="label label-warning"><i class="fa fa-question"></i> A vencer: {{$b}} </span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <span class="label label-info">Deb: {{$c}}</span><br>
                    <span class="label label-success">Cred: {{$d}}</span>
                  </div>
                  <div class="col-md-4">
                    <span class="label label-warning">Hoj: R$ {{$saidas}}</span><br>
                    <span class="label label-success">Hoj: R$ {{$entradas}}</span>
                  </div>
                  <div class="col-md-4">
                    <span class="label label-danger">Ftr: R${{$saira}}</span><br>
                    <span class="label label-info">Ftr: R${{$entrara}}</span>
                  </div>
                </div>
                  <a href="{{ url('lista/contas') }}">Ver lista</a>
              </div>
          </div>
      </div>
  </div>
@endsection
