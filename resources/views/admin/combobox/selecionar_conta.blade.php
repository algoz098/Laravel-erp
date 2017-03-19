<div class="modal-dialog modal-lg extra" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="addTelefonesLabel">
        Selecionar opção
      </h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group form-inline text-center">
            {{ csrf_field() }}
            @buscaSimples(lista/combobox/contas*Contas)
          </div>
        </div>
      </div>
      <div id="listaHolderContas"></div>
    </div>
    <div class="modal-footer">
      @botaoFecharModal
    </div>
  </div>
</div>
