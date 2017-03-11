<?php use Carbon\Carbon; ?>
@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-usd fa-1x"></i> Contas
        </div>
        <div class="panel-body">
          {{ csrf_field() }}
          <div id="secondNavbar" class="row">
            <div class="row">
              <div class="col-md-4 text-left" >
                <div class=" form-inline col-md-7 text-right">
                  @ifPerms(contas*edicao)
                    @botaoDelete
                    @botaoEditar
                  @endPerms
                  @botaoDetalhes
                  @botaoAnexos
                  @ifPerms(contas*edicao)
                    <a href="{{ url('/lista/contas') }}/id/pago"  id="buttonPagar" title="Creditar" class="btn btn-success">
                      <i class="fa fa-check"></i>
                    </a>
                  @endPerms
                </div>
                <div class=" form-inline col-md-2 text-left">
                  @idSelecionado
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group form-inline text-center">
                  @buscaSimples(lista/contas)
                  @buscaExtraBotao
                </div>
              </div>
              <div class="col-md-2 pull-right">
                @ifPerms(contas*adicao)
                @botaoNovo(contas*consumos*Nova conta*Novo consumo)
                @endPerms
              </div>
            </div>
            <div id="buscaAvançada" class="row collapse " aria-expanded="" style="background-color: #fff; z-index:1030;">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="data_de">Vencimento <span class="label label-info">de</span></label>
                  <input type="text" class="form-control datepicker" name="data_de" id="data_de" placeholder="">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="data_ate">Vencimento data <span class="label label-info">ate</span></label>
                  <input type="text" class="form-control datepicker" name="data_ate" id="data_ate" placeholder="">
                </div>
              </div>
              <div class="col-md-4">
                <label><input type="checkbox" name="credito">Credito</label>
                <label><input type="checkbox" name="debito">Debito</label>
                <label><input type="checkbox" name="vencer">A vencer</label>
                <label><input type="checkbox" name="vencido">Vencidos</label>
                <label><input type="checkbox" name="pago">Pago</label>
                <label><input type="checkbox" name="pagar">Não pago</label>
                <label><input type="checkbox" name="referencia">Referencias</label>
                <label><input type="checkbox" name="parcelas">Parcelas</label>
              </div>
              @if (isset(Auth::user()->perms["admin"]) and Auth::user()->perms["admin"]==1)
                <div class="col-md-2 pull-right">
                  <input type="checkbox"name="deletados" id="deletados"   >
                  <span id="deletadosText">buscar com deletados</span>
                </div>
              @endif
            </div>
          </div>
          <div id="listaHolder"></div>
        </div>
      </div>
    </div>
  </div>
<script>
$(document).ready(function(){
  efetuarBusca();
});
  function selectRow(id){
    $("#ids").val(id);
    $("#botaoDelete").attr('href', '{{ url('lista/contas') }}/'+id+'/delete/');
    $("#botaoEditar").attr('href', '{{ url('novo/contas') }}/'+id);
    $("#botaoDetalhes").attr('onclick', 'openModal("{{url('lista/contas')}}/'+id+'")');
    $("#botaoAnexos").attr('onclick', 'openModal("{{url('lista/contas')}}/'+id+'/attachs")');
    $("#buttonPagar").attr('href', '{{ url('/lista/contas') }}/'+id+'/pago');
  }
  function listaTop(){
    var css = $('#listaHolder').css('margin-top');
    if(css == "75px"){
      $('#listaHolder').css('margin-top', '0px');
    } else {
      $('#listaHolder').css('margin-top', '75px');
    }
  }
</script>
@endsection
