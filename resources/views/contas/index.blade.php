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
                    @buscaSimples
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
          </form>

          <div class="row" id="lista">
            <div class="col-md-1">
              ID
            </div>
            <div class="col-md-2">
              Entidade
            </div>
            <div class="col-md-2">
              Valor
            </div>
            <div class="col-md-2">
              Vencimento
            </div>
            <div class="col-md-2">
              Estado
            </div>
            <div class="col-md-2">
              Banco
            </div>
          </div>
          @foreach($contas as $key => $conta)
            <div class="row list-contacts" onclick="selectRow({{$conta->id}})" style="background-color: rgba(@if ($conta->tipo!="1") 244, 67, 54, @else 139, 195, 74, @endif 0.25);">
              <div class="col-md-1" >
                <span class="label label-info">
                  ID: {{$conta->id}}
                </span>
              </div>
              <div class="col-md-2">
                <a onclick="openModal('{{url('lista/contatos')}}/{{$conta->contatos->id}}')" class="label label-primary">
                  <i class="fa fa-user"></i>
                  {{str_limit($conta->contatos->nome,15)}}
                </a>
              </div>
              <div class="col-md-2 ">
                <span >
                  R$ {{ number_format($conta->valor, 2) }}
                </span>
              </div>
              <div class="col-md-2">
                <span >
                  {{date('d/m/Y', strtotime($conta->vencimento))}}
                </span>&nbsp
              </div>
              <div class="col-md-2">
                <span >
                  @if ($conta->estado==0 AND ($conta->tipo==0 OR $conta->tipo==2))
                    A pagar
                  @elseif ($conta->estado==0 AND ($conta->tipo==1 OR $conta->tipo==2))
                    A receber
                  @elseif ($conta->estado==1 AND ($conta->tipo==0 OR $conta->tipo==2))
                    Pago
                  @elseif ($conta->estado==1 AND ($conta->tipo==1 OR $conta->tipo==2))
                    Recebido
                  @endif
                </span>
              </div>
              <div class="col-md-2">
                @if (isset($conta->banco->banco))
                  @mostraContato($conta->banco->banco->id*$conta->banco->banco->sobrenome)
                @endif
              </div>
            </div>
          @endforeach
          <div class="row">
            <div class="col-md-12 text-center">
              <span class="label label-danger">
                Debito pagos: R$ {{ money_format('%n', $total_debito) }}
              </span>&nbsp
              <span class="label label-danger">
                Debito a pagar: R$ {{ money_format('%n', $total_apagar) }}
              </span>&nbsp
              <span class="label label-success">
                Credito recebidos: R$ {{ money_format('%n', $total_credito) }}
              </span>&nbsp
              <span class="label label-success">
                Credito a receber: R$ {{ money_format('%n', $total_areceber) }}
              </span>&nbsp
            </div>
          </div>
          <div class="row">
            <div class="col-md-10 text-center">
              {{ $contas->links() }}
            </div>
          </div>
          @if($deletados!==0)
            <h3>Deletados</h3>
            @foreach($deletados as $key => $conta)
                <div class="row list-contacts">
                  <div class="col-md-2">
                    <a href="{{ url('lista/contas') }}/{{$conta->id}}/delete"  title="Restaurar" class="btn btn-danger">
                      <i class="fa fa-ban"></i>
                    </a>
                    <a href="{{ url('/contatos') }}/{{$conta->contatos->id}}"  title="Detalhes do contato" class="btn btn-info">
                      <i class="fa fa-user"></i>
                    </a>
                  </div>
                  <div class="col-md-3">
                    {{$conta->nome}}
                    <span class="label label-warning">R$ {{ number_format($conta->valor, 2) }}</label>
                  </div>
                  <div class="col-md-6">
                    @if ($conta->tipo==0)
                      <span class="label label-warning">Debito</span>
                    @elseif ($conta->tipo==1)
                      <span class="label label-warning">Credito</span>
                    @endif
                    @if ($conta->estado==0 AND $conta->tipo==0)
                      <span class="label label-danger">A pagar</span>
                    @elseif ($conta->estado==0 AND $conta->tipo==1)
                      <span class="label label-danger">A receber</span>
                    @elseif ($conta->estado==1 AND $conta->tipo==0)
                      <span class="label label-success">Pago</span>
                    @elseif ($conta->estado==1 AND $conta->tipo==1)
                      <span class="label label-success">Recebido</span>
                    @endif
                    @if (strtotime($conta->vencimento)>strtotime(Carbon::now()))
                      <span class="label label-warning">
                    @else
                      <span class="label label-danger">
                    @endif
                      {{date('d/m/Y', strtotime($conta->vencimento))}}
                    </span> -
                     {{$conta->descricao}}
                  </div>
                </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
<script>
  function selectRow(id){
    $("#ids").val(id);
    $("#botaoDelete").attr('href', '{{ url('lista/contas') }}/'+id+'/delete/');
    $("#botaoEditar").attr('href', '{{ url('novo/contas') }}/'+id);
    $("#botaoDetalhes").attr('onclick', 'openModal("{{url('lista/contas')}}/'+id+'")');
    $("#botaoAnexos").attr('onclick', 'openModal("{{url('lista/contas')}}/'+id+'/attachs")');
    $("#buttonPagar").attr('href', '{{ url('/lista/contas') }}/'+id+'/pago');
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
