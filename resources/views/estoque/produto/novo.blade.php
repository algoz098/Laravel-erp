@extends('main')
@section('content')
  @if (isset($produto))
    <form method="POST" action="{{ url('/novo/produto') }}/{{$produto->id}}">
  @else
    <form method="POST" action="{{ url('/novo/produto') }}">
  @endif
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading ">
            <i class="fa fa-bell-o fa-1x"></i> Criar novo produto ao estoque
          </div>
          <div class="panel-body">
            <div class="row" id="secondNavbar">
              <div class="col-md-3 text-right pull-right">
                @botaoLista(produtos*fa-bell-o)
                @botaoSalvar
              </div>
            </div>
            @include("estoque.produto.parte_novo")
          </div>
        </div>
      </div>
    </div>
  </form>

@endsection
