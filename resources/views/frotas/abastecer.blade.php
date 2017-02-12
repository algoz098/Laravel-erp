@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-tint fa-1x"></i> Abastecer
        </div>
        <div class="panel-body">
          <form method="POST" action="{{ url('/lista/frotas') }}/{{$frota->id}}/abastecer">
            {{ csrf_field() }}
            <div id="secondNavbar" class="row">
              <div class="col-md-1 pull-right text-right ajuda-popover">
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
                        <input type="hidden" class="form-control" id="porHidden" name="abastecido_por" >
                        <input type="text" class="form-control" id="por" disabled>
                        <a onclick="window.activeTarget='por'" data-toggle="modal"  data-target="#modal" data-url="{{url('lista/contatos/selecionar')}}" class="input-group-addon btn btn-info"><i class="fa fa-gear"></i></a>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="por">Abastecido em:</label>
                      <div class="input-group">
                        <input type="hidden" class="form-control" id="emHidden" name="abastecido_em" >
                        <input type="text" class="form-control" id="em" disabled>
                        <a onclick="window.activeTarget='em'" data-toggle="modal"  data-target="#modal" data-url="{{url('lista/contatos/selecionar')}}" class="input-group-addon btn btn-info"><i class="fa fa-gear"></i></a>
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
                      <input type="text" class="form-control datepicker" id="data" name="data" placeholder="Data">
                    </div>
                    <div class="form-group">
                      <label for="combustivel">Combustivel usado:</label>
                      <select class="form-control" id="combustivel" name="combustivel">
                        <option value="">- Escolha -</option>
                        <option value="Gasolina">Gasolina</option>
                        <option value="Alcool">Alcool</option>
                        <option value="Gas">Gas</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="documento">Documento:</label>
                      <input type="text" class="form-control " id="documento" name="documento" placeholder="documento">
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
                        <input type="text" class="form-control" id="lts" name="lts">
                        <span class="input-group-addon">Lts</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="preco_lts">Preço por litro:</label>
                      <div class="input-group">
                        <span class="input-group-addon">R$</span>
                        <input type="text" class="form-control real-mask" id="preco_lts" name="preco_lts">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="preco_lts">Total gasto:</label>
                      <div class="input-group">
                        <span class="input-group-addon">R$</span>
                        <input type="text" class="form-control real-mask" id="total_lts" disabled>
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
                        <input type="text" class="form-control integer-mask" id="km_anterior" name="km_anterior">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="km_atual">Kilometragem Atual:</label>
                      <div class="input-group">
                        <span class="input-group-addon">KM</span>
                        <input type="text" class="form-control integer-mask" id="km_atual" name="km_atual">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="km_rodado">Kilometros rodados:</label>
                      <div class="input-group">
                        <span class="input-group-addon">KM</span>
                        <input type="text" class="form-control integer-mask" id="km_rodado" name="km_rodado">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="km_lts">KM/Lts:</label>
                      <input type="text" class="form-control integer-mask" id="km_lts" name="km_lts">
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

  <!-- Modal -->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>
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