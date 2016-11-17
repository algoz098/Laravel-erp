@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Total de contatos/fornecedores</div>
        <div class="panel-body text-center">
         <span style="font-size:2em;">{!! count($contatos) !!}</span>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-wrench fa-1x"></i> Caixa de opções</div>
        <div class="panel-body">
          <a href="{{ url('/contatos/novo') }}"><span style="font-size:1.5em;"><i class="fa fa-plus fa-1x"></i> Novo</span></a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Lista de contatos e fornecedores</div>
        <div class="panel-body">
          @foreach($contatos as $key => $contato)
              <div class="row list-contacts">
                <div class="col-md-2 text-center">
                  <a href="{{ url('/contatos') }}/{{$contato->id}}" class="btn btn-primary btn_xs" data-toggle="tooltip" title="Editar">
                    <i class="fa fa-wrench" ></i>
                  </a>
                  <a href="{{ url('/contatos') }}/{{$contato->id}}" class="btn btn-primary btn_xs" data-toggle="tooltip" title="Detalhes">
                    <i class="fa fa-file-text"></i>
                  </a>
                  <a href="{{ url('/contatos') }}/{{$contato->id}}/phone" class="btn btn-primary btn_xs" data-toggle="tooltip" title="Adicionar Telefone">
                    <i class="fa fa-phone"></i>
                  </a>
                  {{$contato->id}}
                </div>
                <div class="col-md-2">
                  <i class="fa fa-user level{{$contato->active}}"></i> <i class="fa fa-signal level{{$contato->sociabilidade}}"></i> {{$contato->nome}} {{$contato->sobrenome}}
                </div>
                <div class="col-md-8">
                  {{$contato->endereco}} - {{$contato->bairro}} {{$contato->cidade}} - {{$contato->uf}}
                </div>
              </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection
