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
        @if ( $errors->count() > 0 )
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
              <div class="alert alert-warning" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Erro</strong>
                      @foreach( $errors->all() as $message )
                        <div class="row">{{ $message }}</div>
                      @endforeach
                </div>
              </div>
            </div>
          </div>
        @endif
      	@yield('content')
      </div>
    @else
      @yield('content')
    @endif
  </body>
  @include('includes.foot')
</html>
