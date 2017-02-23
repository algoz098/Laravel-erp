@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      @if (isset($is_funcionario))
        @if (!empty($contato->id))
          <form method="POST" action="{{ url('/novo/contatos') }}/{{$contato->id}}">
        @else
          <form method="POST" action="{{ url('/novo/funcionarios') }}">
        @endif
      @else
        @if (!empty($contato->id))
          <form method="POST" action="{{ url('/novo/contatos') }}/{{$contato->id}}">
        @else
          <form method="POST" action="{{ url('novo/contatos') }}">
        @endif
      @endif
        <div class="form-group">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$contato->id or "" }}">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Adicionar entidade</div>
          <div class="panel-body">
            <div class="row text-right" id="secondNavbar">
              <div class="col-sm-offset-2 col-sm-10">
                @botaoLista(contatos*fa-users)
                @botaoSalvar
              </div>
            </div>
            @include('contatos.parte_novo')
@endsection
