<?php
use Carbon\Carbon;
?>
@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-usd fa-1x"></i> Contas
        </div>
        <div class="panel-body">
          <div class="row pull-right">
            <div class="col-md-12">
              <a href="{{ url('/novo/contas') }}" class="btn btn-success"><i class="fa fa-plus"></i> Novo</a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12  ">
              <form method="POST" action="{{ url('/lista/contas') }}/">
                <div class="form-group form-inline text-center">
                  {{ csrf_field() }}
                  <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca">
                  <button type="submit" class="btn btn-success">Buscar</button>
                </div>
              </form>
            </div>
          </div>
          @foreach($contas as $key => $conta)
            <div class="row list-contacts">
              <div class="col-md-3">
                <a href="{{ url('lista/contas') }}/{{$conta->id}}/delete"  title="Apagar" class="btn btn-danger">
                  <i class="fa fa-ban"></i>
                </a>
                <a class="btn btn-warning"  title="Parcelas"  data-toggle="collapse" data-target="#referente{{$conta->id}}" aria-expanded="">
                  <i class="fa fa-paperclip"></i>
                </a>
                <a class="btn btn-info"  title="Detalhes"  data-toggle="modal" data-target="#detalhes{{$conta->id}}" aria-expanded="">
                  <i class="fa fa-file-text-o"></i>
                </a>
                <a href="{{ url('/contatos') }}/{{$conta->contatos->id}}"  title="Detalhes do contato" class="btn btn-info">
                  <i class="fa fa-user"></i>
                </a>
                <a href="{{ url('/lista/contas') }}/{{$conta->id}}/pago"  title="Creditar" class="btn btn-success">
                  <i class="fa fa-check"></i>
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

            <div class="sub-menu collapse " aria-expanded="" id="referente{{$conta->id}}" style="padding-left: 100px; padding-top: 15px; padding-bottom: 30px;">
              @foreach($conta->parcelas as $key => $parcela)
                @if ($parcela->referencia->id!==$parcela->id)
                  <div class="row list-contacts">
                    {{$parcela->nome}} <span class="label label-warning">R$ {{ number_format($parcela->valor, 2) }}</span>
                    <span class="label label-success">parcela</span>
                  </div>
                @endif
              @endforeach
              @if(isset($conta->referencia))
                <div class="row list-contacts">
                  {{$conta->referencia->nome}}
                  <span class="label label-danger">R$ {{ number_format($conta->referencia->valor, 2) }}</span>
                  <span class="label label-success">ORIGEM</span>
                </div>
              @endif
            </div>

            <!-- Modal -->
            <div class="modal fade" id="detalhes{{$conta->id}}" tabindex="-1" role="dialog" aria-labelledby="detalhesLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addTelefonesLabel">
                      Detalhes da conta: {{$conta->nome}} Vencimento:
                      @if (strtotime($conta->vencimento)>strtotime(Carbon::now()))
                        <span class="label label-warning">
                      @else
                        <span class="label label-danger">
                      @endif
                        {{$conta->vencimento}}
                      </span>
                    </h4>
                  </div>
                  <div class="modal-body">
                    <div class="row text-center">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="assunto">Contato vinculado</label>
                          <div>{{$conta->contatos->nome}}</div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="assunto">Valor referente</label>
                          @if ($conta->referencia)
                            <div>R$ {{ number_format($conta->referencia->valor, 2) }}</div>
                          @else
                            <div> Valor referente APAGADO </div>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="assunto">Tipo</label>
                          <div>
                            @if ($conta->tipo==0)
                              <span class="label label-warning">Debito</span>
                            @elseif ($conta->tipo==1)
                              <span class="label label-warning">Credito</span>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="assunto">Estado</label>
                          <div>
                            @if ($conta->estado==0 AND $conta->tipo==0)
                              <span class="label label-danger">A pagar</span>
                            @elseif ($conta->estado==0 AND $conta->tipo==1)
                              <span class="label label-danger">A receber</span>
                            @elseif ($conta->estado==1 AND $conta->tipo==0)
                              <span class="label label-success">Pago</span>
                            @elseif ($conta->estado==1 AND $conta->tipo==1)
                              <span class="label label-success">Recebido</span>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-5 text-center h3">
                        Parcelas
                      </div>
                    </div>
                    @if (empty($conta->parcelas[0]) and $conta->referencia)
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
                    @else
                      <h3> Referencia ou parcelas apagadas </h3>
                    @endif
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
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a href="{{ url('/novo/contas') }}/{{$conta->id}}"><button type="submit" class="btn btn-primary">Editar</button></a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
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
@endsection
