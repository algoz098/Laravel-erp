<div class="modal-dialog modal-lg extra" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="">
        <i class="fa fa-user"></i>
        Selecionar
      </h4>
    </div>
    <div class="modal-body">
        <div class="form-group form-inline text-center">
          {{ csrf_field() }}
          @buscaSimples(lista/produtos*Produtos)
          <button type="button" class="btn btn-success" onclick="novoProduto()"><i class="fa fa-plus"></i></button>
        </div>
        <div id="listaHolderProdutos" class="lista-holder-rolagem"></div>
    </div>
    <div class="modal-footer">
      @botaoFecharModal
      <a onclick="salvarProduto()" class="btn btn-success" id="botaoSalvarProduto" style="display: none;">
        <i class="fa fa-check"></i> Salvar
      </a>
    </div>
  </div>
</div>
<script>
function selectRow(){};

efetuarBusca("{{url('lista/produtos')}}", 'Produtos');
function novoProduto(){
  $("#listaHolderProdutos").html("");
  var url = "{{url('lista/produtos/selecionar/novo')}}";
  console.log(url);
  $.ajax({
    type: "GET",
    url: url,
    success: function( data ) {
      $("#listaHolderProdutos").html(data);
      $("#botaoSalvarProduto").show();
    }
  });
}
function salvarProduto(){
  var url = "{{url('novo/produto')}}";

  var b = 0;
  var campo_nome = new Array;
  var campo_valor = new Array;
  while (b <= e){
    campo_nome[e] = $('#campo_nome'+b).val();
    campo_valor[e] = $('#campo_valor'+b).val();
    b++;
  }
  var data = {
            '_token'            : $('input[name=_token]').val(),
            'barras'            : $('#barras').val(),
            'produtos_grupos_id': $('#grupoHidden').val(),
            'contatos_id'       : $('#contatosHidden').val(),
            'nome'              : $('#nome').val(),
            'unidade'           : $('#unidade').val(),
            'embalagem'         : $('#embalagem').val(),
            'custo'             : $('#custo').val(),
            'margem'            : $('#margem').val(),
            'venda'             : $('#venda').val(),
            'minimo'            : $('#minimo').val(),
            'maximo'            : $('#maximo').val(),
            'descricao'         : $('#descricao').val(),
            'campo_nome'        : campo_nome,
            'campo_valor'       : campo_valor
        };

  $.ajax({
    type: "POST",
    url: url,
    data: data,
    success: function( data ) {
      efetuarBusca("{{url('lista/produtos')}}", 'Produtos')
    }
  });
}
</script>
