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
            <div class="col-md-7">
              <div class="form-group form-inline text-center">
                @buscaSimples(lista/tickets*Tickets)
              </div>
            </div>
            <div class="col-md-1 pull-right text-right">
              @botaoNovo(tickets)
            </div>
          </div>
          <div id="listaHolderTickets"></div>
        </div>
      </div>
    </div>
  </div>
<script language="javascript">
  $(document).ready(function(){
    efetuarBusca('{{url('lista/tickets')}}', 'Tickets')
  });
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
