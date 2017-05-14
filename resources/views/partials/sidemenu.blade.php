{{-- <nav class="pushy pushy-left">
  <div class="text-center webgs-brand">
    Web GS - ERP
  </div>
  <div class="row text-center" style="margin-bottom: 15px; margin-top:15px;">
    <img src="{{url('admin/config/img_destaque')}}" class="img-circle" height="200">
  </div>
  <ul class="menu" >
    <li class="pushy-submenu {{{ Request::path()=='/' ? "active" : "" }}}">
      <a href="{{ url('/') }}"><i class="fa fa-dashboard fa-lg"></i> Painel</a>
    </li>
    <li class="pushy-submenu ">
        <a href="#" class="{{{ Request::is('novo*') ? "active" : ""}}}"><i class="fa fa-file-text fa-lg"></i> Cadastros</a>
        <ul class="menu" >
          @ifPerms(contatos*adicao)
            @sidemenuItem(novo*contatos*fa-user*Entidade)
            @sidemenuItem(novo*funcionario*fa-user-plus*Funcionario)
          @endPerms
          @if (isset($modulo_atendimentos) and $modulo_atendimentos=="1")
            @ifPerms(atendimentos*adicao)
              @sidemenuItem(novo*atendimentos*fa-list*Atendimentos)
            @endPerms
          @endif
          @if (isset($modulo_contas) and $modulo_contas=="1")
            @ifPerms(contas*adicao)
              @sidemenuItem(novo*contas*fa-usd*Plano bancario)
              @sidemenuItem(novo*consumos*fa-arrow-right*Consumo bancario)
            @endPerms
          @endif
          @if (isset($modulo_estoques) and $modulo_estoques=="1")
            @ifPerms(estoques*adicao)
            <li class="pushy-link "><a class="{{{ Request::path()=='novo/produto' ? "active" : "" }}}" href="{{ url('novo/produto') }}"><i class="fa fa-bell-o"></i> Novo produto</a></li>
            <li class="pushy-link "><a class="{{{ Request::path()=='novo/nf-entrada' ? "active" : "" }}}" href="{{ url('novo/nf-entrada') }}"><i class="fa fa-bell-o"></i> NF Entrada</a></li>
            @endPerms
          @endif
          @if (isset($modulo_caixas) and $modulo_caixas=="1")
            @ifPerms(caixas*adicao)
              @sidemenuItem(novo*caixa*fa-money*Movimento de caixa)
            @endPerms
          @endif
          @if (isset($modulo_bancos) and $modulo_bancos=="1")
            @ifPerms(bancos*adicao)
              @sidemenuItem(novo*bancos*fa-bank*Conta bancaria)
            @endPerms
          @endif
          @if (isset($modulo_vendas) and $modulo_vendas=="1")
            @ifPerms(vendas*adicao)
              @sidemenuItem(novo*vendas*fa-shopping-cart*Vendas)
            @endPerms
          @endif
          @if (isset($modulo_frotas) and $modulo_frotas=="1")
            @ifPerms(frotas*adicao)
              @sidemenuItem(novo*frotas*fa-car*Adicionar veiculo)
            @endPerms
          @endif
          @if (isset($modulo_tickets) and $modulo_tickets=="1")
            @ifPerms(tickets*adicao)
              @sidemenuItem(novo*tickets*fa-book*Tickets)
            @endPerms
          @endif
        </ul class="menu" >
    </li>
    <li class="pushy-submenu ">
        <a href="#" class="{{{ Request::is('lista*') ? "active" : ""}}}"><i class="fa fa-list fa-lg"></i> Listas</a>
        <ul class="menu" >
          <li class="pushy-link "><a class="{{{ Request::path()=='lista/produtos' ? "active" : "" }}}" href="{{ url('lista/cons_int') }}"><i class="fa fa-bell-o"></i> Consumo Interno</a></li>
          @sidemenuItem(lista*contatos*fa-user*Entidades)
          @if (isset($modulo_atendimentos) and $modulo_atendimentos=="1")
            @sidemenuItem(lista*atendimentos*fa-list*Atendimento)
          @endif
          @if (isset($modulo_contas) and $modulo_contas=="1")
            @sidemenuItem(lista*contas*fa-usd*Historico bancario)
          @endif
          @if (isset($modulo_estoques) and $modulo_estoques=="1")
            @sidemenuItem(lista*estoques*fa-bell*Estoque)
            <li class="pushy-link "><a class="{{{ Request::path()=='lista/nf-entrada' ? "active" : "" }}}" href="{{ url('lista/nf-entrada') }}"><i class="fa fa-bell-o"></i> NF Entradas</a></li>
          @endif
          <li class="pushy-link "><a class="{{{ Request::path()=='lista/produtos' ? "active" : "" }}}" href="{{ url('lista/produtos') }}"><i class="fa fa-bell-o"></i> Produtos</a></li>
          @if (isset($modulo_caixas) and $modulo_caixas=="1")
            @sidemenuItem(lista*caixas*fa-money*Movs. de caixas)
          @endif
          @sidemenuItem(lista*bancos*fa-bank*Contas em bancos)
          @if (isset($modulo_vendas) and $modulo_vendas=="1")
            @sidemenuItem(lista*vendas*fa-shopping-cart*Vendas)
          @endif
          @if (isset($modulo_frotas) and $modulo_frotas=="1")
            @sidemenuItem(lista*frotas*fa-car*Frotas)
          @endif
          @if (isset($modulo_tickets) and $modulo_tickets=="1")
            @sidemenuItem(lista*tickets*fa-book*Tickets)
          @endif
        </ul class="menu" >
    </li>
    @if (isset(Auth::user()->perms["admin"]) and Auth::user()->perms["admin"]==1)
      <li class="pushy-submenu {{{ Request::is('admin*') ? "active" : ""}}}">
          <a href="#"><i class="fa fa-wrench fa-lg"></i> Controle</a>
          <ul class="menu" >
            <li class="pushy-link"><a class="{{{ Request::path()=='admin/config' ? "active" : "" }}}" href="{{ url('/admin/config') }}">Configurações</a></li>
            <li class="pushy-link"><a class="{{{ Request::path()=='admin' ? "active" : "" }}}" href="{{ url('/admin') }}">Controle de Usuarios</a></li>
            <li class="pushy-link"><a class="{{{ Request::path()=='admin/update' ? "active" : "" }}}" href="{{ url('/admin/update') }}">Atualizar</a></li>
            <li class="pushy-link"><a class="{{{ Request::path()=='admin/backup' ? "active" : "" }}}" href="{{ url('/admin/backup') }}">Backup</a></li>
            <li class="pushy-link"><a class="{{{ Request::path()=='admin/logs' ? "active" : "" }}}" href="{{ url('/admin/logs') }}">Logs</a></li>
          </ul class="menu" >
      </li>
      <li class="pushy-submenu {{{ Request::is('admin*') ? "active" : ""}}}">
          <a href="#"><i class="fa fa-file-o fa-lg"></i> Combobox</a>
          <ul class="menu" >
            <li class="pushy-link"><a class="{{{ Request::path()=='admin/Combobox' ? "active" : "" }}}" href="{{ url('/admin/combobox') }}"><i class="fa fa-gear"></i> Painel</a></li>
            <li class="pushy-link "><a class="{{{ Request::path()=='novo/combobox/telefone' ? "active" : "" }}}" href="{{ url('novo/combobox/telefone') }}"><i class="fa fa-phone"></i> Tipo de telefone</a></li>
            <li class="pushy-link "><a class="{{{ Request::path()=='novo/combobox/relacao' ? "active" : "" }}}" href="{{ url('novo/combobox/relacao') }}"><i class="fa fa-share-square"></i> Relacionamento</a></li>
            @if (isset($modulo_atendimentos) and $modulo_atendimentos=="1")
              <li class="pushy-link "><a class="{{{ Request::path()=='novo/combobox/atend' ? "active" : "" }}}" href="{{ url('novo/combobox/atend') }}"><i class="fa fa-list"></i> Assunto de Atend.</a></li>
            @endif
            @if (isset($modulo_contas) and $modulo_contas=="1")
              <li class="pushy-link "><a class="{{{ Request::path()=='novo/combobox/contas' ? "active" : "" }}}" href="{{ url('novo/combobox/contas') }}"><i class="fa fa-usd"></i> Ref. para Contas</a></li>
              <li class="pushy-link "><a class="{{{ Request::path()=='novo/combobox/consumos' ? "active" : "" }}}" href="{{ url('novo/combobox/consumos') }}"><i class="fa fa-arrow-right"></i><i class="fa fa-usd"></i> Ref. de Consumo</a></li>
            @endif
            @if ((isset($modulo_caixas) and isset($modulo_contas)) and ($modulo_caixas=="1" or $modulo_contas=="1"))
              <li class="pushy-link "><a class="{{{ Request::path()=='novo/combobox/formas' ? "active" : "" }}}" href="{{ url('novo/combobox/formas') }}"><i class="fa fa-money"></i> Forma de pagamentos</a></li>
            @endif
            @if (isset($modulo_caixas) and $modulo_caixas=="1")
              <li class="pushy-link "><a class="{{{ Request::path()=='novo/combobox/caixas' ? "active" : "" }}}" href="{{ url('novo/combobox/caixas') }}"><i class="fa fa-list"></i> Desc. movimentação</a></li>
            @endif
            @if (isset($modulo_estoques) and $modulo_estoques=="1")
              <li class="pushy-link "><a class="{{{ Request::path()=='novo/combobox/estoque/produtos/medidas' ? "active" : "" }}}" href="{{ url('novo/combobox/estoque/produtos/medidas') }}"><i class="fa fa-thermometer-full"></i> Un. Med. Produto</a></li>
              <li class="pushy-link "><a class="{{{ Request::path()=='novo/combobox/estoque/produtos/embalagens' ? "active" : "" }}}" href="{{ url('novo/combobox/estoque/produtos/embalagens') }}"><i class="fa fa-archive"></i> Emb. de Produto</a></li>
            @endif
          </ul class="menu" >
      </li>
    @endif
  </ul class="menu" >
 </nav> --}}
