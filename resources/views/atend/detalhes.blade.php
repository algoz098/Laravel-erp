<div class="modal-dialog  modal-lg extra" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="addTelefonesLabel">Detalhes atendimento: {{$atendimento->id}}</h4>
    </div>
    <div class="modal-body">
      <div class="row text-center">
        <div class="col-md-4">
          <div class="form-group">
            <label for="assunto">Assunto</label>
            <div>{{$atendimento->assunto}}</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="contato">Contato</label>
            <div>{{$atendimento->contatos->nome}}</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="data">Data do atendimento</label>
            <div>{{date('H:i d/m/Y', strtotime($atendimento->created_at))}}</div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 pull-right text-center">
          <button class="btn btn-info" onclick="showDesc()">
            Ver descrição
          </button>
          <a class="btn btn-success" onclick="attachForm()">
            Adicionar anexo
          </a>
          <hr>
          @if($atendimento->attachs)
            @foreach($atendimento->attachs as $key => $attach)
              <div class="row list-contacts" id="attachRow{{$attach->id}}">
                {{$attach->name}}
                <span class="label label-info" onClick="loadImage({{$attach->id}})"  >Ver</span>
                <a href="{{ url('/attach') }}/{{$attach->id}}/get"  class="label label-info" >Salvar</a>
                <a onClick="deleteImage({{$attach->id}})" class="label label-danger" >Apagar</a>
              </div>
            @endforeach
          @endif
        </div>
        <div class="col-md-9">
          <div class="form-group sub-image-div" id="contentDiv">
            <label for="data" id="contentLabel">Descrição do atendimento</label>
            <div class="panel panel-default">
              <div class="panel-body">
                <div id="contentHolder">{!!$atendimento->texto!!}</div>
              </div>
            </div>
          </div>
          <div class="panel panel-default" style="display:none" id="contentDiv2">
            <div class="panel-body">
              <span id="dataSpace"></span>
              <object data="" id="object" width="100%" height="0" ></object>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <div class="col-md-2 pull-right">
        <div class="input-group">
          <input type="text" class="form-control" value="" id="widthChanger" placeholder="mudar a">
          <span class="input-group-btn">
            <button class="btn btn-warning" type="button" onclick="changeWidth()">Largura</button>
          </span>
        </div>
      </div>
      <button type="submit" class="btn btn-info" onclick="fullImage()"><i class="fa fa-search"></i> Alterar tamanho</button>
      <button type="submit" class="btn btn-primary" onclick="rotateUnclock()"><i class="fa fa-arrow-left"></i> Rotacionar</button>
      <button type="submit" class="btn btn-primary" onclick="rotateClock()"><i class="fa fa-arrow-right"></i> Rotacionar</button>

      @botaoFecharModal
      @ifPerms(atendimentos*edicao)
        @botaoEditarExtenso(novo/atendimentos*$atendimento->id)
      @endPerms
    </div>
  </div>
</div>
<script>
var imageStatus = false;
$('#contentDiv').height(height-50);
function showDesc(){
  $('#contentDiv').show();
  $('#contentDiv2').hide();
  $( "#dataSpace" ).html( "" );
  $('#object').attr("height", "0");
};
function attachForm(){
  $('#object').attr("height", "0");
  window.modalurl = "{{url('lista/atendimentos')}}/{{$atendimento->id}}"
  $('#contentDiv2').show();
  $( "#contentDiv").hide();
  $.get( "{{ url('/attach') }}/Atendimento/{{$atendimento->id}}/{{$atendimento->contatos->id}}", function( data ) {
    $( "#dataSpace" ).html( data );
  });
  var imageStatus = true;
}
function loadImage(id) {
  $( "#dataSpace" ).html( "" );
  $('#contentDiv2').show();
  $( "#contentDiv").hide();
  $('#object').attr("data", "{{ url('/attach') }}/"+id+"/size/"+height);
  $('#object').attr("height", height-70);
  window.attachId = id;
  var imageStatus = true;
};
function deleteImage(id){
  $.get( "{{ url('/attach') }}/"+id+"/delete", function( data ) {
    $( ".result" ).html( data );
    $('#attachRow' + id).remove();
  });
}
function fullImage() {
  if (imageStatus=true) {
    $('#object').attr("data", "{{ url('/attach') }}/"+window.attachId);
    imageStatus=false;
  } else {
    loadImage(window.attachId);
    imageStatus=true;
  }
};
  function rotateClock() {
    $.get( "{{ url('/attach') }}/"+window.attachId+"/rotate/clock", function( data ) {
      $( ".result" ).html( data );
      $('#object').attr("data", "{{ url('/attach') }}/"+window.attachId);
    });
  };
  function rotateUnclockid() {
    $.get( "{{ url('/attach') }}/"+id+"/rotate/unclock", function( data ) {
      $( ".result" ).html( data );
      $('#object').attr("data", "{{ url('/attach') }}/"+window.attachId);
    });
  };
  function changeWidth() {
    var width = $('#widthChanger').val();
    $.get( "{{ url('/attach') }}/"+window.attachId+"/resize/"+width, function( data ) {
      $( ".result" ).html( data );
      $('#object').attr("data", "{{ url('/attach') }}/"+window.attachId);
    });
  };
  </script>
