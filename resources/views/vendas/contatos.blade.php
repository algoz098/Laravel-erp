@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-shopping-cart fa-1x"></i> Lista de Vendas
        </div>
        <div class="panel-body">
          <div class="col-md-2 pull-right text-right">
            <a href="{{ url('/lista/vendas') }}" class="btn btn-warning"><i class="fa fa-shopping-cart"></i> Voltar a listagem</a>
          </div>
          <div class="row">
            <form method="POST" action="{{ url('/lista/caixa') }}/">
              <div class="col-md-12">
                <div class="form-group form-inline text-center">
                  {{ csrf_field() }}
                  <input type="text" class="form-control datepicker" size="8" name="data" placeholder="Data" id="data">
                  <button type="submit" class="btn btn-success">Buscar</button>
                </div>
                @foreach($contatos as $key => $contato)
                  <div class="row list-contacts">
                    <div class="col-md-12 h4">
                      <a href="{{url('novo/vendas/')}}/{{$contato->id}}">
                        <span class="btn btn-info">
                          <i class="fa fa-gear"></i>
                        </span>
                      </a>
                      <span class="label label-info">{{$contato->id}}</span>
                      <span class="label label-primary">{{$contato->nome}}</span>
                      <span class="label label-info">End: {{$contato->endereco}}, {{$contato->cidade}} - {{$contato->uf}}</span>
                    </div>
                  </div>
                @endforeach
                <div class="row">
                  <div class="col-md-12 text-center">
                    {{ $contatos->links() }}
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
