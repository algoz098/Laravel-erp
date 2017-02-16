@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-tint fa-1x"></i> Abastecer
        </div>
        <div class="panel-body">
          @if (isset($abastecimento))
            <form method="POST" action="{{ url('/lista/frotas') }}/{{$frota->id}}/abastecer/{{$abastecimento->id}}">
          @else
          <form method="POST" action="{{ url('/lista/frotas') }}/{{$frota->id}}/abastecer">
          @endif
            {{ csrf_field() }}
            <div id="secondNavbar" class="row">
              <div class="col-md-3 pull-right text-right ajuda-popover">
                <a  href="{{url('lista/frotas')}}" class="btn btn-warning">
                  <i class="fa fa-tint fa-1x"></i>
                  Voltar a lista
                </a>
                <button type="submit" class="btn btn-success">
                  <i class="fa fa-check fa-1x"></i>
                  Salvar
                </button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="placa">Placa:</label>
                      <input type="text" class="form-control" id="placa" disabled value="{{$frota->placa}}">
                    </div>
                    <div class="form-group">
                      <label for="por">Abastecido por:</label>
                      <div class="input-group">
                        <input type="hidden" class="form-control" id="porHidden" name="abastecido_por" value="{{isset($abastecimento) ? $abastecimento->por->id : ""}}">
                        <input type="text" class="form-control" id="por" value="{{isset($abastecimento) ? $abastecimento->por->nome : ""}}" disabled>
                        <a onclick="window.activeTarget='por'; openModal('{{url('lista/contatos/selecionar')}}')" class="input-group-addon btn btn-info"><i class="fa fa-gear"></i></a>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="por">Abastecido em:</label>
                      <div class="input-group">
                        <input type="hidden" class="form-control" id="emHidden" name="abastecido_em" value="{{isset($abastecimento) ? $abastecimento->em->id : ""}}">
                        <input type="text" class="form-control" id="em" disabled value="{{isset($abastecimento) ? $abastecimento->em->nome : ""}}">
                        <a onclick="window.activeTarget='em'; openModal('{{url('lista/contatos/selecionar')}}')" class="input-group-addon btn btn-info"><i class="fa fa-gear"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="data">Data:</label>
                      <input type="text" class="form-control datepicker" id="data" name="data" placeholder="Data" value="{{isset($abastecimento) ? $abastecimento->data : ""}}">
                    </div>
                    <div class="form-group">
                      <label for="combustivel">Combustivel usado:</label>
                      <select class="form-control" id="combustivel" name="combustivel">
                        <option value="" selected>- Escolha -</option>
                        <option value="Gasolina" {{isset($abastecimento) and $abastecimento->combustivel=="Gasolina" ? "selected" : ""}}>Gasolina</option>
                        <option value="Alcool" {{isset($abastecimento) and $abastecimento->combustivel=="Alcool" ? "selected" : ""}}>Alcool</option>
                        <option value="Gas" {{isset($abastecimento) and $abastecimento->combustivel=="Gas" ? "selected" : ""}}>Gas</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="documento">Documento:</label>
                      <input type="text" class="form-control " id="documento" name="documento" placeholder="documento" value="{{isset($abastecimento) ? $abastecimento->documento : ""}}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="lts">Litros abastecidos:</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="lts" name="lts" value="{{isset($abastecimento) ? $abastecimento->lts : ""}}">
                        <span class="input-group-addon">Lts</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="preco_lts">Preço por litro:</label>
                      <div class="input-group">
                        <span class="input-group-addon">R$</span>
                        <input type="text" class="form-control real-mask" id="preco_lts" name="preco_lts" value="{{isset($abastecimento) ? $abastecimento->preco_lts : ""}}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="preco_lts">Total gasto:</label>
                      <div class="input-group">
                        <span class="input-group-addon">R$</span>
                        <input type="text" class="form-control real-mask" id="total_lts" disabled value="{{isset($abastecimento) ? $abastecimento->conta->valor : ""}}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="km_anterior">Kilometragem Anterior:</label>
                      <div class="input-group">
                        <span class="input-group-addon">KM</span>
                        <input type="text" class="form-control integer-mask" id="km_anterior" name="km_anterior" value="{{isset($abastecimento) ? $abastecimento->km_anterior : ""}}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="km_atual">Kilometragem Atual:</label>
                      <div class="input-group">
                        <span class="input-group-addon">KM</span>
                        <input type="text" class="form-control integer-mask" id="km_atual" name="km_atual" value="{{isset($abastecimento) ? $abastecimento->km_atual : ""}}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="km_rodado">Kilometros rodados:</label>
                      <div class="input-group">
                        <span class="input-group-addon">KM</span>
                        <input type="text" class="form-control integer-mask" id="km_rodado" name="km_rodado" value="{{isset($abastecimento) ? $abastecimento->km_rodado : ""}}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="km_lts">KM/Lts:</label>
                      <input type="text" class="form-control integer-mask" id="km_lts" name="km_lts" >
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 pull-right">

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<script>

$('#modal').on("hidden.bs.modal", function (e) {
  $('#'+activeTarget+'Hidden').val(window.contatos_id);
  $('#'+activeTarget).val(window.contatos_nome);
});

$(document).ready(function(){
  $("#preco_lts").on("keyup paste", function() {
    $("#total_lts").val($(this).val()*$('#lts').val());
  });
  $("#km_atual").on("keyup paste", function() {
    $("#km_rodado").val($(this).val()-$('#km_anterior').val());
    $("#km_lts").val($("#km_rodado").val()/$('#lts').val());
  });
});
</script>
@endsection
