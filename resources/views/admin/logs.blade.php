@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Logs</div>
    <div class="panel-body">
      @foreach($logs as $key => $line)
        <div class="row list-contacts" style="font-size: 16px;">
          <div class="col-md-12">
            {{$line}}
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
