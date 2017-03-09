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
          @buscaModal(buscarBancos())
          @ifPerms(bancos*adicao)
            <a href="{{url('novo/bancos/')}}"class="btn btn-success"><i class="fa fa-plus"></i></a>
          @endPerms
        </div>
      <div id="contatosHolder">

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
$(document).ready(buscarBancos());
function buscarBancos(){
  $("#contatosHolder").html("");
  var url = "{{url('lista/bancos/selecionar')}}";
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
</script>
