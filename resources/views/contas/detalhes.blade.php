<?php use Carbon\Carbon; ?>
<div class="modal-dialog modal-lg extra" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="addTelefonesLabel">
        Detalhes da movimentação bancaria:
      </h4>
    </div>
    <div class="modal-body">
      @if ($conta->tipo=="2" and isset($conta->consumo))

          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#detalhes" aria-controls="detalhes" role="tab" data-toggle="tab">Detalhes</a></li>
            <li role="presentation"><a href="#consumos" aria-controls="consumos" role="tab" data-toggle="tab">Consumos</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane" id="consumos"><br>
              <div class="row">
                <div class="col-md-6">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <div class="col-md-6">
                        @if ($conta->nome=="1001")
                          <strong>Identificação
                        @elseif ($conta->nome=="1002")
                          <strong>Seu codigo
                        @elseif($conta->nome=="1003")
                          <strong>D.M.
                        @elseif($conta->nome=="1004")
                          <strong>D.M.
                        @else
                          <strong>D.M.
                        @endif
                        :</strong> {{$conta->consumo->codigo}}<br>
                        <strong>
                          @if ($conta->nome=="1001")
                            Mes/Ano
                          @elseif ($conta->nome=="1002")
                            Mes/Ano
                          @elseif($conta->nome=="1003")
                            Mes/Ano
                          @elseif($conta->nome=="1004")
                            Mes/Ano
                          @else
                            Mes/Ano
                          @endif
                          :
                        </strong>
                        {{$conta->consumo->mes}}<br>
                        <strong>
                          @if ($conta->nome=="1001")
                            Consumo:</strong> {{$conta->consumo->consumo}} lts
                          @elseif ($conta->nome=="1002")
                            Consumo:</strong> {{$conta->consumo->consumo}} kWH
                          @elseif($conta->nome=="1003")
                            Consumo:</strong> {{$conta->consumo->consumo}}
                          @elseif($conta->nome=="1004")
                            Consumo:</strong> {{$conta->consumo->consumo}}
                          @else
                            Consumo:</strong> {{$conta->consumo->consumo}}
                          @endif
                        @if ($conta->nome=="1001")
                          <br>
                          <strong>Categoria:</strong> {{$conta->consumo->cat}}
                        @endif
                      </div>
                      <div class="col-md-6">
                        @if ($conta->nome=="1001")
                          <strong>Leitura Anterior:</strong> {{$conta->consumo->valor_anterior}} lts
                        @elseif ($conta->nome=="1002")
                          <strong>Preço medio:</strong> R$ {{$conta->consumo->valor_anterior}}
                        @elseif($conta->nome=="1003")
                          <strong>Consumo:</strong> {{$conta->consumo->consumo}}
                        @elseif($conta->nome=="1004")
                          <strong>Consumo:</strong> {{$conta->consumo->consumo}}
                        @else
                          <strong>Consumo:</strong> {{$conta->consumo->consumo}}
                        @endif
                        <br>
                        @if ($conta->nome=="1001")
                          <strong>Leitura atual:</strong> {{$conta->consumo->valor_atual}} lts
                        @endif
                        <br>
                        @if ($conta->nome=="1001")
                          <strong>Valor agua:</strong> R$ {{$conta->consumo->sub_item1}}
                        @elseif ($conta->nome=="1002")
                          <strong>Valor:</strong> R$ {{$conta->consumo->sub_item1}}
                        @endif
                      </span><br>
                      @if ($conta->nome=="1001")
                        <strong>Valor Esgoto:</strong> R$ {{$conta->consumo->sub_item2}}
                      @endif
                    </span>
                  </div>

                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      @if ($conta->discs!='[]')
                        <div class="row">
                          <div class="col-md-12 text-center h3">
                            Descrição da conta
                          </div>
                        </div>
                        @foreach($conta->discs as $key => $disc)
                          <div class="row list-contacts">
                            <div class="col-md-1">
                              <span class="label label-info">
                                ID: {{$disc->id}}
                              </span>
                            </div>
                            <div class="col-md-6 text-right">
                              {{$disc->nome}}
                            </div>
                            <div class="col-md-2 text-left">
                              R$ {{ $disc->valor}}
                            </div>
                          </div>
                        @endforeach
                      @endif
                      <div class="row">
                        <div class="col-md-12 text-center">

                          @php $total_disc = 0; @endphp
                          @foreach($conta->discs as $key => $disc)
                            @php $total_disc = $total_disc + $disc->valor; @endphp
                          @endforeach
                          <div class="row list-contacts">
                            <div class="col-md-7 text-right">
                                <strong>Total:</strong>
                            </div>
                            <div class="col-md-2 text-left">
                              <span class=" ">R$ {{$total_disc}}</span>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div role="tabpanel" class="tab-pane active" id="detalhes"><br>
      @endif
      <div class="row">
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-2">
                  <strong>ID:</strong>
                </div>
                <div class="col-md-10">
                  {{$conta->id}}
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <strong>Entidade:</strong>
                </div>
                <div class="col-md-8">
                  {{$conta->contatos->nome}}
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <strong>Tipo:</strong>
                </div>
                <div class="col-md-8">
                  @if ($conta->tipo==0)
                    <span class="">Debito</span>
                  @elseif ($conta->tipo==1)
                    <span class="">Credito</span>
                  @elseif ($conta->tipo==2)
                    <span class="">Conta de consumo</span>
                  @endif
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <strong>Referecia:</strong>
                </div>
                <div class="col-md-8">
                  @if ($conta->tipo=="2")
                    {{{$conta->nome=="1001" ? "Conta de Agua" : ""}}}
                    {{{$conta->nome=="1002" ? "Conta de Energia Eletrica" : ""}}}
                    {{{$conta->nome=="1003" ? "Internet e Telefone" : ""}}}
                    {{{$conta->nome=="1004" ? "Gas encanado" : ""}}}
                  @else
                    {{$conta->nome}}
                  @endif
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <strong>Vencimento:</strong>
                </div>
                <div class="col-md-8">
                  @if (strtotime($conta->vencimento)>strtotime(Carbon::now()))
                    <span class="">
                    @else
                      <span class="">
                      @endif
                      {{$conta->vencimento}}
                    </span>
                  </div>
                </div>
              <div class="row">
                <div class="col-md-2">
                  <strong>Valor:</strong>
                </div>
                <div class="col-md-8">
                  R$ {{money_format('%n', $conta->valor)}}
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <strong>Estado:</strong>
                </div>
                <div class="col-md-8">
                  @if ($conta->estado==0 AND ($conta->tipo==0 OR $conta->tipo==2))
                    <span class="">A pagar</span>
                  @elseif ($conta->estado==0 AND ($conta->tipo==1 OR $conta->tipo==2))
                    <span class="">A receber</span>
                  @elseif ($conta->estado==1 AND ($conta->tipo==0 OR $conta->tipo==2))
                    <span class="">Pago</span>
                  @elseif ($conta->estado==1 AND ($conta->tipo==1 OR $conta->tipo==2))
                    <span class="">Recebido</span>
                  @endif
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <strong>Lançado:</strong>
                </div>
                <div class="col-md-8">
                  {{date('d/m/Y', strtotime($conta->created_at))}}
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <strong>Usuario:</strong>
                </div>
                <div class="col-md-8">
                  {{isset($conta->usuario) ? $conta->usuario->nome :""}}
                </div>
              </div>
            </div>
          </div>
        </div>
        @if (isset($conta->banco->banco))
          <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-2">
                  <strong>Banco:</strong>
                </div>
                <div class="col-md-8">
                  {{$conta->banco->banco->sobrenome}}
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <strong>Agencia:</strong>
                </div>
                <div class="col-md-8">
                  {{$conta->banco->agencia}}
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <strong>CC: </strong>
                </div>
                <div class="col-md-8">
                  {{$conta->banco->cc}}-{{$conta->banco->cc_dig}}
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <strong>Saldo:</strong>
                </div>
                <div class="col-md-8">
                  R$ {{money_format("%n", $conta->banco->valor)}}
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
      @if ($conta->tipo=="2" and isset($conta->consumo))
            </div>
          </div>
      @endif

      <div class="row">
        <div class="col-md-12">
          @if (count($conta->referencia->parcelas)>1)
            <div class="row">
              <div class="col-md-12">
                @foreach($conta->referencia->parcelas as $key => $parcela)
                    <div class="row list-contacts">
                      <div class="col-md-2 limitar-string">
                        Parcela {{$key+1}}/{{count($conta->referencia->parcelas)}}
                      </div>
                      <div class="col-md-1 limitar-string">
                        @if (strtotime($parcela->vencimento)>strtotime(Carbon::now()))
                          <span class="label label-warning">
                        @else
                          <span class="label label-danger">
                        @endif
                          {{date('d/m/Y', strtotime($parcela->vencimento))}}
                        </span>
                      </div>
                      <div class="col-md-2">
                        R$ {{ number_format($parcela->valor, 2) }}
                      </div>

                      <div class="col-md-2">
                        @if ($parcela->estado==0 AND $parcela->tipo==0)
                          <span class="label label-danger">A pagar</span>
                        @elseif ($parcela->estado==0 AND $conta->tipo==1)
                          <span class="label label-danger">A receber</span>
                        @elseif ($parcela->estado==1 AND $parcela->tipo==0)
                          <span class="label label-success">Pago</span>
                        @elseif ($parcela->estado==1 AND $parcela->tipo==1)
                          <span class="label label-success">Recebido</span>
                        @endif
                      </div>
                    </div>
                @endforeach
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
    <div class="modal-footer">
      @botaoFecharModal
      @ifPerms(contas*edicao)
        @botaoEditarExtenso(novo/contas*$conta->id)
      @endPerms
      <!--<a href="{{ url('/novo/contas/editar') }}/{{$conta->id}}"><button type="submit" class="btn btn-primary">Editar</button></a>-->
    </div>
  </div>
</div>
