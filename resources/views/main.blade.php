<!DOCTYPE html>
<html lang="pt">
  <head>
    <title>ERP - @yield('title')</title>

    @include('includes.head')
  </head>
  <body>
    @if (!Auth::guest())
    <div class="nav-side-menu">
      @include('partials.sidemenu')
    </div>

    <div class="right-bar">
      @include ('partials.topbar')
      @yield('content')
    </div>
    @else
      @yield('content')
    @endif
  </body>
</html>
