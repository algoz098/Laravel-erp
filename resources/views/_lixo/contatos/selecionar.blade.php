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
          @buscaSimples(lista/contatos*Contatos)
          @if ($apenas_filial==TRUE)
            <input type="hidden" id="apenas_filial" value="TRUE">
          @else
            <input type="hidden" id="apenas_filial" value="FALSE">
          @endif
          @ifPerms(contatos*adicao)
            <button type="button" class="btn btn-success" onclick="novoContato()"><i class="fa fa-plus"></i></button>
          @endPerms
        </div>
        <span id="listaHolderContatos"></span>
    </div>
    <div class="modal-footer">
      @botaoFecharModal
      <button type="button" class="btn btn-success" style="display: none;" id="botaoSalvarContatos" onclick="enviarContato()">
        <i class="fa fa-check"></i> Salvar
      </button>
    </div>
  </div>
</div>
<script>
function selectRow(){
  console.log("Select Row");
};
$(document).ready(function(){
  efetuarBusca("{{ url('lista/contatos') }}", "Contatos");
  $('#busca').focus();
  window.focandoEnter ="botaoBuscaSimples";
});
function novoContato(){
  $("#listaHolderContatos").html("");
  var url = "{{url('lista/contatos/selecionar/novo')}}";
  console.log(url);
  $.ajax({
    type: "GET",
    url: url,
    success: function( data ) {
      $("#listaHolderContatos").html(data);
      $("#botaoSalvarContatos").show();
      window.focandoEnter ="botaoSalvarContatos";
      tinymce.init({
        selector: 'textarea',
        height: 200,
        menubar: false,
        plugins: [
          'advlist autolink lists link charmap print preview anchor',
          'searchreplace visualblocks code fullscreen',
          'insertdatetime table contextmenu paste code'
        ],
        toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',

      });
    }
  });
}
</script>
