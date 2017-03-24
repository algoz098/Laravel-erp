<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
       <div class="menu-btn navbar-brand">
         <i class="fa fa-bars ajuda-popover"
           data-content="Clique aqui para o menu"
           data-placement="right"></i>
       </div>
     </div>
         <ul class="nav navbar-nav navbar-right hidden-xs hidden-sm">
           <li>
             <a class="navbar-brand" id="mostrarAjuda" href="#"><i class="fa fa-question fa-1x"></i></a>
           </li>
           <li><a href="#">Olá, {{explode(' ', Auth::user()->contato->nome, 2)[0]}}</a></li>
           <li class="dropdown">
             <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
               <i class="fa fa-cog ajuda-popover"
                  data-content="Opções da sua conta"
                  data-placement="botton"
                  ></i> Opções <span class="caret"></span>
             </a>
             <ul class="dropdown-menu">
               <li><a href="{{ url('/logout') }}"
                   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Sair</a></li>
               <li role="separator" class="divider"></li>
               <li><a href="#">Another action</a></li>
               <li><a href="#">Something else here</a></li>
               <li><a href="#">Separated link</a></li>
               <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                   {{ csrf_field() }}
               </form>
             </ul>
           </li>
         </ul>
       </div><!-- /.navbar-collapse -->
     </div><!-- /.container-fluid -->
    </div>
  </div>
</div>
