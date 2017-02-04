<?php use Carbon\Carbon; ?>
@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-usd fa-1x"></i> Nova provisão de contas
        </div>
        <div class="panel-body">
          <div class="row" id="secondNavbar">
            <div class="col-md-2">
              <div class="col-md-4">
                <a class="btn btn-info" id="buttonNovo">
                  <i class="fa fa-gear"></i>
                </a>
              </div>
              <div class="col-md-8">
                <input type="text" class="form-control" size="4" name="ids" id="ids" placeholder="Detalhes" disabled>
              </div>
            </div>
            <div class="col-md-8 text-center">
              @if (isset($is_consumos) and $is_consumos=="1" )
                <form method="POST" action="{{url('/novo/consumos/busca/')}}">
              @else
                <form method="POST" action="{{url('/novo/contas/busca/')}}">
              @endif
                <div class="form-group form-inline text-center">
                  {{ csrf_field() }}
                  <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca" size="10">
                  <button type="submit" class="btn btn-success" id="buscar" >Buscar</button>
                </div>
              </form>
            </div>
            <div class="col-md-2 text-right pull-right">
              <a class="btn btn-warning" href="{{ url('lista/contas')}}" ><i class="fa fa-usd"></i> Voltar a Lista</a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="row list-contacts">
                <div class="col-md-1">
                  ID
                </div>
                <div class="col-md-6">
                  Razão Social
                </div>
                <div class="col-md-4">
                  Nome Fantasia
                </div>
                <div class="col-md-1">
                  Detalhes
                </div>
              </div>
              @foreach($contatos as $key => $contato)
                <div class="row list-contacts" onclick="selectRow({{$contato->id}})">
                  <div class="col-md-1">
                    <span class="label label-info">ID: {{$contato->id}}</span>
                  </div>
                  <div class="col-md-6">
                    {{$contato->nome}}
                    @if ($contato->tipo=="1"){{ $contato->sobrenome }}@endif
                    @if ($contato->id=="1")<span class="label label-danger">Matriz</span> @endif
                  </div>
                  <div class="col-md-4">
                     @if ($contato->tipo!="1"){{ $contato->sobrenome }}@endif
                  </div>
                  <div class="col-md-1">
                    <span class="label label-primary">{{date('d/m/Y', strtotime($contato->created_at))}}</label>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 text-center">
              {{ $contatos->links() }}
            </div>
          </div>

          <script>
            function selectRow(id){
              $("#ids").val(id);
              $("#buttonNovo").attr('href', '{{{ (isset($is_consumos) and $is_consumos=="1") ? url('/novo/consumos/') : url('/novo/contas')}}}/'+id);
            }
            </script>
@endsection
