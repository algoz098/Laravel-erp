@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Controle de Usuarios</div>
    <div class="panel-body">
      <div class="row" id="secondNavbar">
        <div class="col-md-3">
          <div class="row">
            <div class="col-md-6 text-right">
              @botaoDelete
              @botaoEditar
              <a id="botaoAcesso" class="btn btn-info"><i class="fa fa-gear"></i></a>
            </div>
            <div class="col-md-4 text-left">
              @idSelecionado
            </div>
          </div>
        </div>
      </div>
      @foreach($contatos as $key => $contato)
        <div class="row list-contacts" onclick="selectRow({{$contato->id}})">
          <div class="col-md-1">
            <span class="label label-info">
              ID: {{$contato->id}}
            </span>
          </div>
          <div class="col-md-2">
            @mostraContato($contato->id*$contato->nome)
          </div>
          <div class="col-md-6">
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
      @endforeach
    </div>
  </div>
  <script>

  {{$contato->id}}
  {{$contato->id}}

  function selectRow(id){
    window.id_attach_form = id;
    $("#ids").val(id);
    $("#botaoEditar").attr('href', '{{ url('/admin') }}/user/'+id);
    $("#botaoAcesso").attr('href', '{{ url('/admin') }}/access/'+id);
    $("#botaoDelete").attr('href', ''+id);
    if (id=="1") {
      $("#botaoDelete").attr('disabled', true);
    }
  }
  </script>
@endsection
