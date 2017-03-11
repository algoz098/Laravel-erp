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
              <div class="col-md-3 text-left" >
                <div class=" form-inline col-md-8 text-right">
                  @ifPerms(bancos*edicao)
                    @botaoDelete
                    @botaoEditar
                  @endPerms
                  @botaoDetalhes
                </div>
                <div class=" form-inline col-md-2 text-left">
                  @idSelecionado
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group form-inline text-center">
                  @buscaSimples(lista/bancos)
                  @buscaExtraBotao
                </div>
              </div>
              <div class="col-md-2 pull-right">
                @ifPerms(bancos*adicao)
                  @botaoNovo(bancos)
                @endPerms
              </div>
            </div>
            <div id="buscaAvançada" class="row collapse " aria-expanded="" style="background-color: #fff; z-index:1030;">
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
$(document).ready(function (){
  efetuarBusca();
});
  function selectRow(id){
    $("#ids").val(id);
    $("#botaoDelete").attr('href', '{{ url('lista/bancos') }}/'+id+'/delete/');
    $("#botaoDetalhes").attr('onclick', 'openModal("{{url('lista/bancos')}}/'+id+'")');
    $("#botaoAnexos").attr('onclick', 'openModal("{{url('lista/bancos')}}/'+id+'/attachs")');
    $("#botaoEditar").attr('href', '{{ url('/novo/bancos') }}/'+id);
  }
  function listaTop(){
    var css = $('#lista').css('margin-top');
    if(css == "75px"){
      $('#lista').css('margin-top', '0px');
    } else {
      $('#lista').css('margin-top', '75px');
    }
  }
</script>
@endsection
