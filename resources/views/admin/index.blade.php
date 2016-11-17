@extends('main')

@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Lista de contatos e fornecedores</div>
    <div class="panel-body">
      @foreach($users as $key => $user)
        <div class="row list-contacts">
          <div class="col-md-3 text-center">
            <strong>{{$user->name}}</strong>
          </div>
          <div class="col-md-1">
              <input type="checkbox" value="0">Administrador</input>
          </div>
        </div>
        <span class="btn btn-primary btn-xs" id="adminRole" data-toggle="button" aria-pressed="false" style="display:{{{ $user->roles[0]->role==0 ? "" : "none" }}}">Administrador</span>
      @endforeach
    </div>
  </div>
@endsection
