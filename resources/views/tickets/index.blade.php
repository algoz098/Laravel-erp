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
                <div class="col-md-8">
                  @botaoDelete
                  @botaoEditar
                  @botaoDetalhes
                  <a href="" class="btn btn-info" id="buttonAndamento"><i class="fa fa-file-text-o"></i></a>
                </div>
                <div class="col-md-3">
                  @idSelecionado
                </div>
              </div>
            </div>
            <div class="col-md-1 pull-right text-right">
              @botaoNovo(tickets)
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
                  @mostraContato($ticket->contato->id*$ticket->contato->nome)
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
  <script language="javascript">
  var imageStatus = false;
    function selectRow(id){
      window.id_attach_form = id;
      $("#ids").val(id);
      $("#botaoDelete").attr('href', '{{ url('lista/tickets') }}/'+id+'/delete/');
      $("#buttonAndamento").attr('href', '{{ url('lista/tickets') }}/'+id+'/andamento/');
      $("#botaoEditar").attr('href', '{{ url('novo/tickets') }}/'+id+'/edit/');
      $("#botaoDetalhes").attr('onclick', 'openModal("{{ url('lista/tickets') }}/'+id+'")');
    }
  </script>

@endsection
