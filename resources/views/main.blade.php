<!DOCTYPE html>
<html lang="pt">
  <head>
    <title>ERP - @yield('title')</title>

    @include('includes.head')
  </head>
  <body>
    <div class="nav-side-menu">
      @include('partials.sidemenu')
    </div>
    <div class="right-bar">
      @yield('content')
    </div>
  </body>
</html>
