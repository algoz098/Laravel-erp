@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-book fa-1x"></i> Lista de Tickets
        </div>
        <div class="panel-body">
          <div class="row" id="secondNavbar">
            <div class="col-md-3">
              <div class="row">
                <div class="col-md-6">
                  <a href="" class="btn btn-danger" id="buttonDelete"><i class="fa fa-ban"></i></a>
                  <a href="" class="btn btn-info" id="buttonEdit"><i class="fa fa-gear"></i></a>
                  <button class="btn btn-info" id="buttonDetalhes" data-toggle="modal" data-url=""  data-target="#modal"><i class="fa fa-file-text"></i></button>
                </div>
                <div class="col-md-3">
                  <input type="text" class="form-control" size="4" name="ids" id="ids" disabled>
                </div>
              </div>
            </div>
            <div class="col-md-1 pull-right text-right">
              <a href="{{url('/novo/tickets')}}" class="btn btn-success"><i class="fa fa-plus"></i> Novo</a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-1">
              Id
            </div>
            <div class="col-md-2">
              Contato
            </div>
            <div class="col-md-3">
              Estado
            </div>
            <div class="col-md-2">
              Descrição
            </div>
            <div class="col-md-1 pull-right text-right">
              Quando
            </div>
          </div>
          <div class="row">
            @foreach ($tickets as $key => $ticket)
              <div class="row list-contacts" onclick="selectRow({{$ticket->id}})">
                <div class="col-md-1">
                  <span class="label label-info">
                    id: {{$ticket->id}}
                  </span>
                </div>
                <div class="col-md-2">
                  <a data-toggle="modal" data-url="{{url('lista/contatos')}}/{{$ticket->contato->id}}"  data-target="#modal" class="label label-primary">
                    <i class="fa fa-user"></i>
                    {{$ticket->contato->nome}}
                  </a>
                </div>
                <div class="col-md-3">
                  {{$ticket->status}}
                </div>
                <div class="col-md-5">
                  {{strip_tags($ticket->descricao)}}
                </div>
                <div class="col-md-1 pull-right text-right">
                  <span class="label label-info">
                    {{date('d/m/Y', strtotime($ticket->created_at))}}
                  </span>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>
  <script language="javascript">
  var imageStatus = false;
    function selectRow(id){
      window.id_attach_form = id;
      $("#ids").val(id);
      $("#buttonDelete").attr('href', '{{ url('lista/tickets') }}/'+id+'/delete/');
      $("#buttonEdit").attr('href', '{{ url('novo/tickets') }}/'+id+'/edit/');
      $("#buttonDetalhes").attr('data-url', '{{ url('lista/tickets') }}/'+id);
    }
  </script>

@endsection
