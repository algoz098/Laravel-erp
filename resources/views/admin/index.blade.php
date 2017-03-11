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
      <div class="row">
        <strong>
          <div class="col-md-1">
            ID:
          </div>
          <div class="col-md-2">
            Entidade
          </div>
          <div class="col-md-1">
            Usuario
          </div>
          <div class="col-md-1">
            Entidades
          </div>
          <div class="col-md-1">
            Atend.
          </div>
          <div class="col-md-1">
            Tickets
          </div>
          <div class="col-md-1">
            Contas
          </div>
          <div class="col-md-1">
            Caixas
          </div>
          <div class="col-md-1">
            Vendas
          </div>
          <div class="col-md-1">
            Estoques
          </div>
          <div class="col-md-1">
            Frotas
          </div>
        </strong>
      </div>
      @foreach($contatos as $key => $contato)
        <div class="row list-contacts" onclick="selectRow({{$contato->id}})">
          <div class="col-md-1">
            <span class="label label-info">
              ID: {{$contato->id}}
            </span>
          </div>
          <div class="col-md-2 limitar-string">
            @if (isset($contato->user->perms["admin"]) AND $contato->user->perms["admin"]==1)
              <span class="label label-default">ADM</span>
            @endif
            @mostraContato($contato->id*$contato->nome)
          </div>
          @if($contato->user)
            <div class="col-md-1">
              <span class="label label-{{ $contato->user->ativo == 1 ? "info" : "danger"}}">{{ $contato->user->ativo == 1 ? "Ativo" : "Inativo"}}</span>
            </div>
          @endif
          @if (isset($contato->user))
            @if (isset($contato->user->perms['contatos']))
              <div class="col-md-1">
                @if (isset($contato->user->perms['contatos']['leitura']))
                  @if ($contato->user->perms['contatos']['leitura']=="1")
                    <span class="label label-info">L</span>
                  @else
                    <span class="label label-danger">L</span>
                  @endif
                  @if ($contato->user->perms['contatos']['adicao']=="1")
                    <span class="label label-info">A</span>
                  @else
                    <span class="label label-danger">A</span>
                  @endif
                  @if ($contato->user->perms['contatos']['edicao']=="1")
                    <span class="label label-info">E</span>
                  @else
                    <span class="label label-danger">E</span>
                  @endif
                @endif
              </div>
            @endif
            @if($modulo_atendimentos==0)
              @if (isset($contato->user->perms['atendimentos']))
                <div class="col-md-1">
                  @if (isset($contato->user->perms['atendimentos']['leitura']))
                    @if ($contato->user->perms['atendimentos']['leitura']=="1")
                      <span class="label label-info">L</span>
                    @else
                      <span class="label label-danger">L</span>
                    @endif
                    @if ($contato->user->perms['atendimentos']['adicao']=="1")
                      <span class="label label-info">A</span>
                    @else
                      <span class="label label-danger">A</span>
                    @endif
                    @if ($contato->user->perms['atendimentos']['edicao']=="1")
                      <span class="label label-info">E</span>
                    @else
                      <span class="label label-danger">E</span>
                    @endif
                  @endif
                </div>
              @endif
            @endif
            @if($modulo_tickets==1)
              @if (isset($contato->user->perms['tickets']))
                <div class="col-md-1">
                  @if (isset($contato->user->perms['tickets']['leitura']))
                    @if ($contato->user->perms['tickets']['leitura']=="1")
                      <span class="label label-info">L</span>
                    @else
                      <span class="label label-danger">L</span>
                    @endif
                    @if ($contato->user->perms['tickets']['adicao']=="1")
                      <span class="label label-info">A</span>
                    @else
                      <span class="label label-danger">A</span>
                    @endif
                    @if ($contato->user->perms['tickets']['edicao']=="1")
                      <span class="label label-info">E</span>
                    @else
                      <span class="label label-danger">E</span>
                    @endif
                  @endif
                </div>
              @endif
            @endif
            @if($modulo_contas==1)
              @if (isset($contato->user->perms['contas']))
                <div class="col-md-1">
                  @if (isset($contato->user->perms['contas']['leitura']))
                    @if ($contato->user->perms['contas']['leitura']=="1")
                      <span class="label label-info">L</span>
                    @else
                      <span class="label label-danger">L</span>
                    @endif
                    @if ($contato->user->perms['contas']['adicao']=="1")
                      <span class="label label-info">A</span>
                    @else
                      <span class="label label-danger">A</span>
                    @endif
                    @if ($contato->user->perms['contas']['edicao']=="1")
                      <span class="label label-info">E</span>
                    @else
                      <span class="label label-danger">E</span>
                    @endif
                  @endif
                </div>
              @endif
            @endif
            @if($modulo_bancos==1)
              @if (isset($contato->user->perms['bancos']))
                <div class="col-md-1">
                  @if (isset($contato->user->perms['bancos']['leitura']))
                    @if ($contato->user->perms['bancos']['leitura']=="1")
                      <span class="label label-info">L</span>
                    @else
                      <span class="label label-danger">L</span>
                    @endif
                    @if ($contato->user->perms['bancos']['adicao']=="1")
                      <span class="label label-info">A</span>
                    @else
                      <span class="label label-danger">A</span>
                    @endif
                    @if ($contato->user->perms['bancos']['edicao']=="1")
                      <span class="label label-info">E</span>
                    @else
                      <span class="label label-danger">E</span>
                    @endif
                  @endif
                </div>
              @endif
            @endif
            @if($modulo_caixas==1)
              @if (isset($contato->user->perms['caixas']))
                <div class="col-md-1">
                  @if (isset($contato->user->perms['caixas']['leitura']))
                    @if ($contato->user->perms['caixas']['leitura']=="1")
                      <span class="label label-info">L</span>
                    @else
                      <span class="label label-danger">L</span>
                    @endif
                    @if ($contato->user->perms['caixas']['adicao']=="1")
                      <span class="label label-info">A</span>
                    @else
                      <span class="label label-danger">A</span>
                    @endif
                    @if ($contato->user->perms['caixas']['edicao']=="1")
                      <span class="label label-info">E</span>
                    @else
                      <span class="label label-danger">E</span>
                    @endif
                  @endif
                </div>
              @endif
            @endif
            @if($modulo_vendas==1)
              @if (isset($contato->user->perms['vendas']))
                <div class="col-md-1">
                  @if (isset($contato->user->perms['vendas']['leitura']))
                    @if ($contato->user->perms['vendas']['leitura']=="1")
                      <span class="label label-info">L</span>
                    @else
                      <span class="label label-danger">L</span>
                    @endif
                    @if ($contato->user->perms['vendas']['adicao']=="1")
                      <span class="label label-info">A</span>
                    @else
                      <span class="label label-danger">A</span>
                    @endif
                    @if ($contato->user->perms['vendas']['edicao']=="1")
                      <span class="label label-info">E</span>
                    @else
                      <span class="label label-danger">E</span>
                    @endif
                  @endif
                </div>
              @endif
            @endif
            @if($modulo_estoques==1)
              @if (isset($contato->user->perms['estoques']))
                <div class="col-md-1">
                  @if (isset($contato->user->perms['estoques']['leitura']))
                    @if ($contato->user->perms['estoques']['leitura']=="1")
                      <span class="label label-info">L</span>
                    @else
                      <span class="label label-danger">L</span>
                    @endif
                    @if ($contato->user->perms['estoques']['adicao']=="1")
                      <span class="label label-info">A</span>
                    @else
                      <span class="label label-danger">A</span>
                    @endif
                    @if ($contato->user->perms['estoques']['edicao']=="1")
                      <span class="label label-info">E</span>
                    @else
                      <span class="label label-danger">E</span>
                    @endif
                  @endif
                </div>
              @endif
            @endif
            @if($modulo_frotas==1)
              @if (isset($contato->user->perms['frotas']))
                <div class="col-md-1">
                  @if (isset($contato->user->perms['frotas']['leitura']))
                    @if ($contato->user->perms['frotas']['leitura']=="1")
                      <span class="label label-info">L</span>
                    @else
                      <span class="label label-danger">L</span>
                    @endif
                    @if ($contato->user->perms['frotas']['adicao']=="1")
                      <span class="label label-info">A</span>
                    @else
                      <span class="label label-danger">A</span>
                    @endif
                    @if ($contato->user->perms['frotas']['edicao']=="1")
                      <span class="label label-info">E</span>
                    @else
                      <span class="label label-danger">E</span>
                    @endif
                  @endif
                </div>
              @endif
            @endif
          @endif
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
