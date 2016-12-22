@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-bell-o fa-1x"></i> Contas
        </div>
        <div class="panel-body">
          <div class="row pull-right">
            <div class="col-md-12">
              <a href="{{ url('/novo/estoque') }}" class="btn btn-success"><i class="fa fa-plus"></i> Novo</a>
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
          @if ($estoques!==0)
            @foreach($estoques as $key => $estoque)
              <div class="row list-contacts">
                <div class="col-md-3">
                  <a href="{{ url('lista/estoque') }}/{{$estoque->id}}/delete"  title="Apagar" class="btn btn-danger">
                    <i class="fa fa-ban"></i>
                  </a>
                  <a class="btn btn-info"  title="Detalhes"  data-toggle="modal" data-target="#detalhes{{$estoque->id}}" aria-expanded="">
                    <i class="fa fa-file-text-o"></i>
                  </a>
                  <a href="{{ url('/contatos') }}/{{$estoque->contato->id}}"  title="Detalhes do contato" class="btn btn-info">
                    <i class="fa fa-user"></i>
                  </a>
                </div>
                <div class="col-md-3">
                  {{$estoque->nome}}
                  <span class="label label-warning">R$ {{ number_format($estoque->valor_custo, 2) }}</span>
                  <span class="label label-info">{{$estoque->quantidade}}</span>
                </div>
                <div class="col-md-6">
                  Filial: <span class="label label-primary">{{$estoque->contato->nome }}</span>
                </div>
              </div>

              <!-- Modal -->
              <div class="modal fade" id="detalhes{{$estoque->id}}" tabindex="-1" role="dialog" aria-labelledby="detalhesLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="addTelefonesLabel">
                        Detalhes: {{$estoque->nome}}
                      </h4>
                    </div>
                    <div class="modal-body">
                      {{$estoque}}
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <a href="{{ url('/novo/contas') }}/{{$estoque->id}}"><button type="submit" class="btn btn-primary">Editar</button></a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
          @if($deletados!==0)
            <h3>Deletados</h3>
            @foreach($deletados as $key => $estoque)
              <div class="row list-contacts">
                <div class="col-md-3">
                  <a href="{{ url('lista/estoque') }}/{{$estoque->id}}/delete"  title="Apagar" class="btn btn-danger">
                    <i class="fa fa-ban"></i>
                  </a>
                  <a class="btn btn-info"  title="Detalhes"  data-toggle="modal" data-target="#detalhes{{$estoque->id}}" aria-expanded="">
                    <i class="fa fa-file-text-o"></i>
                  </a>
                  <a href="{{ url('/contatos') }}/{{$estoque->contato->id}}"  title="Detalhes do contato" class="btn btn-info">
                    <i class="fa fa-user"></i>
                  </a>
                </div>
                <div class="col-md-3">
                  {{$estoque->nome}}
                  <span class="label label-warning">R$ {{ number_format($estoque->valor_custo, 2) }}</label>
                </div>
                <div class="col-md-6">
                </div>
              </div>

              <!-- Modal -->
              <div class="modal fade" id="detalhes{{$estoque->id}}" tabindex="-1" role="dialog" aria-labelledby="detalhesLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="addTelefonesLabel">
                        Detalhes: {{$estoque->nome}}
                      </h4>
                    </div>
                    <div class="modal-body">
                      {{$estoque}}
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <a href="{{ url('/novo/contas') }}/{{$estoque->id}}"><button type="submit" class="btn btn-primary">Editar</button></a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
