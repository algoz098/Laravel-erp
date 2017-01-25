@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Controle de Usuarios</div>
    <div class="panel-body">
      <h2>Contato:</h2>
      @foreach($contatos as $key => $contato)
        <div class="row list-contacts h3">
          <div class="col-md-6">
            <a href="{{ url('/admin') }}/user/{{$contato->id}}" class="btn btn-info">
              <i class="fa fa-gear"></i> Acesso
            </a>
            <a href="{{ url('/admin') }}/access/{{$contato->id}}" class="btn btn-info">
              <i class="fa fa-level-up"></i> Nivel
            </a>
            {{$contato->nome}}

            @if ($contato->user)
              <span class="label label-{{ $contato->user->ativo == 1 ? "info" : "danger"}}">{{ $contato->user->ativo == 1 ? "Ativo" : "Inativo"}}</span>
              @if (isset($contato->user->perms["admin"]) AND $contato->user->perms["admin"]==1)
                <span class="label label-default">ADM</span>
              @endif
            @else
              <span class="label label-warning">Sem acesso</span>
            @endif

          </div>
        </div>
        @if ($contato->user and isset($contato->user->perms["admin"]))
          <!-- Modal -->
          <div class="modal fade" id="access" tabindex="-1" role="dialog" aria-labelledby="access">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="addTelefonesLabel">Permissões de acesso</h4>
                </div>
                <div class="modal-body h3">
                    @foreach($contato->user->perms as $key => $role)
                      {{$key}}
                    @endforeach
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <a href="{{ url('/admin') }}/access/{{$contato->id}}"><button type="submit" class="btn btn-primary">Novo</button></a>
                </div>
              </div>
            </div>
          </div>
        @endif
      @endforeach
    </div>
  </div>
@endsection
