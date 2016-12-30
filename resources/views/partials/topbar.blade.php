<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
       <div class="menu-btn navbar-brand">
         <i class="fa fa-bars"></i>
       </div>
     </div>
         <ul class="nav navbar-nav navbar-right">
           <li><a href="#">Olá, {{Auth::user()->contato->nome}}</a></li>
           <li class="dropdown">
             <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i> Opções <span class="caret"></span></a>
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
