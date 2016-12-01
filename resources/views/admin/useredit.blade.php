@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Editar usuario do <span class="label label-info">{{$contato->nome}}</span></div>
    <form method="POST" action="{{ url('/admin') }}/user/{{$contato->id}}">
      {{ csrf_field() }}
      <div class="panel-body">
        <div class="row pull-right">
          <a href="{{url()->previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Voltar</a>
          <button class="btn btn-success" type="submit">Salvar</button>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="dropdown">
              <div class="form-group">
                <label for="sel1">Usuario ativo?:</label>
                <select class="form-control" name="ativo" id="ativo">
                  <option value="1">Ativo</option>
                  <option value="0">Inativo</option>
                </select>
              </div>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
              </ul>
            </div>
            <div class="form-group">
              <label for="text">E-Mail (login)</label>
              <input type="text" class="form-control" value="{{ $contato->email or "" }}" name="email" id="email" placeholder="Email">
              @if ($errors->has('email'))
                  <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif
            </div>
            <div class="form-group">
              <label for="text">Senha</label>
              <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection
