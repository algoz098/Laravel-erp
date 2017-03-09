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
          <form method="POST" action="{{ url('/lista/contas') }}/">
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
                    @buscaSimples
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
          </form>

          <div class="row" id="lista">
            <div class="col-md-1">
              ID
            </div>
            <div class="col-md-2">
              Filial
            </div>
            <div class="col-md-1">
              Banco
            </div>
            <div class="col-md-2">
              Tipo
            </div>
            <div class="col-md-1">
              Agencia
            </div>
            <div class="col-md-1">
              CC/Dig
            </div>
            <div class="col-md-1">
              Comp
            </div>
            <div class="col-md-1">
              Em conta
            </div>
            <div class="col-md-1 pull-right">
              Criado em
            </div>
          </div>
          @foreach($bancos as $key => $banco)
            <div class="row list-contacts" onclick="selectRow({{$banco->id}})">
              <div class="col-md-1" >
                <span class="label label-info">
                  ID: {{$banco->id}}
                </span>
              </div>
              <div class="col-md-2 ">
                @mostraContato($banco->contato->id*$banco->contato->sobrenome)
              </div>
              <div class="col-md-1 ">
                @if (isset($banco->banco->id))
                  @mostraContato($banco->banco->id*$banco->banco->sobrenome)
                @else
                  N/C
                @endif
              </div>

              <div class="col-md-2">
                {{$banco->tipo}}
              </div>
              <div class="col-md-1">
                {{$banco->agencia}}
              </div>
              <div class="col-md-1">
                {{$banco->cc}}-{{$banco->cc_dig}}
              </div>
              <div class="col-md-1">
                {{$banco->comp}}
              </div>
              <div class="col-md-1">
                R$ {{money_format('%.2n', $banco->valor)}}
              </div>
              <div class="col-md-1 pull-right">
                <span class="label label-{{{$banco->tipo!="1" ? "danger" : "success"}}}">
                  {{date('d/m/Y', strtotime($banco->created_at))}}
                </span>
              </div>
            </div>
          @endforeach
          <div class="row">
            <div class="col-md-10 text-center">
              {{ $bancos->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script>
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
