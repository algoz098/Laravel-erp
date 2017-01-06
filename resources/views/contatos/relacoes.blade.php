@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Relacionamentos de <span class="label label-primary">{{$contato->nome}}</span></div>
        <div class="panel-body">
          <div class="row text-right">
            <a class="btn btn-warning" href="{{ url('lista/contatos')}}" ><i class="fa fa-users"></i> Voltar a Lista</a>
            <a href="{{ url('/lista/contatos') }}/{{$contato->id}}/relacoes/novo" class="btn btn-success">
              <i class="fa fa-plus"></i> Novo
            </a>
          </div>
            <div class="row">
              <div class="col-md-12">
                @foreach($contato->from as $key => $from)
                  <div class="row h3 list-contacts">
                    <div class="col-md-2 text-right">
                      <a href="{{ url('lista/contatos') }}/{{$contato->id}}/relacoes/{{$contato->from[$key]->pivot->id}}/delete" class="btn btn-danger">
                        <i class="fa fa-ban"></i>
                      </a>
                    </div>
                    <div class="col-md-10">
                      {{$contato->nome}} é
                      <span class="label label-success">{{$contato->from[$key]->pivot->from_text}}</span>
                      de {{$contato->from[$key]->nome}}
                    </div>
                  </div>
                @endforeach
                @foreach($contato->to as $key => $to)
                  <div class="row h3 list-contacts">
                    <div class="col-md-2  text-right">
                      <a class="btn btn-danger" href="{{url('/lista/contatos/')}}/{{$contato->id}}/relacoes/{{$contato->from[$key]->pivot->id}}">
                        <i class="fa fa-ban"></i>
                      </a>
                    </div>
                    <div class="col-md-10">
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
  </div>
@endsection

<div class="col-md-6" id="form" style="display:none">
  <form id="form_relacao" method="POST" action="{{ url('lista/contatos') }}/{{$contato->id}}/relacoes/novo">
    <div class="form-group">
    <input type="hidden" class="form-control" value="" name="to_id" id="to_id" >
    {{ csrf_field() }}
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-users fa-1x"></i> Editar relacionamento de
        <span class="label label-primary">{{$contato->nome}}</span> e
        <span class="label label-success" id="to"></span>
      </div>
      <div class="panel-body">
        <div class="row text-right">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-success">Salvar</button>
          </div>
        </div>
        <div class="row">
          <div class="form-group form-inline">
            <label for="text"><span class="label label-primary">{{$contato->nome}}</span> é </label>
            <input type="text" class="form-control" value="" name="from_text" id="from_text" >
            de <span id="to2" class="label label-success"></span>
          </div>
        </div>
        <div class="row">
          <div class="form-group form-inline">
            <label for="text"><span id="to3" class="label label-success"></span> é </label>
            <input type="text" class="form-control" value="" name="to_text" id="to_text" placeholder="Texto de relacionamento">
            de <span class="label label-primary">{{$contato->nome}}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
</div>
