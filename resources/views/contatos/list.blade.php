@extends('main')
@section('content')
    <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-users fa-1x"></i> Lista de contatos
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-2 pull-right text-right">
              <a href="{{ url('/novo/contatos') }}" class="btn btn-success"><i class="fa fa-plus fa-1x"></i> Novo</a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12  ">
              <form method="POST" action="{{ url('/contatos') }}/">
                <div class="form-group form-inline text-center">
                  {{ csrf_field() }}
                  <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca">
                  <button type="submit" class="btn btn-success">Buscar</button>
                </div>
              </form>
            </div>
          </div>
          @foreach($contatos as $key => $contato)
              <div class="row list-contacts">
                <div class="col-md-3">
                  <a href="{{ url('/contatos') }}/delete/{{$contato->id}}" class="btn btn-danger btn_xs" data-toggle="tooltip" title="Deletar">
                    <i class="fa fa-ban" ></i>
                  </a>
                                  <a href="{{ url('/contatos') }}/{{$contato->id}}" class="btn btn-primary btn_xs" data-toggle="tooltip" title="Detalhes">
                    <i class="fa fa-file-text"></i>
                  </a>
                  <a href="{{ url('/contatos') }}/{{$contato->id}}/phone" class="btn btn-primary btn_xs" title="Adicionar Telefone"  data-toggle="modal" data-target="#addTelefones{{$contato->id}}">
                    <i class="fa fa-phone"></i>
                  </a>
                  <span class="btn btn-primary btn_xs" title="Relacionamentos"  data-toggle="collapse" data-target="#relacionamentos{{$contato->id}}" aria-expanded="">
                    <i class="fa fa-users"></i>
                  </span>
                  {{$contato->id}}
                </div>
                <div class="col-md-3">
                  @if(is_null($contato->active))
                    <i class="fa fa-user level1"></i>
                  @else
                    <i class="fa fa-user level{{$contato->active}}"></i>
                  @endif
                  <i class="fa fa-signal level{{$contato->sociabilidade}}"></i>
                  {{ str_limit($contato->nome, 10) }} {{ str_limit($contato->sobrenome, 3) }}
                </div>
                <div class="col-md-6">
                  @foreach($contato->from as $key => $from)
                    @if ($from->pivot->to_id==1)
                      <span class="label label-warning">{{$from->pivot->from_text}}</span>
                    @endif
                  @endforeach
                  @foreach($contato->telefones as $key => $telefone)
                    <span class=""><span class="badge">{{$telefone->tipo}}</span> {{$telefone->numero}}</span>
                  @endforeach
                  {{$contato->endereco}} - {{$contato->bairro}} - {{$contato->cidade}} - {{$contato->uf}} -
                  <span class="label label-primary">{{date('d/m/Y', strtotime($contato->created_at))}}</label>
                </div>
              </div>
              <div class="sub-menu collapse " aria-expanded="" id="relacionamentos{{$contato->id}}" style="padding-left: 100px; padding-top: 15px; padding-bottom: 30px;">
                <a href="{{ url('/contatos') }}/{{$contato->id}}/relacoes" class="btn btn-warning" title="Relacionamentos">
                  Editar relações
                </a><br>
                @foreach($contato->from as $key => $from)
                  <div class="row list-contacts">
                    {{$from->nome}} <span class="label label-info">{{$from->pivot->to_text}}</span>
                  </div>
                @endforeach
                @foreach($contato->to as $key => $to)
                  <div class="row list-contacts">
                    {{$to->nome}} <span class="label label-info">{{$to->pivot->from_text}}</span>
                  </div>
                @endforeach
              </div>
            <!-- Modal -->
            <div class="modal fade" id="addTelefones{{$contato->id}}" tabindex="-1" role="dialog" aria-labelledby="addTelefonesLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addTelefonesLabel">Adicionar Telefone</h4>
                  </div>
                  <div class="modal-body">
                      @foreach($contato->telefones as $key => $telefone)
                          <a href="{{ url('/contatos') }}/{{$contato->id}}/telefones/{{ $telefone->id }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                          <a href="{{ url('/contatos') }}/{{$contato->id}}/telefones/{{ $telefone->id }}/delete" class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></a>
                          {{ $telefone->tipo or "" }} {{ $telefone->numero or "" }} <br>
                      @endforeach
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a href="{{ url('/contatos') }}/{{$contato->id}}/telefones"><button type="submit" class="btn btn-primary">Novo</button></a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
          @if($deletados!==0)
            <h3>Deletados</h3>
            @foreach($deletados as $key => $contato)
                <div class="row list-contacts">
                  <div class="col-md-3">
                    <a href="{{ url('/contatos') }}/delete/{{$contato->id}}" class="btn btn-success btn_xs" data-toggle="tooltip" title="Restaurar">
                      <i class="fa fa-check" ></i>
                    </a>
                    <a href="{{ url('/contatos') }}/{{$contato->id}}" class="btn btn-primary btn_xs" data-toggle="tooltip" title="Detalhes">
                      <i class="fa fa-file-text"></i>
                    </a>
                    <a href="{{ url('/contatos') }}/{{$contato->id}}/phone" class="btn btn-primary btn_xs" title="Adicionar Telefone"  data-toggle="modal" data-target="#addTelefones{{$contato->id}}">
                      <i class="fa fa-phone"></i>
                    </a>
                    <span class="btn btn-primary btn_xs" title="Relacionamentos"  data-toggle="collapse" data-target="#relacionamentos{{$contato->id}}" aria-expanded="">
                      <i class="fa fa-users"></i>
                    </span>
                    {{$contato->id}}
                  </div>
                  <div class="col-md-4">
                    <span class="label label-danger">DELETADO</span>
                    @if(is_null($contato->active))
                      <i class="fa fa-user level1"></i>
                    @else
                      <i class="fa fa-user level{{$contato->active}}"></i>
                    @endif
                    <i class="fa fa-signal level{{$contato->sociabilidade}}"></i>
                    {{ str_limit($contato->nome, 10) }} {{ str_limit($contato->sobrenome, 3) }}
                  </div>
                  <div class="col-md-5">
                    @foreach($contato->from as $key => $from)
                      @if ($from->pivot->to_id==1)
                        <span class="label label-warning">{{$from->pivot->from_text}}</span>
                      @endif
                    @endforeach
                    @foreach($contato->telefones as $key => $telefone)
                      <span class=""><span class="badge">{{$telefone->tipo}}</span> {{$telefone->numero}}</span>
                    @endforeach
                    {{$contato->endereco}} - {{$contato->bairro}} - {{$contato->cidade}} - {{$contato->uf}} -
                    <span class="label label-primary">{{date('d/m/Y', strtotime($contato->created_at))}}</label>
                  </div>
                </div>
                <div class="sub-menu collapse " aria-expanded="" id="relacionamentos{{$contato->id}}" style="padding-left: 100px; padding-top: 15px; padding-bottom: 30px;">
                  <a href="{{ url('/contatos') }}/{{$contato->id}}/relacoes" class="btn btn-warning" title="Relacionamentos">
                    Editar relações
                  </a><br>
                  @foreach($contato->from as $key => $from)
                    <div class="row list-contacts">
                      {{$from->nome}} <span class="label label-info">{{$from->pivot->to_text}}</span>
                    </div>
                  @endforeach
                  @foreach($contato->to as $key => $to)
                    <div class="row list-contacts">
                      {{$to->nome}} <span class="label label-info">{{$to->pivot->from_text}}</span>
                    </div>
                  @endforeach
                </div>
              <!-- Modal -->
              <div class="modal fade" id="addTelefones{{$contato->id}}" tabindex="-1" role="dialog" aria-labelledby="addTelefonesLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="addTelefonesLabel">Adicionar Telefone</h4>
                    </div>
                    <div class="modal-body">
                        @foreach($contato->telefones as $key => $telefone)
                            <a href="{{ url('/contatos') }}/{{$contato->id}}/telefones/{{ $telefone->id }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                            <a href="{{ url('/contatos') }}/{{$contato->id}}/telefones/{{ $telefone->id }}/delete" class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></a>
                            {{ $telefone->tipo or "" }} {{ $telefone->numero or "" }} <br>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <a href="{{ url('/contatos') }}/{{$contato->id}}/telefones"><button type="submit" class="btn btn-primary">Novo</button></a>
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
