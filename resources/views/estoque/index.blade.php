@extends('main')
@section('content')
  {{ csrf_field() }}
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-bell-o fa-1x"></i> Estoques
        </div>
        <div class="panel-body">
          <div class="row" id="secondNavbar">
            <div class="col-md-2 pull-right text-right">
              @ifPerms(estoques*adicao)
              @botaoNovo(estoques*produto*Estoque*Produto)
              @endPerms
            </div>
            <div class="col-md-3">
              <div class="row">
                <div class="col-md-6 text-right">
                  @ifPerms(estoques*edicao)
                    @botaoDelete
                    @botaoEditar
                  @endPerms
                  @botaoDetalhes
                </div>
                <div class="col-md-3 text-left">
                  @idSelecionado
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group form-inline text-center">
                @buscaSimples(lista/estoques*Estoques)
              </div>
            </div>
          </div>
          <div id="listaHolderEstoques"></div>
        </div>
      </div>
    </div>
  </div>
  <script>
  $(document).ready(function (){
    efetuarBusca('{{url('lista/estoques')}}', 'Estoques');
  });
    var imageStatus = false;
    function selectRow(id){
      window.id_attach_form = id;
      $("#ids").val(id);
      $("#botaoDelete").attr('href', '{{ url('lista/estoques') }}/'+id+'/delete/');
      $("#botaoDetalhes").attr('onclick', 'openModal("{{ url('lista/estoques') }}/'+id+'")');
      $("#botaoEditar").attr('href', '{{ url('novo/estoques') }}/'+id);
    }
  </script>
@endsection
