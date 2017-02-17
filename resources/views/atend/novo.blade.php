<?php
use Carbon\Carbon;
?>
@extends('main')
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
                <a class="btn btn-warning" href="{{ url('lista/atendimentos')}}" ><i class="fa fa-list"></i> Voltar a Lista</a>
                <button type="submit" class="btn btn-success" id="enviar" ><i class="fa fa-check"></i> Salvar</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="por">Atendimento para:</label>
                  <div class="input-group">
                    <input type="hidden" class="form-control" id="contatosHidden" name="contatos_id" value="{{isset($atendimento) ? $atendimento->contatos->id : ""}}">
                    <input type="text" class="form-control" id="contatos" disabled value="{{isset($atendimento) ? $atendimento->contatos->nome : ""}}">
                    <a onclick="window.activeTarget='contatos'; openModal('{{url('lista/contatos/selecionar')}}')" class="input-group-addon btn btn-info"><i class="fa fa-gear"></i></a>
                  </div>
                </div>
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
