<div class="modal-dialog  modal-lg extra" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="addTelefonesLabel">Detalhes da frota: {{$frota->id}}</h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="row text-center">
            <div class="col-md-3 pull-right text-center">
              <a class="btn btn-success" onclick="attachForm()">
                Adicionar anexo
              </a>
              <hr>
              @if($frota->attachs)
                @foreach($frota->attachs as $key => $attach)
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
              <div class="row" id="contentDiv">
                <div class="row">
                  <div class="col-md-4">
                    Vinculado a:
                    <span class="label label-info">{{$frota->contato->nome}}</span>
                    <br>
                    Marca:
                    <span class="label label-info">{{$frota->marca}}</span>
                    <br>
                    Placa:
                    <span class="label label-info">{{$frota->placa}}</span>
                    <br>
                    Modelo do ano:
                    <span class="label label-info">{{$frota->modelo}}</span>
                  </div>
                  <div class="col-md-4">
                    Combustivel:
                    <span class="label label-info">{{$frota->combustivel}}</span>
                    <br>
                    Ano da compra:
                    <span class="label label-info">{{$frota->compra}}</span>
                    <br>
                    Renavam:
                    <span class="label label-info">{{$frota->renavan}}</span>
                    <br>
                    Chassi:
                    <span class="label label-info">{{$frota->chassis}}</span>
                  </div>
                </div>
                <div class="col-md-12">
                  <hr>
                  @foreach ($frota->abastecimentos as $key => $abastecimento)
                    <div class="row list-contacts" id="abastecimento{{$abastecimento->id}}">
                      <div class="col-md-1" onclick="deleteAbastecimento({{$abastecimento->id}})">
                        <a class="btn btn-danger btn-xs ">
                          <i class="fa fa-ban"></i>
                        </a>
                      </div>
                      <a href="{{url('lista/frotas')}}/{{$abastecimento->frota->id}}/abastecer/{{$abastecimento->id}}">
                        <div class="col-md-2">
                          <span class="label label-info">
                            {{$abastecimento->data}}
                          </span>
                        </div>
                        <div class="col-md-2">
                          <span class="label label-info">em: {{str_limit($abastecimento->em->nome, 5)}}</span>
                        </div>
                        <div class="col-md-2">
                          <span class="label label-info">por: {{str_limit($abastecimento->por->nome, 5)}}</span>
                        </div>
                        <div class="col-md-1">
                          <span class="label label-info">Lts: {{$abastecimento->lts}}</span>
                        </div>
                        <div class="col-md-1">
                          <span class="label label-info">R$ {{$abastecimento->preco_lts}}</span>
                        </div>
                        <div class="col-md-1">
                          <span class="label label-info">R$ {{$abastecimento->conta->valor}},00</span>
                        </div>
                        @if ($abastecimento->estado=="0")
                          <div class="col-md-2">
                            <span class="label label-warning">
                              Km/lts: {{$abastecimento->km_rodados/$abastecimento->lts}}
                            </span>
                          </div>
                        @endif
                      </a>
                    </div>
                  @endforeach
                </div>
              </div>
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

      <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      @ifPerms(frotas*edicao)
        <a href="{{ url('novo/frota') }}/{{$frota->id}}/edit"><button type="submit" class="btn btn-primary">Editar</button></a>
      @endPerms
    </div>
  </div>
</div>
<script>
var imageStatus = false;
function deleteAbastecimento(id){
  $.get( "{{ url('/lista/abastecimentos') }}/"+id+"/delete", function( data ) {
    $( ".result" ).html( data );
    $('#abastecimento' + id).remove();
  });
}
function showDesc(){
  $('#contentDiv').show();
  $( "#dataSpace" ).html( "" );
  $('#object').attr("height", "0");
};
function attachForm(){
  $('#object').attr("height", "0");
  window.modalurl = "{{url('lista/frotas')}}/{{$frota->id}}"
  $.get( "{{ url('/attach') }}/Frotas/{{$frota->id}}", function( data ) {
    $( "#contentDiv").hide();
    $( "#dataSpace" ).html( data );
  });
  var imageStatus = true;
}
function loadImage(id) {
  $( "#dataSpace" ).html( "" );
  $( "#contentDiv").hide();
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
