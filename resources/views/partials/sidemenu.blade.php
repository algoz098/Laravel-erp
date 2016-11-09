<div class="brand">WebGS - ERP</div>
<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

    <div class="menu-list">

        <ul id="menu-content" class="menu-content collapse out">
            <li class="{{{ Request::path()=='/' ? "active" : "" }}}">
              <a href="{{ url('/') }}">
                <i class="fa fa-dashboard fa-lg"></i> Painel
              </a>
            </li>
            <li  data-toggle="collapse" data-target="#products" class="collapsed {{{ Request::is('clientes*') ? "active" : "" }}}">
              <a href="#"><i class="fa fa-gift fa-lg"></i> Clientes <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="products">
                <li class="{{{ Request::path()=='clientes' ? "active" : "" }}}"><a href="{{ url('/clientes') }}">Lista</a></li>
                <li class="{{{ Request::path()=='clientes/novo' ? "active" : "" }}}"><a href="{{url('/clientes/novo')}}">Novo</a></li>
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


            <li data-toggle="collapse" data-target="#new" class="collapsed">
              <a href="#"><i class="fa fa-car fa-lg"></i> New <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="new">
              <li>New New 1</li>
              <li>New New 2</li>
              <li>New New 3</li>
            </ul>


             <li>
              <a href="#">
              <i class="fa fa-user fa-lg"></i> Profile
              </a>
              </li>

             <li>
              <a href="#">
              <i class="fa fa-users fa-lg"></i> Users
              </a>
            </li>
        </ul>
 </div>
