<div class="modal-dialog modal-lg extra" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="addTelefonesLabel">
        Detalhes: <span class="label label-info">{{$nf->nome}}</span>
      </h4>
    </div>
    <div class="modal-body">
      aaa
    </div>
    <div class="modal-footer">
      @botaoFecharModal
      @ifPerms(estoques*adicao)
        @botaoEditarExtenso(novo/nf-entrada*$nf->id)
      @endPerms
    </div>
  </div>
</div>
