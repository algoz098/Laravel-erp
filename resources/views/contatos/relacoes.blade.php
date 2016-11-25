@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Relacionamentos de <span class="label label-primary">{{$contato->nome}}</span></div>
        <div class="panel-body">
          <div class="row text-right">
            <a href="{{ url('/contatos') }}/{{$contato->id}}/relacoes/novo" class="btn btn-success">
              <i class="fa fa-plus"></i>
            </a>
          </div>
              @foreach($contato->from as $key => $from)
                <div class="row h3 list-contacts">
                  <div class="col-md-2 text-right">
                    <a href="{{ url('/contatos') }}/{{$contato->id}}/relacoes/{{$contato->from[$key]->pivot->id}}/delete" class="btn btn-danger">
                      <i class="fa fa-ban"></i>
                    </a>
                  </div>
                  <div class="col-md-7">
                    {{$contato->nome}} é
                    <span class="label label-success">{{$contato->from[$key]->pivot->from_text}}</span>
                    de {{$contato->from[$key]->nome}}
                  </div>
                </div>
              @endforeach
              @foreach($contato->to as $key => $to)
                <div class="row h3 list-contacts">
                  <div class="col-md-2  text-right">
                    <a href="" class="btn btn-danger"><i class="fa fa-ban"></i></a>
                  </div>
                  <div class="col-md-7">
                    {{$contato->nome}} é
                    <span class="label label-success">{{$contato->to[$key]->pivot->to_text}}</span>
                    de {{$contato->to[$key]->nome}}
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
