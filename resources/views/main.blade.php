<!DOCTYPE html>
<html lang="pt">
  <head>
    <title>ERP - @yield('title')</title>

    @include('includes.head')
  </head>
  <body>
    @if (!Auth::guest())
      @include('partials.sidemenu')
      <div class="site-overlay"></div>
      <div id="container">
        @include('partials.topbar')
      	@yield('content')
      </div>
    @else
      @yield('content')
    @endif
  </body>
  @include('includes.foot')
</html>
