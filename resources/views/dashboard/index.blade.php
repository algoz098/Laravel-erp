@extends('main')

@section('content')
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
  </div>
@endsection
