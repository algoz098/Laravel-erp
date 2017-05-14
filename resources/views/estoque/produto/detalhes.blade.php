<div class="modal-dialog modal-lg extra" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="addTelefonesLabel">
        Detalhes: <span class="label label-info">{{$produto->nome}}</span>
      </h4>
    </div>
    <div class="modal-body">
      aaa
    </div>
    <div class="modal-footer">
      @botaoFecharModal
      @ifPerms(estoques*adicao)
        @botaoEditarExtenso(novo/produto*$produto->id)
      @endPerms
    </div>
  </div>
</div>
<script>
  function apagaCampoExtra(id){
    a = "{{url('/lista/produtos')}}/campos/"+id+"/delete"
    $.get( a, function( data ) {
      $( "#campo"+id ).remove();
    });
  }
</script>
