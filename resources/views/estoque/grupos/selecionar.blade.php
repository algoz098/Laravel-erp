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
          <a onclick="voltarUmNivel()" class="btn btn-warning" title="Voltar">
            <i class="fa fa-arrow-left"></i>
          </a>
          @buscaSimples(lista/produtos/grupo*Grupos)
          <button type="button" class="btn btn-success" onclick="novoGrupo()" id="botaoNovoModalGrupos"><i class="fa fa-plus"></i></button>
        </div>
      <div id="listaHolderGrupos"></div>
    </div>
    <div class="modal-footer">
      @botaoFecharModal
      <button type="button" class="btn btn-success" style="display: none;" id="botaoSalvarGrupo" onclick="botaoSalvarGrupo()">
        <i class="fa fa-check"></i> Salvar
      </button>
    </div>
  </div>
</div>
<script>

function selectRow(){};
function voltarUmNivel(){
  $('#botaoNovoModalGrupos').attr('onclick', 'novoGrupo()');
  $('#botaoSalvarGrupo').attr('onclick', 'botaoSalvarGrupo()');
  var url = "{{url('lista/produtos/grupo/')}}";
  $("#listaHolderGrupos").addClass("carregando");
  var data = {
            '_token'            : $('input[name=_token]').val(),
            'busca'       : "",
        };
  $.ajax({
    type: 'post',
    url: url,
    data: data,
    success: function( data ) {
      $( "#listaHolderGrupos" ).html( data );
      $("#botaoSalvarGrupo").hide();
      window.focandoEnter ="botaoBuscaSimples";
    },
  });
  $("#listaHolderGrupos").removeClass("carregando");

};
function produtoTipoBusca(id){
  $('#botaoNovoModalGrupos').attr('onclick', 'novoTipo('+id+')');
  $('#botaoSalvarGrupo').attr('onclick', 'botaoSalvarTipo()');
  var url = "{{url('lista/produtos/tipo/')}}";
  $("#listaHolderGrupos").addClass("carregando");
  var data = {
            '_token'            : $('input[name=_token]').val(),
            'id'       : id,
        };
  $.ajax({
    type: 'post',
    url: url,
    data: data,
    success: function( data ) {
      $("#listaHolderGrupos").removeClass("carregando");
      $( "#listaHolderGrupos" ).html( data );
      $("#botaoSalvarGrupo").hide();
      window.focandoEnter ="botaoBuscaSimples";
    },
    error: function(xhr, status, error) {
      $("#listaHolderGrupos").removeClass("carregando");
      window.focandoEnter ="botaoBuscaSimples";
    },
  });
}
function retornarEsta(id, nome) {
  if (($("#modal2").data('bs.modal') || {}).isShown) {
    window.contatos_id2 = id;
    window.contatos_nome2 = nome;
    $('#modal2').modal('toggle');
  } else {
    window.contatos_id = id;
    window.contatos_nome = nome;
    $('#modal').modal('toggle');
  }
};
efetuarBusca("{{url('lista/produtos/grupo/')}}", "listaHolderGrupos");
function botaoSalvarGrupo(){
  var url = "{{url('lista/produtos/grupo/novo')}}";
  $("#listaHolderGrupos").addClass("carregando");
  var data = {
            '_token'            : $('input[name=_token]').val(),
            'nome'       : $('#produto_grupo_nome').val(),
        };
        console.log(data);
  $.ajax({
    type: 'post',
    url: url,
    data: data,
    success: function( data ) {
      var title = "@lang('messages.sucesso.title')";
      var message = "@lang('messages.sucesso.mensagem')";
      $.toaster({ message : message, title : title, priority : 'success' , settings : {'timeout' : 3000,}});
      $("#listaHolderGrupos").removeClass("carregando");
      $( "#listaHolderGrupos" ).html( data );
      efetuarBusca('{{url('lista/produtos/grupo')}}', 'Grupos');
      $("#botaoSalvarGrupo").hide();
      window.focandoEnter ="botaoBuscaSimples";
    },
  });
}
function novoGrupo(){
  $("#listaHolderGrupos").html("");
  var url = "{{url('lista/produtos/grupo/novo')}}";
  $.ajax({
    type: "GET",
    url: url,
    success: function( data ) {
      $("#listaHolderGrupos").html(data);
      $("#botaoSalvarGrupo").show();
      window.focandoEnter ="botaoSalvarGrupo";
    }
  });
}
function novoTipo(id){
  $("#listaHolderGrupos").html("");
  var url = "{{url('lista/produtos/tipo/novo/')}}/"+id;
  $.ajax({
    type: "GET",
    url: url,
    success: function( data ) {
      $("#listaHolderGrupos").html(data);
      $("#botaoSalvarGrupo").show();
      window.focandoEnter ="botaoSalvarGrupo";
    }
  });
}

efetuarBusca("{{url('lista/produtos/grupo/')}}", "Grupos");

function botaoSalvarTipo(){
  var url = "{{url('lista/produtos/tipo/novo')}}";
  $("#listaHolderGrupos").addClass("carregando");
  var data = {
            '_token'          : $('input[name=_token]').val(),
            'nome'            : $('#produto_tipo_nome').val(),
            'grupos_id'       : $('#grupo_selecionado_id').val(),
        };
        console.log(data);
  $.ajax({
    type: 'post',
    url: url,
    data: data,
    success: function( data ) {
      var title = "@lang('messages.sucesso.title')";
      var message = "@lang('messages.sucesso.mensagem')";
      $.toaster({ message : message, title : title, priority : 'success' , settings : {'timeout' : 3000,}});
      $("#listaHolderGrupos").removeClass("carregando");
      $( "#listaHolderGrupos" ).html( data );
      efetuarBusca('{{url('lista/produtos/tipo')}}', 'Grupos');
      $("#botaoSalvarGrupo").hide();
      window.focandoEnter ="botaoBuscaSimples";
    },
  });
}

</script>
