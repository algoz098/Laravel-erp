<?php
use Carbon\Carbon;
?>

@extends('main')

@section('content')
  <div id="app">
    <example></example>
    <hr>
    <input type="text" :value="a">
    @{{a}}
  </div>
  <div class="panel panel-default">
    <div class="panel-body">

    </div>
  </div>
@endsection
@section('header')


  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script src="{{ asset('js/app.js') }}"></script>
@endsection
@section('footer')
@endsection
