<?php
use Carbon\Carbon;
?>

@extends('main')
@section('header')
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script src="{{ asset('js/app.js') }}"></script>
@endsection
@section('content')

  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-list fa-1x"></i> Novo atendimento
        </div>
        <form method="POST" action="{{ isset($atendimento) ? $atendimento->id : url('novo/atendimentos') }}">
          {{ csrf_field() }}
          <div class="panel-body">
            <div class="row" id="secondNavbar">
              <div class="col-md-3 text-right pull-right">
                @botaoLista(atendimentos*fa-list)
                @botaoSalvar
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                @if(isset($atendimento))
                  @selecionaContato(Atendimento para:*$atendimento->contatos->id*$atendimento->contatos->nome)
                @else
                  @selecionaContato(Atendimento para:)
                @endif
                <div class="form-group">
                  <label>Assunto</label>
                  <select class="form-control" name="assunto" id="assunto" >
                    @if (isset($atendimento))
                      <option value="{{$atendimento->assunto}}" selected>{{$atendimento->assunto}} (Atual)</option>
                    @else
                      <option selected>- Escolha o assunto - </option>
                    @endif
                    @foreach($comboboxes as $key => $combobox)
                      <option value="{{$combobox->value}}">{{$combobox->text}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Data</label>
                  <input type="text" class="form-control" name="data" value="{{Carbon::now()}}" id="datepicker" value="{{isset($atendimento) ? $atendimento->data : ""}}">
                </div>
              </div>
              <div class="col-md-9">
                <div class="form-group">
                  <label for="text">Descrição </label>
                  <textarea rows="5" class="form-control" id="froala-editor" name="texto">
                    {!!isset($atendimento) ? $atendimento->texto : ""!!}
                  </textarea>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>
  <script language="javascript">
    $( function() {
      $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
    } );

  </script>
@endsection
