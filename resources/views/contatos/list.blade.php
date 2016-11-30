@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Total de contatos/fornecedores</div>
        <div class="panel-body text-center">
         <span style="font-size:2em;">{!! count($contatos) !!}</span>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-wrench fa-1x"></i> Caixa de opções</div>
        <div class="panel-body">
          <a href="{{ url('/contatos/novo') }}"><span style="font-size:1.5em;"><i class="fa fa-plus fa-1x"></i> Novo</span></a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-users fa-1x"></i> Lista de contatos e fornecedores
        </div>
        <div class="panel-body">
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
                <div class="col-md-3 text-center">
                  <a href="{{ url('/contatos') }}/{{$contato->id}}" class="btn btn-primary btn_xs" data-toggle="tooltip" title="Editar">
                    <i class="fa fa-wrench" ></i>
                  </a>
                  <a href="{{ url('/contatos') }}/{{$contato->id}}" class="btn btn-primary btn_xs" data-toggle="tooltip" title="Detalhes">
                    <i class="fa fa-file-text"></i>
                  </a>
                  <a href="{{ url('/contatos') }}/{{$contato->id}}/phone" class="btn btn-primary btn_xs" title="Adicionar Telefone"  data-toggle="modal" data-target="#addTelefones">
                    <i class="fa fa-phone"></i>
                  </a>
                  <a href="{{ url('/contatos') }}/{{$contato->id}}/relacoes" class="btn btn-primary btn_xs" title="Relacionamentos">
                    <i class="fa fa-users"></i>
                  </a>
                  {{$contato->id}}
                </div>
                <div class="col-md-2">
                  <i class="fa fa-user level{{$contato->active}}"></i>
                  <i class="fa fa-signal level{{$contato->sociabilidade}}"></i>
                  {{$contato->nome}} {{$contato->sobrenome}}
                </div>
                <div class="col-md-7">
                  @foreach($contato->telefones as $key => $telefone)
                    <span class=""><span class="badge">{{$telefone->tipo}}</span> {{$telefone->numero}}</span>
                  @endforeach
                  {{$contato->endereco}} - {{$contato->bairro}} - {{$contato->cidade}} - {{$contato->uf}}
                </div>
              </div>
            <!-- Modal -->
            <div class="modal fade" id="addTelefones" tabindex="-1" role="dialog" aria-labelledby="addTelefonesLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addTelefonesLabel">Adicionar Telefone</h4>
                  </div>
                  <div class="modal-body">
                      @foreach($contato->telefones as $key => $telefone)
                          <a href="/erp/public/index.php/contatos/{{$contato->id}}/telefones/{{ $telefone->id }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                          <a href="/erp/public/index.php/contatos/{{$contato->id}}/telefones/{{ $telefone->id }}/delete" class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></a>
                          {{ $telefone->tipo or "" }} {{ $telefone->numero or "" }} <br>
                      @endforeach
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a href="/erp/public/index.php/contatos/{{$contato->id}}/telefones"><button type="submit" class="btn btn-primary">Novo</button></a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection
