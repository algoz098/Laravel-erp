<?php
use Carbon\Carbon;
?>
@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-money fa-1x"></i> Fechamento de caixa
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-9 h4">
              Pendencias de Caixa Nº:
              <span class="label label-info">{{$caixa->id}}</span>
              criado em <span class="label label-info">{{$caixa->created_at}}</span>
              de <span class="label label-info">{{$caixa->filial->nome}}</span>
            </div>
            <div class="col-md-3 text-right pull-right">
              <a class="btn btn-warning" href="{{ url('lista/caixa')}}" ><i class="fa fa-money"></i> Voltar a Lista</a>
              <a class="btn btn-warning" href="{{ url('lista/caixa/fechar')}}" ><i class="fa fa-back"></i> Voltar a fechamento</a>
            </div>
          </div>
          @if ($movs!=0)
            @foreach($movs as $key => $mov)
              <div class="row list-contacts">
                <div class="col-md-1">
                  <a data-toggle="modal" data-target="#prestar{{$mov->id}}" aria-expanded="" class="btn btn-success">
                    <i class="fa fa-ban"></i>
                  </a>
                  <button data-toggle="collapse" data-target="#detalhes{{$mov->id}}" aria-expanded=""class="btn btn-primary">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
                <div class="col-md-1">
                  <span class="label label-info">ID: {{$mov->id}}</label>
                </div>
                <div class="col-md-1">
                  @if ($mov->tipo=="1")
                    <span class="label label-danger">Saida de valor</span>
                  @elseif ($mov->tipo=="0")
                    <span class="label label-success">Entrada de valor</span>
                  @endif
                </div>
                <div class="col-md-1">
                  <span class="label label-warning">R$ {{ number_format($mov->valor, 2) }}</span>
                </div>
                <div class="col-md-1">
                  <span class="label label-info">{{$mov->nome}}</label>
                </div>
              </div>
              <div class="sub-menu collapse " aria-expanded="" id="detalhes{{$mov->id}}" style="padding-left: 100px; padding-top: 15px; padding-bottom: 30px;">
                {!!$mov->obs!!}
              </div>
              <form method="POST" action="{{ url('/lista/caixa/fechar') }}/{{$caixa->id}}/movs/{{$mov->id}}">
              {{ csrf_field() }}
                <div class="modal fade" id="prestar{{$mov->id}}" tabindex="-1" role="dialog" aria-labelledby="prestar">
                  <div class="modal-dialog modal-lg extra" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="">Prestar conta de ID: {{$mov->id}}</h4>
                      </div>
                      <div class="modal-body" id="modalBodyImage" >
                        <div class="row">
                          <div class="col-md-5">
                            <div class="form-group">
                              <label for="valor" id="valor_label">Caixa de:</label>
                              <input type="numeric" class="form-control" value="{{$caixa->filial->nome}}" disabled>
                            </div>
                          </div>
                          <div class="col-md-1">
                            <div class="form-group">
                              <label for="valor" id="valor_label">Caixa ID:</label>
                              <input type="numeric" class="form-control" value="{{$caixa->id}}" disabled>
                            </div>
                          </div>
                          <div class="col-md-1">
                            <div class="form-group">
                              <label for="valor" id="valor_label">Mov ID:</label>
                              <input type="numeric" class="form-control" value="{{$mov->id}}" disabled>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="valor" id="valor_label">Tipo:</label>
                              <input type="numeric" class="form-control" value="@if ($mov->tipo=='1') Saida de valor @elseif ($mov->tipo=='0')Entrada de valor @endif" disabled>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="valor" id="valor_label">Valor:</label>
                              <input type="numeric" class="form-control" value="R$ {{ number_format($mov->valor, 2) }}" disabled>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="valor" id="valor_label">Valor recebido</label>
                              <input type="numeric" class="form-control" placeholder="Valor" name="recebido" value="">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="valor" id="valor_label">Justificativa</label>
                              <input type="text" class="form-control" placeholder="" name="justificativa" value="">
                            </div>
                          </div>
                        </div>
                        <span class="label label-success">Prestado ao total :R$ {{ number_format($mov->prestacoes->pluck('valor')->sum(), 2)}}</span>
                        @foreach($mov->prestacoes as $key => $prestacao)
                          <div class="row list-contacts">
                            <div class="col-md-3">
                              R$ {{ number_format($prestacao->valor, 2) }}
                            </div>
                            <div class="col-md-3">
                              {{$prestacao->justificativa}}
                            </div>
                          </div>
                        @endforeach
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            @endforeach
          @else
            <div class="row">
              <div class="col-md-12 text-center">
                <h1><span class="label label-default">Tudo ok, fechar caixa?<span></h1>
                <a href="{{url('lista/caixa/fechar')}}/{{$caixa->id}}/concluir" class="h1"><span class="btn btn-success">Fechar!<span></a>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
