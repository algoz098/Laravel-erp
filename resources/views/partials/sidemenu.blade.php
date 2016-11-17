<div class="brand">WebGS - ERP</div>
<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

    <div class="menu-list">

        <ul id="menu-content" class="menu-content collapse out">
            <li class="{{{ Request::path()=='/' ? "active" : "" }}}">
              <a href="{{ url('/') }}">
                <i class="fa fa-dashboard fa-lg"></i> Painel
              </a>
            </li>
            <li  data-toggle="collapse" data-target="#products" class="collapsed {{{ Request::is('contatos*') ? "active" : "" }}}">
              <a href="#"><i class="fa fa-gift fa-lg"></i> contatos <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="products">
                <li class="{{{ Request::path()=='contatos' ? "active" : "" }}}"><a href="{{ url('/contatos') }}">Lista</a></li>
                <li class="{{{ Request::path()=='contatos/novo' ? "active" : "" }}}"><a href="{{url('/contatos/novo')}}">Novo</a></li>
                <li><a href="#">Buttons</a></li>
                <li><a href="#">Tabs & Accordions</a></li>
                <li><a href="#">Typography</a></li>
                <li><a href="#">FontAwesome</a></li>
                <li><a href="#">Slider</a></li>
                <li><a href="#">Panels</a></li>
                <li><a href="#">Widgets</a></li>
                <li><a href="#">Bootstrap Model</a></li>
            </ul>


            <li data-toggle="collapse" data-target="#service" class="collapsed">
              <a href="#"><i class="fa fa-globe fa-lg"></i> Services <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="service">
              <li>New Service 1</li>
              <li>New Service 2</li>
              <li>New Service 3</li>
            </ul>


            <li data-toggle="collapse" data-target="#new" class="collapsed {{{ Request::is('admin*') ? "active" : "" }}}">
              <a href="#"><i class="fa fa-wrench fa-lg"></i> Controle <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="new">
              <a href="{{ url('/admin') }}"><li class="{{{ Request::path()=='  admin' ? "active" : "" }}}">Painel</li></a>
              <li>New New 2</li>
              <li>New New 3</li>
            </ul>


             <li>
              <a href="#">
              <i class="fa fa-user fa-lg"></i> Profile
              </a>
              </li>

             <li class="">
              <a href="#">
              <i class="fa fa-wrench fa-lg"></i> Controle
              </a>
            </li>
        </ul>
 </div>
