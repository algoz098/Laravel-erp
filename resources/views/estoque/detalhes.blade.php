<div class="modal-dialog modal-lg extra" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="addTelefonesLabel">
        Detalhes: <span class="label label-info">{{$estoque->produto->nome}}</span>
      </h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-3 pull-right text-center">
          <button class="btn btn-info" onclick="showDesc()">
            Ver descrição
          </button>
          <a class="btn btn-success" onclick="attachForm()">
            Adicionar anexo
          </a>
          <hr>
          @if($estoque->attachs)
            @foreach($estoque->attachs as $key => $attach)
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
          <span id="contentDiv">
            <div class="row">
              <div class="col-md-2">
                <strong>Filial:</strong>
              </div>
              <div class="col-md-2">
                {{str_limit($estoque->contato->nome, 10)}}
              </div>
              <div class="col-md-1">
                <strong>G/T:</strong>
              </div>
              <div class="col-md-2">
                {{$estoque->produto->grupo}}/
                {{$estoque->produto->tipo}}
              </div>
              <div class="col-md-1">
                <strong>Custo:</strong>
              </div>
              <div class="col-md-2">
                R$ {{ number_format($estoque->produto->custo, 2) }}
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <strong>Cod. barras:</strong>
              </div>
              <div class="col-md-2">
                <a href="{{url('novo/produto/')}}/{{$estoque->produto->id}}" class="label label-primary">
                  <i class="fa fa-pencil"></i>
                  {{$estoque->produto->barras}}
                </a>
              </div>
              <div class="col-md-1">
                <strong>Nome:</strong>
              </div>
              <div class="col-md-2">
                {{$estoque->produto->nome}}
              </div>
              <div class="col-md-1">
                <strong>Qtd:</strong>
              </div>
              <div class="col-md-2">
                {{$estoque->quantidade}} {{$estoque->produto->unidade}}
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12">
                @foreach ($estoque->produto->campos as $key => $campo)
                  <div class="row list-contacts">
                    <div class="col-md-1">
                      {{$campo->id}}
                    </div>
                    <div class="col-md-3">
                      {{$campo->nome}}
                    </div>
                    <div class="col-md-3">
                      {{$campo->valor}}
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <strong>Descrição:</strong>
                {!! $estoque->descricao !!}
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <strong>Localizada:</strong><br>
                A peça esta localizada em: {{$estoque->contato->endereco }} - {{$estoque->contato->bairro }} - {{$estoque->contato->cidade }}
              </div>
            </div>
          </span>
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
      @botaoFecharModal
      @botaoEditarExtenso(novo/estoque*$estoque->id)

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
$('#contentDiv').height(height-50);
function showDesc(){
  $('#contentDiv').show();
  $('#contentDiv2').hide();
  $( "#dataSpace" ).html( "" );
  $('#object').attr("height", "0");
};
function attachForm(){
  $('#object').attr("height", "0");
  window.modalurl = "{{url('lista/estoque')}}/{{$estoque->id}}"
  $('#contentDiv2').show();
  $( "#contentDiv").hide();
  $.get( "{{ url('/attach') }}/Estoque/{{$estoque->id}}/{{$estoque->contato->id}}", function( data ) {
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
