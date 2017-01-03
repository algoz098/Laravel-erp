<?php
use Carbon\Carbon;
$atual = 0;
foreach ($caixas as $key => $caixa) {
  if($caixa->forma==0){
    $atual = $atual+$caixa->valor;
  } elseif ($caixa->forma==1) {
    $atual = $atual-$caixa->valor;
  }
}
?>
@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-money fa-1x"></i> Movimentações e Caixa
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-11 ajuda-popover"
                  title="Resumo"
                  data-content="Informações resumidas sobre o caixa desta filial."
                  data-placement="left">
              <span class="label label-primary">Caixa:{{ Auth::user()->trabalho->id }}</span>&nbsp
              <span class="label label-primary">
                Estado:
                @if (is_array($caixas))
                  @if ($caixas->last()->tipo==0 or $caixas->last()->tipo==2) Aberto
                  @elseif ($caixas->last()->tipo==1) Fechado @endif
                @endif
              </span>&nbsp
              <span class="label label-primary">Atualmente: R$&nbsp{{ number_format($atual, 2) }}</span>&nbsp
            </div>
            <div class="col-md-1 pull-right text-right">
              <a href="{{ url('/novo/caixa') }}" class="btn btn-success ajuda-popover"
                    title="Novo"
                    data-content="Adicione uma nova movimentação"
                    data-placement="left"><i class="fa fa-plus"></i> Novo</a>
            </div>
          </div><br>
          <div class="row">
            <div class="col-md-12  ">
              <form method="POST" action="{{ url('/lista/caixa') }}/">
                <div class="form-group form-inline text-center">
                  {{ csrf_field() }}
                  @if (isset(Auth::user()->perms["admin"]) and Auth::user()->perms["admin"]==1)
                    <label><input type="checkbox" name="deletados">Mostrar deletados</label>
                  @endif
                  <select class="form-control" id="tipo" name="tipo">
                    <option value="" selected>Tipo</option>
                    <option value="1">Debito</option>
                    <option value="0" >Credito</option>
                  </select>
                  <input type="text" class="form-control datepicker ajuda-popover"
                        title="Busca"
                        data-content="Selecione e preencha apenas o que precisa filtrar, o sistema ignora os filtros não preenchidos."
                        data-placement="top" size="8" name="data" placeholder="Data" id="data">
                  <button type="submit" class="btn btn-success">Buscar</button>
                </div>
              </form>
            </div>
          </div>
          @foreach($caixas as $key => $caixa)
            <div class="row list-contacts">
              <div class="col-md-1 ajuda-popover"
                  @if ($key==0)
                    title="Opções"
                    data-content="Deletar, detalhes, aumentar e diminuir estoque."
                    data-placement="bottom"
                  @endif
              >
                <a href="{{ url('lista/caixa') }}/{{$caixa->id}}/delete"  title="Apagar" class="btn btn-danger">
                  <i class="fa fa-ban"></i>
                </a>
              </div>
              <div class="col-md-2 ajuda-popover"
                  @if ($key==0)
                    title="Informações"
                    data-content="Tipo de movimentação, valor e Entrada/Saida de valores."
                    data-placement="top"
                  @endif
              >
                @if ($caixa->tipo==0)
                  <span class="label label-info">Abertura</span>
                @elseif ($caixa->tipo==1)
                  <span class="label label-info">Fechamento</span>
                @elseif ($caixa->tipo==2)
                  <span class="label label-primary">Movimentação</span>
                @endif
                </span>
                <span class="label label-warning">R$ {{ number_format($caixa->valor, 2) }}</span>

                @if ($caixa->forma=="0")
                  <span class="label label-success">Credito</span>
                @elseif ($caixa->forma=="1")
                  <span class="label label-danger">Debito</span>
                @endif
                </span>
              </div>
              <div class="col-md-6 ajuda-popover"
                  @if ($key==0)
                    title="Detalhes"
                    data-content="Filial a quem pertence a movimentação, e outros detalhes."
                    data-placement="bottom"
                  @endif
              >
                <a href="{{ url('/contatos') }}/{{$caixa->contato->id}}" class="label label-success">
                  <i class="fa fa-user"></i> {{$caixa->contato->nome}}
                </a>
              </div>
            </div>
          @endforeach
          <div class="row">
            <div class="col-md-12 text-center">
              {{ $caixas->links() }}
            </div>
          </div>
          @if($deletados!==0)
            <h3>Deletados</h3>
            @foreach($deletados as $key => $caixa)
              <div class="row list-contacts">
                <div class="col-md-1">
                  <a href="{{ url('lista/caixa') }}/{{$caixa->id}}/delete"  title="Restaurar" class="btn btn-success">
                    <i class="fa fa-check"></i>
                  </a>
                </div>
                <div class="col-md-3">
                  @if ($caixa->tipo==0)
                    <span class="label label-info">Abertura</span>
                  @elseif ($caixa->tipo==1)
                    <span class="label label-info">Fechamento</span>
                  @elseif ($caixa->tipo==2)
                    <span class="label label-primary">Movimentação</span>
                  @endif
                  </span>
                  <span class="label label-warning">R$ {{ number_format($caixa->valor, 2) }}</span>

                  @if ($caixa->forma=="0")
                    <span class="label label-success">Credito</span>
                  @elseif ($caixa->forma=="1")
                    <span class="label label-danger">Debito</span>
                  @endif
                  </span>
                </div>
                <div class="col-md-6">
                  <a href="{{ url('/contatos') }}/{{$caixa->contato->id}}" class="label label-success">
                    <i class="fa fa-user"></i> {{$caixa->contato->nome}}
                  </a>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
  <script>
    $( function() {
      $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
    } );
  </script>
@endsection
