@extends('main')
@section('content')
  @foreach ($contatos as $key => $contato)
    <div class="row list-contacts">
      <div class="col-md-1">
        <a href="{{url('novo/tickets')}}/{{$contato->id}}" class="btn btn-info">
          <i class="fa fa-gear"></i>
        </a>
      </div>
      <div class="col-md-2">
        {{$contato->nome}} {{$contato->sobrenome}}
      </div>
    </div>
  @endforeach
@endsection
