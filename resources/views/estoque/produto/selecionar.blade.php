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
          @buscaModal(buscarContatos())
          <button type="button" class="btn btn-success" onclick="novoProduto()"><i class="fa fa-plus"></i></button>
        </div>
      <div id="contatosHolder">
        @foreach ($produtos as $key => $produto)
          <div class="row list-contacts" onclick="retornarEsta({{$produto->id}}, '{{$produto->nome}}')">
            <div class="col-md-1">
              <span class="label label-info">
                ID: {{$produto->id}}
              </span>
            </div>
            <div class="col-md-3">
              {{$produto->nome}}
            </div>
            <div class="col-md-3">
              <span class="label label-info">
                {{$produto->barras}}
              </span>
            </div>
            <div class="col-md-2">
              <span class="label label-info">
                {{$produto->unidade}}
              </span>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div class="modal-footer">
      @botaoFecharModal

    </div>
  </div>
</div>
<script>
function retornarEsta(id, nome) {
  window.contatos_id = id;
  window.contatos_nome = nome;
 $('#modal').modal('toggle');
};
function buscarContatos(){
  $("#contatosHolder").html("");

  var url = "{{url('lista/produtos/selecionar')}}";
  var data = {
            'busca'              : $('input[name=busca]').val(),
            '_token'            : $('input[name=_token]').val()
        };

  $.ajax({
    type: "POST",
    url: url,
    data: data,
    success: function( data ) {
      $("#contatosHolder").html(data);
    }
  });
}
function novoProduto(){
  $("#contatosHolder").html("");
  var url = "{{url('lista/produtos/selecionar/novo')}}";
  console.log(url);
  $.ajax({
    type: "GET",
    url: url,
    success: function( data ) {
      $("#contatosHolder").html(data);
    }
  });
}
</script>
