@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Relacionamentos de <span class="label label-primary">{{$contato->nome}}</span></div>
        <div class="panel-body">
          <div class="row text-right">
            <a href="{{url()->previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Voltar</a>
            <a href="{{ url('/contatos') }}/{{$contato->id}}/relacoes/novo" class="btn btn-success">
              <i class="fa fa-plus"></i>
            </a>
          </div>
            <div class="row">
              <div class="col-md-8">
                @foreach($contato->from as $key => $from)
                  <div class="row h3 list-contacts">
                    <div class="col-md-2 text-right">
                      <a href="{{ url('/contatos') }}/{{$contato->id}}/relacoes/{{$contato->from[$key]->pivot->id}}/delete" class="btn btn-danger">
                        <i class="fa fa-ban"></i>
                      </a>
                      <a class="btn btn-primary" onclick="
                                                          $('#form').show();
                                                          $('#to').text('{{$from->nome}}');
                                                          $('#to2').text('{{$from->nome}}');
                                                          $('#to3').text('{{$from->nome}}');
                                                          $('#from_text').val('{{$contato->from[$key]->pivot->from_text}}');
                                                          $('#to_text').val('{{$contato->from[$key]->pivot->to_text}}');
                                                          $('#to_id').val('{{$contato->from[$key]->pivot->to_id}}');
                                                          ">
                        <i class="fa fa-pencil"></i>
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
                    <div class="col-md-3  text-right">
                      <a href="{{ url('/contatos') }}/{{$contato->id}}/relacoes/{{$contato->to[$key]->pivot->id}}/delete" class="btn btn-danger">
                        <i class="fa fa-ban"></i>
                      </a>
                      <a class="btn btn-primary" onclick="
                                                          $('#form').show();
                                                          $('#to').text('{{$to->nome}}');
                                                          $('#to2').text('{{$to->nome}}');
                                                          $('#to3').text('{{$to->nome}}');
                                                          $('#from_text').val('{{$contato->to[$key]->pivot->to_text}}');
                                                          $('#to_text').val('{{$contato->to[$key]->pivot->from_text}}');
                                                          $('#to_id').val('{{$contato->to[$key]->pivot->from_id}}');
                                                          ">
                        <i class="fa fa-pencil"></i>
                      </a>
                    </div>
                    <div class="col-md-8">
                      {{$contato->nome}} é
                      <span class="label label-success">{{$contato->to[$key]->pivot->to_text}}</span>
                      de {{$contato->to[$key]->nome}}
                    </div>
                  </div>
                @endforeach
              </div>
              <div class="col-md-6" id="form" style="display:none">
                <form id="form_relacao" method="POST" action="{{ url('/contatos') }}/{{$contato->id}}/relacoes/novo">
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
