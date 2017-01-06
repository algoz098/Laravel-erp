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
        <div class="panel-body">
          <div class="row">
            <div class="col-md-3 text-right pull-right">
              <a class="btn btn-warning" href="{{ url('lista/atendimentos')}}" ><i class="fa fa-list"></i> Voltar a Lista</a>
            </div>
          </div>
          <div class="row pull-center">
            <div class="col-md-12">
              <form method="POST" action="{{ url('novo/atendimentos') }}/busca">
                <div class="form-group form-inline text-center">
                  {{ csrf_field() }}
                  <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca" size="10">
                  <button type="submit" class="btn btn-success" id="buscar" >Buscar</button>
                </div>
              </form>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 h4">
              @foreach($contatos as $key => $contato)
                <div class="row list-contacts">
                  <div class="col-md-2 text-right">
                    <a class="btn btn-info" onclick="
                                                      $('#form').show();
                                                      $('#contato').val('{{$contato->nome}}');
                                                      $('#contatos_id').val('{{$contato->id}}');
                    ">
                      <i class="fa fa-gear"></i>
                    </a>
                  </div>
                  <div class="col-md-8">
                    {{$contato->nome}}
                  </div>
                </div>
              @endforeach

              <div class="row">
                <div class="col-md-12 text-center">
                  {{ $contatos->links() }}
                </div>
              </div>
            </div>
            <div class="col-md-7" style="display: none;" id="form">
              <form method="POST" action="{{ url('novo/atendimentos') }}">
                {{ csrf_field() }}
                <div class="form-group">
                  <label>Atendimento para</label>
                  <input type="text" class="form-control" name="contato" id="contato" value="" disabled>
                  <input type="hidden" class="form-control" name="contatos_id" id="contatos_id" value="">
                </div>
                <div class="form-group">
                  <label>Assunto</label>
                  <select class="form-control" ="assunto" id="assunto" >
                    <option selected>- Escolha o assunto - </option>
                    @foreach($comboboxes as $key => $combobox)
                      <option value="{{$combobox->value}}">{{$combobox->text}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Data</label>
                  <input type="text" class="form-control" name="data" value="{{Carbon::now()}}" id="datepicker">
                </div>
                <div class="form-group">
                  <label for="text">Descrição </label>
                  <textarea rows="5" class="form-control" id="froala-editor" name="texto">
                  </textarea>
                </div>
                <button type="submit" class="btn btn-success" id="enviar" >Enviar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script language="javascript">
    $( function() {
      $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
    } );
  </script>
@endsection
