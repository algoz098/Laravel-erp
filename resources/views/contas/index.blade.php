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
            <div id="secondNavbar" class="row">
              <div class="row">
                <div class="col-md-3 text-left" >
                  <div class=" form-inline col-md-10 text-right">
                    <a href="{{ url('lista/contas') }}/id/delete"  id="buttonDelete" title="Apagar" class="btn btn-danger">
                      <i class="fa fa-ban"></i>
                    </a>
                    <a class="btn btn-info"  id="buttonDetalhes" title="Detalhes" >
                      <i class="fa fa-file-text-o"></i>
                    </a>
                    <span id="buttonAttach" class="btn btn-warning btn_xs" title="Anexos">
                      <i class="fa fa-paperclip"></i>
                    </span>

                    <a href="{{ url('/lista/contas') }}/id/pago"  id="buttonPagar" title="Creditar" class="btn btn-success">
                      <i class="fa fa-check"></i>
                    </a>

                  </div>
                  <div class=" form-inline col-md-2 text-left">
                    <input type="text" class="form-control" size="4" name="ids" id="ids" placeholder="Detalhes" disabled>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-inline text-center ajuda-popover"
                        title="Busca"
                        data-content="Digite para buscar um contato"
                        data-placement="top"
                  >
                    {{ csrf_field() }}
                    <input type="text" class="form-control" name="contato" id="busca" placeholder="Busca">
                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                    <a class="btn btn-info"  title="Busca Avançada" data-toggle="collapse" data-target="#buscaAvançada" aria-expanded="" onclick="listaTop()">
                      <i class="fa fa-search-plus"></i>
                    </a>
                  </div>
                </div>
                <div class="col-md-2 pull-right ajuda-popover"
                      title="Novo"
                      data-content="Adicione uma nova conta"
                      data-placement="left">

                  <div class="btn-group">
                    <a href="{{ url('/novo/contas') }}" class="btn btn-success">
                      <i class="fa fa-plus fa-1x"></i> Novo
                    </a>
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{ url('/novo/consumos') }}">Novo Consumo</a></li>
                      <li><a href="{{ url('/novo/contas') }}">Nova Conta</a></li>
                    </ul>
                  </div>
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
            <div class="col-md-3">
              Assunto
            </div>
            <div class="col-md-1">
              Valor
            </div>
            <div class="col-md-1">
              Tipo
            </div>
            <div class="col-md-1">
              Estado
            </div>
            <div class="col-md-1">
              Vencimento
            </div>
            <div class="col-md-2">
              A quem
            </div>
            <div class="col-md-1 pull-right">
              Criado em
            </div>
          </div>
          @foreach($contas as $key => $conta)
            <div class="row list-contacts" onclick="selectRow({{$conta->id}})">
              <div class="col-md-1" >
                <span class="label label-{{{$conta->tipo!="1" ? "danger" : "success"}}}">
                  ID: {{$conta->id}}
                </span>
              </div>
              <div class="col-md-3 ">
                @if ($conta->tipo=="2")
                  {{{ substr($conta->nome, 0, 4)=="1001" ? "Conta de Agua" : ""}}}
                  {{{ substr($conta->nome, 0, 4)=="1002" ? "Conta de Energia Eletrica" : ""}}}
                  {{{ substr($conta->nome, 0, 4)=="1003" ? "Internet e Telefone" : ""}}}
                  {{{ substr($conta->nome, 0, 4)=="1004" ? "Gas encanado" : ""}}}
                  {{substr($conta->nome, 4)}}
                @else
                  {{$conta->nome}}
                @endif
              </div>
              <div class="col-md-1 ">
                <span class="label label-{{{$conta->tipo!="1" ? "danger" : "success"}}}">
                  R$ {{ number_format($conta->valor, 2) }}
                </span>
              </div>

              <div class="col-md-1">
                <span class="label label-{{{$conta->tipo!="1" ? "danger" : "success"}}}">
                  @if ($conta->tipo==0)
                    Debito
                  @elseif ($conta->tipo==1)
                    Credito
                  @elseif ($conta->tipo==2)
                    Consumo
                  @endif
                </span>
              </div>
              <div class="col-md-1">
                <span class="label label-{{{$conta->tipo!="1" ? "danger" : "success"}}}">
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
              <div class="col-md-1">
                <span class="label label-{{{$conta->tipo!="1" ? "danger" : "success"}}}">
                  {{date('d/m/Y', strtotime($conta->vencimento))}}
                </span>&nbsp
              </div>
              <div class="col-md-2">
                <a onclick="openModal('{{url('lista/contatos')}}/{{$conta->contatos->id}}')" class="label label-primary">
                  <i class="fa fa-user"></i>
                  {{str_limit($conta->contatos->nome,15)}}
                </a>
              </div>
              <div class="col-md-1 pull-right">
                <span class="label label-{{{$conta->tipo!="1" ? "danger" : "success"}}}">
                  {{date('d/m/Y', strtotime($conta->created_at))}}
                </span>
              </div>
            </div>
            <!-- Modal detalhes-->

          @endforeach
          <hr>
          <div class="row">
            <div class="col-md-10 text-center">
              <span class="label label-danger">
                Debito pagos: {{ $total_debito }}
              </span>&nbsp
              <span class="label label-primary">
                Credito recebidos: {{ $total_credito }}
              </span>&nbsp
              <span class="label label-primary">
                Total atualmente: {{ $total_atual }}
              </span>
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
    $("#buttonDelete").attr('href', '{{ url('lista/contas') }}/'+id+'/delete/');
    $("#buttonEdit").attr('href', '{{ url('novo/contas') }}/'+id);
    $("#buttonPagar").attr('href', '{{ url('/lista/contas') }}/'+id+'/pago');
    $("#buttonDetalhes").attr('onclick', 'openModal("{{url('lista/contas')}}/'+id+'")');
    $("#buttonAttach").attr('onclick', 'openModal("{{url('lista/contas')}}/'+id+'/attachs")');
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
