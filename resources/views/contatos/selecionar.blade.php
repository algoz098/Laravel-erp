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
      @foreach ($contatos as $key => $contato)
        <div class="row list-contacts" onclick="retornarEsta({{$contato->id}}, '{{$contato->nome}}')">
          <div class="col-md-1">
            <span class="label label-info">
              ID: {{$contato->id}}
            </span>
          </div>
          <div class="col-md-11">
            {{$contato->nome}}
          </div>
        </div>
      @endforeach
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

    </div>
  </div>
</div>
<script>
function retornarEsta(id, nome) {
  window.contatos_id = id;
  window.contatos_nome = nome;
 $('#modal').modal('toggle');
};
</script>
