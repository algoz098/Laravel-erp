@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Total de clientes/fornecedores</div>
        <div class="panel-body text-center">
         <span style="font-size:2em;">{!! count($clientes) !!}</span>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-wrench fa-1x"></i> Caixa de opções</div>
        <div class="panel-body">
          <a href="/erp/public/index.php/clientes/novo"><span style="font-size:1.5em;"><i class="fa fa-plus fa-1x"></i> Novo</span></a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Lista de clientes e fornecedores</div>
        <div class="panel-body">
          @foreach($clientes as $key => $cliente)
            <a href="/erp/public/index.php/clientes/{{$cliente->id}}">
              <div class="row list-contacts">
                <div class="col-md-3 text-center">
                  {{$cliente->id}}
                </div>
                <div class="col-md-3">
                  {{$cliente->razao_social}}
                </div>
                <div class="col-md-6">
                  {{$cliente->endereco}}, {{$cliente->numero}} - {{$cliente->bairro}} {{$cliente->cidade}} - {{$cliente->uf}}
                </div>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection
