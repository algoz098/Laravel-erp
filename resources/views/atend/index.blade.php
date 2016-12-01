@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-list fa-1x"></i> Atendimentos
        </div>
        <div class="panel-body">
          <div class="row pull-right">
            <div class="col-md-12">
              <a href="{{ url('/atendimentos') }}/novo" class="btn btn-success"><i class="fa fa-plus"></i> Novo</a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12  ">
              <form method="POST" action="{{ url('/atendimentos') }}/">
                <div class="form-group form-inline text-center">
                  {{ csrf_field() }}
                  <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca">
                  <button type="submit" class="btn btn-success">Buscar</button>
                </div>
              </form>
            </div>
          </div>
          @if ($atendimentos!="[]")

            @foreach($atendimentos as $key => $atendimento)
                <div class="row list-contacts">
                  <div class="col-md-2 text-right">
                    <a href="{{ url('/atendimentos') }}/{{$atendimento->id}}/delete" class="btn btn-danger btn_xs">
                      <i class="fa fa-ban"></i>
                    </a>
                    <a href="#" class="btn btn-primary btn_xs" title="Detalhes"  data-toggle="modal" data-target="#detalhes{{$atendimento->id}}">
                      <i class="fa fa-file-text-o"></i>
                    </a>
                  </div>
                  <div class="col-md-2 text-center">
                    <span class="label label-info">
                      {{date('d/m/Y', strtotime($atendimento->created_at))}}
                    </span>
                    {{$atendimento->contatos->nome}}
                  </div>
                  <div class="col-md-6">
                    {{$atendimento->assunto}} -
                    {{ str_limit($atendimento->texto, 35)}}
                  </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="detalhes{{$atendimento->id}}" tabindex="-1" role="dialog" aria-labelledby="detalhesLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="addTelefonesLabel">Detalhes atendimento: {{$atendimento->id}}</h4>
                      </div>
                      <div class="modal-body">
                        <div class="row text-center">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="assunto">Assunto</label>
                              <div>{{$atendimento->assunto}}</div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="contato">Contato</label>
                              <div>{{$atendimento->contatos->nome}} {{$atendimento->contatos->sobrenome}}</div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="data">Data do atendimento</label>
                              <div>{{date('H:i d/m/Y', strtotime($atendimento->created_at))}}</div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="data">Descrição do atendimento</label>
                              <div>{{$atendimento->texto}}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <a href="{{ url('/atendimentos') }}/{{$atendimento->id}}"><button type="submit" class="btn btn-primary">Editar</button></a>
                      </div>
                    </div>
                  </div>
                </div>
            @endforeach

          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="detalhes{{$atendimento->id}}" tabindex="-1" role="dialog" aria-labelledby="detalhesLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="addTelefonesLabel">Detalhes atendimento: {{$atendimento->id}}</h4>
          </div>
          <div class="modal-body">
            <div class="row text-center">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="assunto">Assunto</label>
                  <div>{{$atendimento->assunto}}</div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="contato">Contato</label>
                  <div>{{$atendimento->contatos->nome}} {{$atendimento->contatos->sobrenome}}</div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="data">Data do atendimento</label>
                  <div>{{date('H:i d/m/Y', strtotime($atendimento->created_at))}}</div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="data">Descrição do atendimento</label>
                  <div>{{$atendimento->texto}}</div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <a href="{{ url('/atendimentos') }}/{{$atendimento->id}}"><button type="submit" class="btn btn-primary">Editar</button></a>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection
