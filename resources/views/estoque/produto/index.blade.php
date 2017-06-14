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
                @botaoNovo(produto)
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
                @buscaSimples(lista/produtos*Produtos)
                @buscaExtraBotao
              </div>
            </div>
          </div>
          <div id="buscaAvançada" class="row collapse " aria-expanded="" style="background-color: #fff; z-index:1030;">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-4">
                  @selecionaProdutoGrupo
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  @campoTexto(Aplicação*aplicacaoBusca*)
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  @campoTexto(Fabricante*fabricanteBusca*)
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  @campoTexto(Codigos*codigoBusca*)
                </div>
              </div>
            </div>
          </div>
          <div id="listaHolderProdutos"></div>
        </div>
      </div>
    </div>
  </div>
  <script>
  $(document).ready(function (){
    efetuarBusca('{{url('lista/produtos')}}', 'Produtos');
  });
    var imageStatus = false;
    function selectRow(id){
      window.id_attach_form = id;
      $("#ids").val(id);
      $("#botaoDelete").attr('href', '{{ url('lista/produtos') }}/'+id+'/delete/');
      $("#botaoDetalhes").attr('onclick', 'openModal("{{ url('lista/produtos') }}/'+id+'")');
      $("#botaoEditar").attr('href', '{{ url('novo/produto') }}/'+id);
    }
  </script>
@endsection
