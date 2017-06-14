{{-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-theme.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
<link href="{{ asset('css/normalize.css') }}" rel="stylesheet">
<link href="{{ asset('css/pushy.css') }}" rel="stylesheet">
<link href="{{ asset('css/uploadfile.css') }}" rel="stylesheet">
<link href="{{ asset('css/morris.css') }}" rel="stylesheet">
<link href="{{ asset('css/erp.css') }}" rel="stylesheet">

@if(!View::hasSection('header'))
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/jquery-ui.js') }}"></script>
  <script src="{{ asset('js/jquery.tinymce.min.js') }}"></script>
  <script src="{{ asset('js/tinymce.min.js') }}"></script>
  <script src="{{ asset('js/tinymce.theme.min.js') }}"></script>
  <script src="{{ asset('js/jquery.mask.min.js') }}"></script> <!-- Conferir se vai manter -->
  <script src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
  <script src="{{ asset('js/jquery.maskMoney.min.js') }}"></script>
  <script src="{{ asset('js/jquery.uploadfile.min.js') }}"></script>
  <script src="{{ asset('js/raphael-min.js') }}"></script>
  <script src="{{ asset('js/morris.min.js') }}"></script>
  <script src="{{ asset('js/jquery.toaster.js') }}"></script>
@endif --}}

 <link rel="shortcut icon" href="{{{ asset('favicon.ico') }}}">

 <link href="{{ asset('css/app.css') }}" rel="stylesheet">

 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- CSRF Token -->
 <meta name="csrf-token" content="{{ csrf_token() }}">

 <title>{{ config('app.name', 'Laravel') }}</title>

 <!-- Styles -->
 <link href="{{ asset('css/app.css') }}" rel="stylesheet">

 <!-- Scripts -->
 <script>
     window.Laravel = <?php echo json_encode([
         'csrfToken' => csrf_token(),
     ]); ?>
 </script>
