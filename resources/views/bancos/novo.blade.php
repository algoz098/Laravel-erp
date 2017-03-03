@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-usd fa-1x"></i> Novo conta bancario
        </div>
        <div class="panel-body">
          @if (isset($banco))
            <form method="POST" action="{{ url('/novo/bancos') }}/{{$banco->id}}">
          @else
            <form method="POST" action="{{ url('/novo/bancos') }}">
          @endif
            <div class="row" id="secondNavbar">
              <div class="col-md-12 text-right pull-right">
                @botaoLista(bancos*fa-bank)
                @botaoSalvar
              </div>
            </div>
            @include('bancos.parte_novo')
          </form>
        </div>
      </div>
    </div>
  </div>
<script>
$('#agencia').mask('****?****-*');
$('#cc').mask('****?****');
$('#cc_dig').mask('*');
$('#comp').mask('*?**-*');


</script>
@endsection
