@extends('main')

@section('content')
  <?php
  use Carbon\Carbon;
  $a = 0;
  $b = 0;
  foreach($contas as $key => $conta){
    if (strtotime($conta->vencimento)<strtotime(Carbon::now())){
      $a = $a+1;
    } else{
      $b = $b+1;
    }
  }
  ?>
  <div class="row">
      <div class="col-md-3">
          <div class="panel panel-default text-center">
              <div class="panel-heading"><i class="fa fa-users"></i> Contatos:</div>
              <div class="panel-body">
                  <span style="font-size: 2em;">{!! count($contatos) !!}</span><br>
                  <a href="{{ url('lista/contatos') }}">Ver lista</a>
              </div>
          </div>
      </div>
      <div class="col-md-3">
          <div class="panel panel-default text-center">
              <div class="panel-heading"><i class="fa fa-usd"></i> Contas:</div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-4">
                    <span style="font-size: 2em;">{!! count($contas) !!}</span><br>
                  </div>
                  <div class="col-md-8">
                    {{$a}} <span class="label label-danger">Vencidas</span><br>
                    {{$b}} <span class="label label-warning">A vencer</span>
                  </div>
                </div>
                  <a href="{{ url('lista/contas') }}">Ver lista</a>
              </div>
          </div>
      </div>
  </div>
@endsection
