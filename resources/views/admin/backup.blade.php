<?php
use Carbon\Carbon;
?>
@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Atualização do ERP</div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-9">
            <a href="{{ url('admin/backup/do') }}" class="btn btn-success"><i class="fa fa-exclamation-circle"></i> Fazer backup</a>
            <h3>Estado do backup:</h3>
            @if ($ultimo!==0 and strtotime($ultimo->format('y-m-d H:i:s'))>strtotime("-1 days"))
              <span class="label label-success">Ok</span>
            @else
              <span class="label label-danger h2">ANTIGO</span>
            @endif
            @if ($ultimo!==0)
              Ultimo backup: {{$ultimo->format('H:i d-m-Y')}}
            @else
              !!! NENHUM BACKUP FEITO AINDA !!!
            @endif
          </div>
          @if ($ultimo!==0)
            <div class="col-md-3 pull-right">
              <h3>Backups existentes:</h3>
              @foreach($backups as $key => $backup)
                <div class="row">
                  <div class="col-md-12 text-center">
                    {{$backup}}
                    <a href="{{ url('admin/backup/download') }}/{{$backup}}" class="label label-info">Baixar</a>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
  </div>
@endsection
