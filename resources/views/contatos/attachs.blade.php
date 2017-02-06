<div class="modal-dialog modal-lg extra" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="">
        <i class="fa fa-paperclip"></i>
        Anexos
      </h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-3 pull-right text-center">
          <a class="btn btn-success" onclick="attachForm()">
            Adicionar anexo
          </a>
          <hr>
          @foreach($attachs as $key => $attach)
            <div class="row list-contacts" id="attachRow{{$attach->id}}">
              {{$attach->name}}
              <span class="label label-info" onClick="loadImage({{$attach->id}})"  >Ver</span>
              <a href="{{ url('/attach') }}/{{$attach->id}}/get"><span class="label label-info" >Salvar</span></a>
              <a onClick="deleteImage({{$attach->id}})" class="label label-danger">Apagar</a>
            </div>
          @endforeach
        </div>
        <div class="col-md-9 text-left" onClick="fullImage()" id="object-holder">
          <span id="dataSpace"></span>
          <object data="" id="object" width="100%" height="50" ></object>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
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
    </div>
  </div>
</div>

<script>
var imageStatus = false;
function loadImage(id) {
  $( "#dataSpace" ).html( "" );
  $('#object').attr("data", "{{ url('/attach') }}/"+id+"/size/"+height);
  $('#object').attr("height", height);
  window.attachId = id;
  var imageStatus = true;
};
function deleteImage(id){
  $.get( "{{ url('/attach') }}/"+id+"/delete", function( data ) {
    $( ".result" ).html( data );
    $('#attachRow' + id).remove();
  });
}
function attachForm(){
  $('#object').attr("height", "0");
  window.modalurl = "{{url('lista/contatos/')}}/{{$contato_id}}/attachs"
  $.get( "{{ url('/attach') }}/Contatos/{{$contato_id}}", function( data ) {
    $( "#dataSpace" ).html( data );
  });
  var imageStatus = true;
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
