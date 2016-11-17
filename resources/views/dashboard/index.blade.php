@extends('main')

@section('content')
  <div class="row">
      <div class="col-md-3">
          <div class="panel panel-default text-center">
              <div class="panel-heading"><i class="fa fa-users"></i> contatos/Fornecedores:</div>
              <div class="panel-body">
                  <span style="font-size: 2em;">{!! count($contatos) !!}</span><br>
                  <a href="{{ url('/contatos') }}">Ver lista</a>
              </div>
          </div>
      </div>
      <div class="col-md-3">
          <div class="panel panel-default text-center">
              <div class="panel-heading"><i class="fa fa-users"></i> Funcionarios:</div>
              <div class="panel-body">
                  <span style="font-size: 2em;">{!! count($funcionarios) !!}</span><br>
                  <a href="{{ url('/funcionarios') }}">Ver lista</a>
              </div>
          </div>
      </div>
  </div>
@endsection
