@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-bell-o fa-1x"></i> Estoque
        </div>
        <div class="panel-body">
          <div class="row pull-right">
            <div class="col-md-12">
              <a href="{{ url('/novo/estoque') }}" class="btn btn-success ajuda-popover"
                    title="Novo"
                    data-content="Adicione uma nova conta"
                    data-placement="left"><i class="fa fa-plus"></i> Novo</a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12  ">
              <form method="POST" action="{{ url('/lista/estoque') }}/">
                <div class="form-group form-inline text-center">
                  {{ csrf_field() }}
                  <label><input type="checkbox" name="estocado">Em Estoque</label>
                  <label><input type="checkbox" name="falta">Em Falta</label>
                  <input type="text" class="form-control" size="3" name="valor" id="busca" placeholder="Custo maior que">
                  <input type="text" class="form-control ajuda-popover"
                        title="Busca"
                        data-content="Selecione e preencha apenas o que precisa filtrar, o sistema ignora os filtros não preenchidos."
                        data-placement="top" size="13"name="contato" id="busca" placeholder="por Filial">
                  <input type="text" class="form-control" size="13" name="nome" id="busca" placeholder="por Nome">
                  <input type="text" class="form-control" size="7" name="codigo" id="busca" placeholder="por Codigo">
                  <button type="submit" class="btn btn-success">Buscar</button>
                </div>
              </form>
            </div>
          </div>
          @if ($estoques!==0)
            @foreach($estoques as $key => $estoque)
              <div class="row list-contacts">
                <div class="col-md-3 ajuda-popover"
                    @if ($key==0)
                      title="Opções"
                      data-content="Deletar, detalhes, aumentar e diminuir estoque."
                      data-placement="top"
                    @endif
                >
                  <a href="{{ url('lista/estoque') }}/{{$estoque->id}}/delete"  title="Apagar" class="btn btn-danger">
                    <i class="fa fa-ban"></i>
                  </a>
                  <a class="btn btn-info"  title="Detalhes"  data-toggle="modal" data-target="#detalhes{{$estoque->id}}" aria-expanded="">
                    <i class="fa fa-file-text-o"></i>
                  </a>
                  <a href="{{ url('lista/estoque') }}/{{$estoque->id}}/up" class="btn btn-success">
                    <i class="fa fa-arrow-up"></i>
                  </a>
                  <a href="{{ url('lista/estoque') }}/{{$estoque->id}}/down" class="btn btn-danger">
                    <i class="fa fa-arrow-down"></i>
                  </a>
                </div>
                <div class="col-md-3 ajuda-popover"
                    @if ($key==0)
                      title="Informações"
                      data-content="Nome do produto, preço, e quantidade em estoque."
                      data-placement="bottom"
                    @endif
                >
                  {{$estoque->nome}}
                  <span class="label label-warning">R$ {{ number_format($estoque->valor_custo, 2) }}</span>
                  <span class="label label-info">Estoque: {{$estoque->quantidade}}</span>
                </div>
                <div class="col-md-6 ajuda-popover"
                    @if ($key==0)
                      title="Detalhes"
                      data-content="Em qual filial esta este produto."
                      data-placement="top"
                    @endif
                >
                  <a href="{{ url('/contatos') }}/{{$estoque->contato->id}}"  title="Detalhes do contato">
                    <span class="label label-primary"><i class="fa fa-user"></i> {{$estoque->contato->nome }}</span>
                  </a>
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
                      <div class="row">
                        <div class="col-md-4">
                          Custo:
                          <span class="label label-warning">R$ {{ number_format($estoque->valor_custo, 2) }}</span>
                        </div>
                        <div class="col-md-4">
                          Codigo de barras:
                          <span class="label label-primary">{{$estoque->barras}}</span>
                        </div>
                        <div class="col-md-4">
                          Localizado na filial:
                          <span class="label label-info">{{$estoque->contato->nome}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          A peça esta localizada em: {{$estoque->contato->endereco }} - {{$estoque->contato->bairro }} - {{$estoque->contato->cidade }}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <strong>Descrição:</strong> {{$estoque->descricao }}
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <a href="{{ url('/lista/estoque') }}/{{$estoque->id}}/editar"><button type="submit" class="btn btn-primary">Editar</button></a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
            <div class="row">
              <div class="col-md-12 text-center">
                {{ $estoques->links() }}
              </div>
            </div>
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
                      <div class="row">
                        <div class="col-md-4">
                          Custo:
                          <span class="label label-warning">R$ {{ number_format($estoque->valor_custo, 2) }}</span>
                        </div>
                        <div class="col-md-4">
                          Codigo de barras:
                          <span class="label label-primary">{{$estoque->barras}}</span>
                        </div>
                        <div class="col-md-4">
                          Localizado na filial:
                          <span class="label label-info">{{$estoque->contato->nome}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          A peça esta localizada em: {{$estoque->contato->endereco }} - {{$estoque->contato->bairro }} - {{$estoque->contato->cidade }}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <strong>Descrição:</strong> {{$estoque->descricao }}
                        </div>
                      </div>
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
