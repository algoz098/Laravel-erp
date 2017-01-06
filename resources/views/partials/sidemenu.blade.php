<nav class="pushy pushy-left">
  <div class="text-center webgs-brand">
    Web GS - ERP
  </div>
  <ul class="menu" >
    <li class="pushy-submenu {{{ Request::path()=='/' ? "active" : "" }}}">
      <a href="{{ url('/') }}"><i class="fa fa-dashboard fa-lg"></i> Painel</a>
    </li>
    <li class="pushy-submenu ">
        <a href="#" class="{{{ Request::is('novo*') ? "active" : ""}}}"><i class="fa fa-file-text fa-lg"></i> Cadastros</a>
        <ul class="menu" >
          <li class="pushy-link "><a class="{{{ Request::path()=='novo/contatos' ? "active" : "" }}}" href="{{ url('novo/contatos') }}"><i class="fa fa-user"></i> Entidade</a></li>
          <li class="pushy-link "><a class="{{{ Request::path()=='novo/atendimentos' ? "active" : "" }}}" href="{{ url('/novo/atendimentos') }}"><i class="fa fa-list"></i> Atendimento</a></li>
          <li class="pushy-link "><a class="{{{ Request::path()=='novo/contas' ? "active" : "" }}}" href="{{ url('/novo/contas') }}"><i class="fa fa-usd"></i> Fluxo de Caixa</a></li>
          <li class="pushy-link "><a class="{{{ Request::path()=='novo/estoque' ? "active" : "" }}}" href="{{ url('/novo/estoque') }}"><i class="fa fa-bell"></i> Estoque</a></li>
          <li class="pushy-link "><a class="{{{ Request::path()=='novo/caixa' ? "active" : "" }}}" href="{{ url('/novo/caixa') }}"><i class="fa fa-money"></i> Caixa</a></li>
          <li class="pushy-link "><a class="{{{ Request::path()=='novo/vendas' ? "active" : "" }}}" href="{{ url('/novo/vendas') }}"><i class="fa fa-shopping-cart"></i> Vendas</a></li>
        </ul class="menu" >
    </li>
    <li class="pushy-submenu ">
        <a href="#" class="{{{ Request::is('lista*') ? "active" : ""}}}"><i class="fa fa-list fa-lg"></i> Listas</a>
        <ul class="menu" >
          <li class="pushy-link"><a class="{{{ Request::path()=='lista/contatos' ? "active" : "" }}}" href="{{ url('/lista/contatos') }}"><i class="fa fa-user"></i> Entidades</a></li>
          <li class="pushy-link"><a class="{{{ Request::path()=='lista/atendimentos' ? "active" : "" }}}" href="{{ url('/lista/atendimentos') }}"><i class="fa fa-list"></i> Atendimento</a></li>
          <li class="pushy-link"><a class="{{{ Request::path()=='lista/contas' ? "active" : "" }}}" href="{{ url('/lista/contas') }}"><i class="fa fa-usd"></i> Fluxo de Caixa</a></li>
          <li class="pushy-link"><a class="{{{ Request::path()=='lista/estoque' ? "active" : "" }}}" href="{{ url('/lista/estoque') }}"><i class="fa fa-bell"></i> Estoque</a></li>
          <li class="pushy-link"><a class="{{{ Request::path()=='lista/caixa' ? "active" : "" }}}" href="{{ url('/lista/caixa') }}"><i class="fa fa-money"></i> Caixa</a></li>
          <li class="pushy-link"><a class="{{{ Request::path()=='lista/vendas' ? "active" : "" }}}" href="{{ url('/lista/vendas') }}"><i class="fa fa-shopping-cart"></i> Vendas</a></li>
        </ul class="menu" >
    </li>
    @if (isset(Auth::user()->perms["admin"]) and Auth::user()->perms["admin"]==1)
      <li class="pushy-submenu {{{ Request::is('admin*') ? "active" : ""}}}">
          <a href="#"><i class="fa fa-wrench fa-lg"></i> Controle</a>
          <ul class="menu" >
            <li class="pushy-link"><a class="{{{ Request::path()=='admin' ? "active" : "" }}}" href="{{ url('/admin') }}">Controle de Usuarios</a></li>
            <li class="pushy-link"><a class="{{{ Request::path()=='admin/update' ? "active" : "" }}}" href="{{ url('/admin/update') }}">Atualizar</a></li>
            <li class="pushy-link"><a class="{{{ Request::path()=='admin/backup' ? "active" : "" }}}" href="{{ url('/admin/backup') }}">Backup</a></li>
            <li class="pushy-link"><a class="{{{ Request::path()=='admin/logs' ? "active" : "" }}}" href="{{ url('/admin/logs') }}">Logs</a></li>
            <li class="pushy-link"><a class="{{{ Request::path()=='admin/Combobox' ? "active" : "" }}}" href="{{ url('/admin/combobox') }}">Combobox</a></li>
          </ul class="menu" >
      </li>
    @endif
  </ul class="menu" >
 </nav>
