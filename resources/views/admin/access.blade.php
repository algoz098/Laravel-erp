@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Permissões do usuario de <span class="label label-info">{{$contato->nome}}</span></div>
    <form method="POST" action="{{ url('/admin') }}/access/{{$contato->id}}">
      {{ csrf_field() }}
      <div class="panel-body">
        <div class="row" id="secondNavbar">
          <div class="col-md-4 pull-right text-right">
            <a href="{{url()->previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Voltar</a>
            @botaoSalvar
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="panel panel-default">
              <div class="panel-body">
                ID:{{$contato->id}}, {{$contato->nome}} {{$contato->sobrenome}}<br>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <strong>
            <div class="col-md-1">
              Modulo
            </div>
            <div class="col-md-2">
              Leitura
            </div>
            <div class="col-md-2">
              Adição
            </div>
            <div class="col-md-2">
              Edição
            </div>
          </strong>
        </div>
        <div class="row list-contacts">
          <div class="col-md-1">
            Contatos
          </div>
          <div class="col-md-2">
            @if ($contato->user->perms["contatos"]["leitura"]==1)
              @botaoSimNao(contatos*leitura*1)
            @else
              @botaoSimNao(contatos*leitura*0)
            @endif
          </div>
          <div class="col-md-2">
            @if ($contato->user->perms["contatos"]["adicao"]==1)
              @botaoSimNao(contatos*adicao*1)
            @else
              @botaoSimNao(contatos*adicao*0)
            @endif
          </div>
          <div class="col-md-2">
            @if ($contato->user->perms["contatos"]["edicao"]==1)
              @botaoSimNao(contatos*edicao*1)
            @else
              @botaoSimNao(contatos*edicao*0)
            @endif
          </div>
        </div>
        @if ($modulo_atendimentos=="1")
          <div class="row list-contacts">
          <div class="col-md-1">
            Atendimentos
          </div>
          <div class="col-md-2">
            @if ($contato->user->perms["atendimentos"]["leitura"]==1)
              @botaoSimNao(atendimentos*leitura*1)
            @else
              @botaoSimNao(atendimentos*leitura*0)
            @endif
          </div>
          <div class="col-md-2">
            @if ($contato->user->perms["atendimentos"]["adicao"]==1)
              @botaoSimNao(atendimentos*adicao*1)
            @else
              @botaoSimNao(atendimentos*adicao*0)
            @endif
          </div>
          <div class="col-md-2">
            @if ($contato->user->perms["atendimentos"]["edicao"]==1)
              @botaoSimNao(atendimentos*edicao*1)
            @else
              @botaoSimNao(atendimentos*edicao*0)
            @endif
          </div>
        </div>
        @endif
        @if ($modulo_tickets=="1")
          <div class="row list-contacts">
            <div class="col-md-1">
              Tickets
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["tickets"]["leitura"]==1)
                @botaoSimNao(tickets*leitura*1)
              @else
                @botaoSimNao(tickets*leitura*0)
              @endif
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["tickets"]["adicao"]==1)
                @botaoSimNao(tickets*adicao*1)
              @else
                @botaoSimNao(tickets*adicao*0)
              @endif
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["tickets"]["edicao"]==1)
                @botaoSimNao(tickets*edicao*1)
              @else
                @botaoSimNao(tickets*edicao*0)
              @endif
            </div>
          </div>
        @endif
        @if ($modulo_contas=="1")
          <div class="row list-contacts">
            <div class="col-md-1">
              Contas
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["contas"]["leitura"]==1)
                @botaoSimNao(contas*leitura*1)
              @else
                @botaoSimNao(contas*leitura*0)
              @endif
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["contas"]["adicao"]==1)
                @botaoSimNao(contas*adicao*1)
              @else
                @botaoSimNao(contas*adicao*0)
              @endif
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["contas"]["edicao"]==1)
                @botaoSimNao(contas*edicao*1)
              @else
                @botaoSimNao(contas*edicao*0)
              @endif
            </div>
          </div>
        @endif
        @if ($modulo_bancos=="1")
          <div class="row list-contacts">
            <div class="col-md-1">
              Bancos
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["bancos"]["leitura"]==1)
                @botaoSimNao(bancos*leitura*1)
              @else
                @botaoSimNao(bancos*leitura*0)
              @endif
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["bancos"]["adicao"]==1)
                @botaoSimNao(bancos*adicao*1)
              @else
                @botaoSimNao(bancos*adicao*0)
              @endif
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["bancos"]["edicao"]==1)
                @botaoSimNao(bancos*edicao*1)
              @else
                @botaoSimNao(bancos*edicao*0)
              @endif
            </div>
          </div>
        @endif
        @if ($modulo_caixas=="1")
          <div class="row list-contacts">
            <div class="col-md-1">
              Caixas
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["caixas"]["leitura"]==1)
                @botaoSimNao(caixas*leitura*1)
              @else
                @botaoSimNao(caixas*leitura*0)
              @endif
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["caixas"]["adicao"]==1)
                @botaoSimNao(caixas*adicao*1)
              @else
                @botaoSimNao(caixas*adicao*0)
              @endif
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["caixas"]["edicao"]==1)
                @botaoSimNao(caixas*edicao*1)
              @else
                @botaoSimNao(caixas*edicao*0)
              @endif
            </div>
          </div>
        @endif
        @if ($modulo_vendas=="1")
          <div class="row list-contacts">
            <div class="col-md-1">
              Vendas
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["vendas"]["leitura"]==1)
                @botaoSimNao(vendas*leitura*1)
              @else
                @botaoSimNao(vendas*leitura*0)
              @endif
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["vendas"]["adicao"]==1)
                @botaoSimNao(vendas*adicao*1)
              @else
                @botaoSimNao(vendas*adicao*0)
              @endif
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["vendas"]["edicao"]==1)
                @botaoSimNao(vendas*edicao*1)
              @else
                @botaoSimNao(vendas*edicao*0)
              @endif
            </div>
          </div>
        @endif
        @if ($modulo_estoques=="1")
          <div class="row list-contacts">
            <div class="col-md-1">
              Estoques
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["estoques"]["leitura"]==1)
                @botaoSimNao(estoques*leitura*1)
              @else
                @botaoSimNao(estoques*leitura*0)
              @endif
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["estoques"]["adicao"]==1)
                @botaoSimNao(estoques*adicao*1)
              @else
                @botaoSimNao(estoques*adicao*0)
              @endif
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["estoques"]["edicao"]==1)
                @botaoSimNao(estoques*edicao*1)
              @else
                @botaoSimNao(estoques*edicao*0)
              @endif
            </div>
          </div>
        @endif
        @if ($modulo_frotas=="1")
          <div class="row list-contacts">
            <div class="col-md-1">
              Frotas
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["frotas"]["leitura"]==1)
                @botaoSimNao(frotas*leitura*1)
              @else
                @botaoSimNao(frotas*leitura*0)
              @endif
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["frotas"]["adicao"]==1)
                @botaoSimNao(frotas*adicao*1)
              @else
                @botaoSimNao(frotas*adicao*0)
              @endif
            </div>
            <div class="col-md-2">
              @if ($contato->user->perms["frotas"]["edicao"]==1)
                @botaoSimNao(frotas*edicao*1)
              @else
                @botaoSimNao(frotas*edicao*0)
              @endif
            </div>
          </div>
        @endif
        <div class="row list-contacts">
          <div class="col-md-1">
            Admin
          </div>
          <div class="col-md-2">
            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-success btn-xs active">
                <input type="radio" name="admin" value="1" id="adminSim" autocomplete="off" checked> Sim
              </label>
              <label class="btn btn-danger btn-xs">
                <input type="radio" name="admin" value="0" id="adminNao" autocomplete="off"> Não
              </label>
            </div>
          </div>
        </div>
      </div>

  </div>
  <script>
    $('#myStateButton').on('click', function () {
      $(this).button('complete') // button text will be "finished!"
    })
  </script>
@endsection
