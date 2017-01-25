@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <form id="form_relacao" method="POST" action="{{ url('lista/contatos') }}/{{$contato->id}}/relacoes/novo">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Relacionamentos de <span class="label label-primary">{{$contato->nome}}</span></div>
          <div class="panel-body">
            <div class="row text-right">
              <a class="btn btn-warning" href="{{ url('lista/contatos')}}" ><i class="fa fa-users"></i> Voltar a Lista</a>
              <a href="{{ url('/lista/contatos') }}/{{$contato->id}}/relacoes/novo" class="btn btn-success">
                <i class="fa fa-plus"></i> Novo
              </a>
            </div>
              <input type="hidden" class="form-control" value="" name="to_id" id="to_id" >
              {{ csrf_field() }}
              <div class="form-group form-inline">
                <label for="text"><span class="label label-primary">{{$contato->nome}}</span> é </label>
                <input type="text" class="form-control" value="" name="from_text" id="from_text" >
                de <span id="to2" class="label label-success"></span>
              </div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
