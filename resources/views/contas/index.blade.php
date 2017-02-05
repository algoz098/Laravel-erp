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
                <div class="col-md-3 text-left ajuda-popover"
                      title="Opções"
                      data-content="Deletar, editar/detalhes, telefones/emails, relacionamentos e anexos do contato"
                      data-placement="top" >
                  <div class=" form-inline col-md-10 text-right">
                    <a href="{{ url('lista/contas') }}/id/delete"  id="buttonDelete" title="Apagar" class="btn btn-danger">
                      <i class="fa fa-ban"></i>
                    </a>
                    <a class="btn btn-info"  id="buttonDetalhes" title="Detalhes"  data-toggle="modal" data-target="#detalhes" aria-expanded="">
                      <i class="fa fa-file-text-o"></i>
                    </a>
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
                    <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca">
                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                    <a class="btn btn-info"  title="Busca Avançada" data-toggle="collapse" data-target="#buscaAvançada" aria-expanded="" onclick="listaTop()">
                      <i class="fa fa-search-plus"></i>
                    </a>
                  </div>
                </div>
                  <div class="col-md-1 pull-right text-right ajuda-popover"
                        title="Novo"
                        data-content="Adicione um novo contato"
                        data-placement="left">
                    <a href="{{ url('/novo/contas') }}" class="btn btn-success"><i class="fa fa-plus fa-1x">
                        </i> Novo</a>
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
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="data_ate">Relação com a Matriz</label>
                    <select class="form-control" id="relacao" name="relacao">
                      <option value="" selected> - Escolha a relação -</option>
                      @foreach($comboboxes as $key => $combo)
                        <option value="{{$combo->text}}">{{$combo->text}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <label><input type="checkbox" name="credito">Entrada</label>
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
                <a data-toggle="modal" data-url="{{url('lista/contatos')}}/{{$conta->contatos->id}}" data-target="#modal" class="label label-info">
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
            <div class="modal fade" id="detalhes{{$conta->id}}" tabindex="-1" role="dialog" aria-labelledby="detalhesLabel">
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
            </div>
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

  <!-- Modal -->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>
<script>
  function selectRow(id){
    $("#ids").val(id);
    $("#buttonDelete").attr('href', '{{ url('lista/contas') }}/'+id+'/delete/');
    $("#buttonEdit").attr('href', '{{ url('novo/contas') }}/'+id);
    $("#buttonPagar").attr('href', '{{ url('/lista/contas') }}/'+id+'/pago');
    $("#buttonDetalhes").attr('data-target', '#detalhes'+id);
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
