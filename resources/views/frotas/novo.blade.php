@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-car fa-1x"></i> Novo veiculo de frota
        </div>
        @if (isset($frota))
          <form method="post" action="{{url('novo/frotas/')}}/{{$frota->id}}/edit">
        @else
          <form method="post" action="{{url('novo/frotas/')}}/{{$contato->id}}">
        @endif
          {{csrf_field()}}
          <div class="panel-body">
            <div id="secondNavbar" class="row">
              <div class="row">
                <div class="col-md-5 pull-right text-right">
                  @if (!isset($frota))
                    <a href="{{url('novo/frotas')}}" class="btn btn-warning">
                      <i class="fa fa-user"></i>
                      Reselecionar entidade
                    </a>
                  @endif
                  <a href="{{url('lista/frotas')}}" class="btn btn-warning">
                    <i class="fa fa-car"></i>
                    Voltar a lista
                  </a>
                  <button type="submit" class="btn btn-success">
                    <i class="fa fa-plus"></i>
                    Enviar
                  </button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="usr">Contato:</label>
                      <input type="text" value="{{isset($frota) ? $frota->contato->nome : $contato->nome}}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                      <label for="marca">Marca:</label>
                      <input type="text" class="form-control" id="marca" name="marca" value="{{isset($frota) ? $frota->marca : ""}}">
                    </div>
                    <div class="form-group">
                      <label for="placa">Placa:</label>
                      <input type="text" class="form-control" id="placa" name="placa" value="{{isset($frota) ? $frota->placa : ""}}">
                    </div>
                    <div class="form-group">
                      <label for="modelo">Modelo do ano:</label>
                      <input type="text" class="form-control" id="modelo" name="modelo" value="{{isset($frota) ? $frota->modelo : ""}}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="combustivel">Combustivel:</label>
                      <input type="text" class="form-control" id="combustivel" name="combustivel" value="{{isset($frota) ? $frota->combustivel : ""}}">
                    </div>
                    <div class="form-group">
                      <label for="ano">Ano de compra:</label>
                      <input type="text" class="form-control" id="ano" name="ano" value="{{isset($frota) ? $frota->ano : ""}}">
                    </div>
                    <div class="form-group">
                      <label for="renavan">Renavan:</label>
                      <input type="text" class="form-control" id="renavan" name="renavan" value="{{isset($frota) ? $frota->renavan : ""}}">
                    </div>
                    <div class="form-group">
                      <label for="chassi">Numero do Chassi:</label>
                      <input type="text" class="form-control" id="chassi" name="chassis" value="{{isset($frota) ? $frota->chassi : ""}}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<script>
$("#renavan").mask("999.999.999.99");
$("#ano").mask("9999");
$("#modelo").mask("9999");
$("#placa").mask("***-9999")
</script>
@endsection
