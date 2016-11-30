<div class="brand">WebGS - ERP</div>
<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

    <div class="menu-list">

        <ul id="menu-content" class="menu-content collapse out">
            <li class="{{{ Request::path()=='/' ? "active" : "" }}}">
              <a href="{{ url('/') }}">
                <i class="fa fa-dashboard fa-lg"></i> Painel
              </a>
            </li>
            <li  data-toggle="collapse" data-target="#products" class="{{{ Request::is('contatos*') ? "active" : "collapsed" }}}" aria-expanded="{{{ Request::is('contatos*') ? "true" : "false" }}}">
              <a href="#"><i class="fa fa-gift fa-lg"></i> Contatos <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse {{{ Request::is('contatos*') ? "in" : "" }}}" aria-expanded="{{{ Request::is('contatos*') ? "true" : "false" }}}" id="products">
                <li class="{{{ Request::path()=='contatos' ? "active" : "" }}}"><a href="{{ url('/contatos') }}">Lista</a></li>
                <li class="{{{ Request::path()=='contatos/novo' ? "active" : "" }}}"><a href="{{url('/contatos/novo')}}">Novo</a></li>
            </ul>

            <li  data-toggle="collapse" data-target="#atendimentos" class="{{{ Request::is('atendimentos*') ? "active" : "collapsed" }}}" aria-expanded="{{{ Request::is('atendimentos*') ? "true" : "false" }}}">
              <a href="#"><i class="fa fa-globe fa-lg"></i> Atendimentos <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse {{{ Request::is('atendimentos*') ? "in" : "" }}}" aria-expanded="{{{ Request::is('atendimentos*') ? "true" : "false" }}}" id="atendimentos">
                <li class="{{{ Request::path()=='atendimentos' ? "active" : "" }}}"><a href="{{ url('/atendimentos') }}">Lista</a></li>
                <li class="{{{ Request::path()=='atendimentos/novo' ? "active" : "" }}}"><a href="{{ url('/atendimentos/novo') }}">Novo</a></li>
            </ul>

            @if (Auth::user()->perms["admin"]==1)
              <li data-toggle="collapse" data-target="#admin" class="collapsed {{{ Request::is('admin*') ? "active" : "" }}}">
                <a href="#"><i class="fa fa-wrench fa-lg"></i> Controle <span class="arrow"></span></a>
              </li>
              <ul class="sub-menu collapse {{{ Request::is('admin*') ? "in" : "" }}}" aria-expanded="{{{ Request::is('admin*') ? "true" : "false" }}}" id="admin">
                <li class="{{{ Request::path()=='admin' ? "active" : "" }}}"><a href="{{ url('/admin') }}">Controle de Usuarios</a></li>
                <li class="{{{ Request::path()=='admin/update' ? "active" : "" }}}"><a href="{{ url('/admin/update') }}">Atualizar</a></li>
                <li>New New 3</li>
              </ul>
            @endif


        </ul>
 </div>
