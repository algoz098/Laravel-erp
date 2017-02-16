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
      <form method="POST">
        <div class="form-group form-inline text-center">
          {{ csrf_field() }}
          <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca">
          <button type="button" class="btn btn-success" onclick="buscarContatos()"><i class="fa fa-search"></i> Buscar</button>
          <button type="button" class="btn btn-success" onclick="novoContato()"><i class="fa fa-plus"></i></button>
        </div>
      </form>
      <div id="contatosHolder">
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
function buscarContatos(){
  $("#contatosHolder").html("");
  var url = "{{url('lista/contatos/selecionar')}}";
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
function novoContato(){
  $("#contatosHolder").html("");
  var url = "{{url('lista/contatos/selecionar/novo')}}";
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
