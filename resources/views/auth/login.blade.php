@extends('main')

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-6 offset-md-3">

          <div class="card">

            <form class="" role="form" method="POST" action="{{ url('/login') }}">
              {{ csrf_field() }}
              <br>
              
              <div class="row text-center" style="margin-bottom: 15px">

                <div class="col">
                  <img src="{{url('admin/config/img_destaque')}}" class="img-circle" height="200">
                </div>

              </div>

              <div class="row">

                <div class="col-10 offset-md-1">

                  <div class="form-group">
                    <label for="email" class="col-md-4 control-label">Usuario</label>
                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                  </div>

                </div>

              </div>
              <div class="row">

                <div class="col-10 offset-md-1">
                  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">Senha</label>

                      <input id="password" type="password" class="form-control" name="password" required>

                      @if ($errors->has('password'))
                        <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                        </span>
                      @endif
                  </div>
                </div>

              </div>
              <div class="row">

                <div class="col-10 offset-md-1">
                  <div class="form-group">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="remember"> Lembre-me
                      </label>
                    </div>
                  </div>
                </div>

              </div>
              <div class="row">

                <div class="col-11 text-right">

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                      <i class="fa fa-id-badge"></i>
                      Entrar
                    </button>
                  </div>

                </div>

              </div>

            </form>

          </div>

        </div>

    </div>
    <div class="row">
      <div class="offset-md-7">
        <small>desenvolvido e mantido por <a href="www.webgs.com.br">WebGS</a></small>
      </div>
    </div>
</div>
@endsection
