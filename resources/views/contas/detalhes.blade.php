<?php use Carbon\Carbon; ?>
<div class="modal-dialog modal-lg extra" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="addTelefonesLabel">
        Detalhes da conta:
      </h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-1 h3">
          <span class="label label-primary">
            ID: {{$conta->id}}
          </span>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
            <span class="label label-info">
              <i class="fa fa-user"></i> {{$conta->contatos->nome}}
            </span><br>
            @if ($conta->tipo==0)
              <span class="label label-warning">Debito</span>
            @elseif ($conta->tipo==1)
              <span class="label label-success">Credito</span>
            @elseif ($conta->tipo==2)
              <span class="label label-warning">Conta de consumo</span>
            @endif<br>
            @if ($conta->tipo=="2")
              {{{$conta->nome=="1001" ? "Conta de Agua" : ""}}}
              {{{$conta->nome=="1002" ? "Conta de Energia Eletrica" : ""}}}
              {{{$conta->nome=="1003" ? "Internet e Telefone" : ""}}}
              {{{$conta->nome=="1004" ? "Gas encanado" : ""}}}
            @else
              {{$conta->nome}}
            @endif
        </div>
        <div class="col-md-2">
          <span class="label label-info">{{$conta->pagamento}}</span><br>
          @if (strtotime($conta->vencimento)>strtotime(Carbon::now()))
            <span class="label label-warning">
          @else
            <span class="label label-danger">
          @endif
            {{$conta->vencimento}}
          </span><br>
          @if ($conta->referencia)
            <span class="label label-warning">
              R$ {{ number_format($conta->referencia->valor, 2) }}
            </span>
          @else
            <span class="label label-danger">
              Valor referente APAGADO
            </span>
          @endif
        </div>
        <div class="col-md-2">
          <span class="label label-info">R$ {{ number_format($conta->desconto, 2) }}</span><br>
          <span class="label label-info">{{$conta->dm}}</span><br>
          @if ($conta->estado==0 AND ($conta->tipo==0 OR $conta->tipo==2))
            <span class="label label-danger">A pagar</span>
          @elseif ($conta->estado==0 AND ($conta->tipo==1 OR $conta->tipo==2))
            <span class="label label-danger">A receber</span>
          @elseif ($conta->estado==1 AND ($conta->tipo==0 OR $conta->tipo==2))
            <span class="label label-success">Pago</span>
          @elseif ($conta->estado==1 AND ($conta->tipo==1 OR $conta->tipo==2))
            <span class="label label-success">Recebido</span>
          @endif
        </div>
      </div>
      @if ($conta->tipo=="2" and isset($conta->consumo))
        <hr>
        <div class="row">
          <div class="col-md-3">
            @if ($conta->nome=="1001")
              Identificação
            @elseif ($conta->nome=="1002")
              Seu codigo
            @elseif($conta->nome=="1003")
              D.M.
            @elseif($conta->nome=="1004")
              D.M.
            @else
              D.M.
            @endif                            :
            : <span class="label label-info">
              {{$conta->consumo->codigo}}
            </span><br>
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
            : <span class="label label-info">
               {{$conta->consumo->mes}}
            </span><br>
            @if ($conta->nome=="1001")
              Consumo: <span class="label label-info">
                 {{$conta->consumo->consumo}} lts
            @elseif ($conta->nome=="1002")
              Consumo: <span class="label label-info">
                 {{$conta->consumo->consumo}} kWH
            @elseif($conta->nome=="1003")
              Consumo: <span class="label label-info">
                 {{$conta->consumo->consumo}}
            @elseif($conta->nome=="1004")
              Consumo: <span class="label label-info">
                 {{$conta->consumo->consumo}}
            @else
              Consumo: <span class="label label-info">
                 {{$conta->consumo->consumo}}
            @endif
            </span>
            @if ($conta->nome=="1001")
              <br>Categoria:
              <span class="label label-info">
                 {{$conta->consumo->cat}}
              </span>
            @endif
          </div>
          <div class="col-md-3">
            @if ($conta->nome=="1001")
              Leitura Anterior: <span class="label label-info">
                 {{$conta->consumo->valor_anterior}} lts
            @elseif ($conta->nome=="1002")
              Preço medio: <span class="label label-info">
                 R$ {{$conta->consumo->valor_anterior}}
            @elseif($conta->nome=="1003")
              Consumo: <span class="label label-info">
                 {{$conta->consumo->consumo}}
            @elseif($conta->nome=="1004")
              Consumo: <span class="label label-info">
                 {{$conta->consumo->consumo}}
            @else
              Consumo: <span class="label label-info">
                 {{$conta->consumo->consumo}}
            @endif
          </span><br>
          @if ($conta->nome=="1001")
            Leitura atual: <span class="label label-info">
               {{$conta->consumo->valor_atual}} lts
           @endif
            </span><br>
            @if ($conta->nome=="1001")
              Valor agua: <span class="label label-info">
                 R$ {{$conta->consumo->sub_item1}}
            @elseif ($conta->nome=="1002")
              Valor: <span class="label label-info">
                 R$ {{$conta->consumo->sub_item1}}
            @endif
            </span><br>
            @if ($conta->nome=="1001")
              Valor Esgoto: <span class="label label-info">
                 R$ {{$conta->consumo->sub_item2}}
            @endif
            </span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            @if ($conta->discs!='[]')
              <hr>
              <div class="row">
                <div class="col-md-12 text-center h3">
                  Discriminação de cobrança
                </div>
              </div>
              @foreach($conta->discs as $key => $disc)
                <div class="row list-contacts">
                  <div class="col-md-6 text-right">
                    <span class="label label-info">{{$disc->nome}}</span>
                  </div>
                  <div class="col-md-2 text-left">
                    <span class="label label-warning">R$ {{$disc->valor}}</span>
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
                Total: <span class="label label-warning">R$ {{$total_disc}}</span>

              </div>
            </div>
          </div>
        </div>
      @endif
      @if (empty($conta->parcelas[0]) and $conta->referencia)
        <div class="row">
          <div class="col-md-12 text-center h3">
            Parcelas
          </div>
        </div>
        @foreach($conta->referencia->parcelas as $key => $parcela)
            <div class="row list-contacts">
              <div class="col-md-2 text-right">
                @if ($parcela->referencia->id===$parcela->id)
                  <span class="label label-default">
                    Referencia
                  </span>
                @else
                  <span class="label label-default">
                    Parcela
                  </span>
                @endif
              </div>
              <div class="col-md-10">
                {{$parcela->nome}}
                <span class="label label-warning">
                  R$ {{ number_format($parcela->valor, 2) }}
                </span> |
                @if (strtotime($parcela->vencimento)>strtotime(Carbon::now()))
                  <span class="label label-warning">
                @else
                  <span class="label label-danger">
                @endif
                  {{date('d/m/Y', strtotime($parcela->vencimento))}}
                </span> -
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
      @endif
      <div class="row">
        <div class="col-md-6">
          @if (count($conta->parcelas)>1)
            <hr>
            <div class="row">
              <div class="col-md-10">
                @foreach($conta->parcelas as $key => $parcela)
                  <div class="row list-contacts">
                    <div class="col-md-2 text-right">
                      @if ($parcela->referencia->id===$parcela->id)
                        <span class="label label-default">
                          Referencia
                        </span>
                      @else
                        <span class="label label-default">
                          Parcela
                        </span>
                      @endif
                    </div>
                    <div class="col-md-10">
                      {{$parcela->nome}}
                      <span class="label label-warning">
                        R$ {{ number_format($parcela->valor, 2) }}
                      </span> |
                      @if (strtotime($parcela->vencimento)>strtotime(Carbon::now()))
                        <span class="label label-warning">
                      @else
                        <span class="label label-danger">
                      @endif
                        {{date('d/m/Y', strtotime($parcela->vencimento))}}
                      </span> -
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
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <!--<a href="{{ url('/novo/contas/editar') }}/{{$conta->id}}"><button type="submit" class="btn btn-primary">Editar</button></a>-->
    </div>
  </div>
</div>
