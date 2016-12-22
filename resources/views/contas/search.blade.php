<?php
use Carbon\Carbon;
?>
@extends('main')
@section('content')
  @foreach($contas as $key => $conta)
    {{$conta}}<br>
  @endforeach
@endsection
