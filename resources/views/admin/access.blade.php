@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Permissões do usuario de <span class="label label-info">{{$contato->nome}}</span></div>
    <form method="POST" action="{{ url('/admin') }}/access/{{$contato->id}}">
      {{ csrf_field() }}
      <div class="panel-body">
        <div class="row pull-right">
          <a href="{{url()->previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Voltar</a>
          <button class="btn btn-success" type="submit">Salvar</button>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="text">Permisão ADM</label>
              <input type="text" class="form-control" value="" name="role[admin]" id="role" placeholder="">
            </div>
          </div>
        </div>
      </div>

  </div>
@endsection
