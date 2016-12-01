@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Atualização do ERP</div>
      <div class="panel-body">
        @if ($manifest["versao"] < $remoto["versao"])
          <div class="row" >
            <div class="col-md-3 pull-right text-right">
              <a href="{{ url('/admin/update/do') }}" class="btn btn-warning">
                <i class="fa fa-gear"></i> Atualizar ERP
              </a>
            </div>
          </div>
        @endif
        <div class="row">
          <div class="col-md-3">
            <h3>Atual:</h3>
            Laravel: {{ App::VERSION() }}<br>
            WebGS Erp: {{$manifest["versao"]}}<br>
            Data: {{$manifest["data"]}}
          </div>
          <div class="col-md-3">
            <h3>Remoto:</h3>
            Laravel: -<br>
            WebGS Erp: {{$remoto["versao"]}}<br>
            Data: {{$remoto["data"]}}
          </div>
        </div>
      </div>
  </div>
@endsection
