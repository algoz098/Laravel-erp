<div class="row" id="consumosRow" style="display:none;">
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">Definir detalhes</div>
      <div class="panel-body">
        <div class="form-group">
          <label id="codigoText">Codigo</label>
          <input class="form-control" id="codigo" name="codigo" value="{{{isset($conta) ? $conta->consumo->codigo : ""}}}">
        </div>
        <div class="form-group">
          <label id="mesText">Mes/Ano</label>
          <input class="form-control datepicker_mes_ano" id="mes" name="mes" value="{{{isset($conta) ? $conta->mes : ""}}}">
        </div>
        <div class="form-group">
          <label id="consumoText">Consumo</label>
          <div class="input-group">
            <input class="form-control" id="consumo" name="consumo" value="{{{isset($conta) ? $conta->consumo->consumo : ""}}}">
            <span class="input-group-addon" id="consumoAddon"></span>
          </div>
        </div>
        <div class="form-group" id="catGroup">
          <label id="catText">Cat</label>
          <select class="form-control" id="cat" name="cat" >
            <option value="">- Escolha -</option>
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">Deste mes</div>
      <div class="panel-body">
        <div class="form-group" id="valor_anteriorGroup">
          <label id="valor_anteriorText">valor_anterior</label>
          <div class="input-group">
            <input class="form-control" id="valor_anterior" name="valor_anterior" value="{{{isset($conta) ? $conta->consumo->valor_anterior : ""}}}">
            <span class="input-group-addon" id="valor_anteriorAddon"></span>
          </div>
        </div>
        <div class="form-group" id="valor_atualGroup">
          <label id="valor_atualText">valor_atual</label>
          <div class="input-group">
            <input class="form-control" id="valor_atual" name="valor_atual" value="{{{isset($conta) ? $conta->consumo->valor_atual : ""}}}">
            <span class="input-group-addon" id="valor_atualAddon"></span>
          </div>
        </div>
        <div class="form-group">
          <label id="sub_item1Text">sub_item1</label>
          <div class="input-group">
            <input class="form-control" id="sub_item1" name="sub_item1" value="{{{isset($conta) ? $conta->consumo->sub_item1 : ""}}}">
            <span class="input-group-addon" id="sub_item1Addon"></span>
          </div>
        </div>
        <div class="form-group" id="sub_item2Group">
          <label id="sub_item2Text">sub_item2</label>
          <div class="input-group">
            <input class="form-control" id="sub_item2" name="sub_item2" value="{{{isset($conta) ? $conta->consumo->sub_item2 : ""}}}">
            <span class="input-group-addon" id="sub_item2Addon"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">Outras dicriminações</div>
      <div class="panel-body">
        <div class="form-group">
          <label for="text">Titulo</label>
          <input type="numeric" class="form-control" id="disc_text[0]" name="disc_text[0]">
        </div>
        <div class="form-group">
          <label for="text">Valor</label>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">R$</span>
            <input type="text" class="form-control real-mask" name="disc_valor[0]" id="disc_valor" onchange="totalValor(this.value)">
          </div>
        </div>
        <span id="mais">
          @if (isset($conta))
            @foreach ($conta->discs as $key => $disc)
              <hr>
              <div class="form-group">
                <label for="text">Titulo</label>
                <input type="numeric" class="form-control" id="disc_text_edit{{$key}}" name="disc_text_edit[{{$key}}]" placeholder="Titulo da discriminação" value="{{$disc->text}}">
              </div>
              <div class="form-group">
                <label for="text">Valor</label>
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1">R$</span>
                  <input type="text" class="form-control real-mask" name="disc_valor_edit[{{$key}}]" id="disc_valor_edit{{$key}}" placeholder="valor da discriminação" value="{{$disc->value}}" onchange="totalValor(this.value)">
                </div>
              </div>
            @endforeach
          @endif
        </span>
      </div>
    </div>
  </div>
  <div class="col-md-3 pull-right">
    <div class="row">
      <div class="col-md-12">
        <a class="btn btn-danger" onclick="remove()">
          <i class="fa fa-minus"></i>
        </a>
        <a class="btn btn-success" onclick="add()">
          <i class="fa fa-plus"></i>
        </a>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-12" >
        Total discriminado: <span class="label label-info">R$<span id="discTotal">0</span></span>
      </div>
    </div>
  </div>
</div>

  <script>
    function referenciaChange(){
      if ($('#nome').val()=="1001"){
        $('#consumosRow').show();
        $('#parcelasText').text("Matricula");
        $('#codigoText').text("Identificação");
        $('#consumoAddon').text("Lts.");
        $('#valor_anteriorText').text("Leitura Anterior");
        $('#valor_anteriorAddon').text("Lts.");
        $('#valor_atualText').text("Leitura Atual");
        $('#valor_atualAddon').text("Lts.");
        $('#sub_item1Text').text("Valor Água");
        $('#sub_item1Addon').text("R$");
        $('#sub_item1').maskMoney();
        $('#sub_item2Text').text("Valor Esgoto");
        $('#sub_item2Addon').text("R$");
        $('#sub_item2').maskMoney();
        $('#valor_atualGroup').show();
        $('#sub_item2Group').show();
        $('#catGroup').show();
        $('#catText').text("Categoria");
        $('#cat').find('option')
                .remove()
                .end()
                .append('<option value="">- Escolha -</option>')
                .val('');
        $('#cat').append($('<option>', {
              value: "Residencial",
              text: 'Residencial'
            }));
        $('#cat').append($('<option>', {
              value: "Comercial",
              text: 'Comercial'
            }));
        $('#cat').append($('<option>', {
              value: "Industrial",
              text: 'Industrial'
            }));
      }
      if ($('#nome').val()=="1002"){
        $('#consumosRow').show();
        $('#parcelasText').text("Numero do medidor");
        $('#codigoText').text("Seu Codigo");
        $('#consumoAddon').text("kWH");
        $('#valor_anteriorText').text("Preço médio");
        $('#valor_anteriorAddon').text("R$");
        $('#valor_atualGroup').hide();
        $('#sub_item1Text').text("Valor");
        $('#sub_item1Addon').text("R$");
        $('#sub_item1').maskMoney();
        $('#sub_item2Group').hide();
        $('#catText').text("Categoria");
        $('#catGroup').hide();

      }
    }
    function totalValor(valor){
      var a = parseFloat($('#discTotal').text())+parseFloat(valor);
      $('#discTotal').text(a);
    }

    window.i = 0;
    function add() {
      var $clone = $($('#ToClone').html());
      i = i + 1;
      $('#disc_text', $clone).attr('name', 'disc_text['+i+']');
      $('#disc_valor', $clone).attr('name', 'disc_valor['+i+']');
        $('#disc_valor', $clone).maskMoney({thousands:'', decimal:'.', allowZero:true});
      $('.3397', $clone).attr('id', 'linha'+i);
      $clone.appendTo('#mais');
      $
    }
    function remove() {
      $('#linha'+i).remove();
      i = i - 1;
    }
</script>
<script id="ToClone" type="text/template">
<div>
  <div class=" 3397" id="discRow">
    <hr>
    <div class="form-group">
      <label for="text">Titulo</label>
      <input type="numeric" class="form-control" id="disc_text" name="disc_text[0]" placeholder="Titulo da discriminação">
    </div>
    <div class="form-group">
      <label for="text">Valor</label>
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">R$</span>
        <input type="text" class="form-control real-mask" name="disc_valor[0]" id="disc_valor" placeholder="valor da discriminação" onchange="totalValor(this.value)">
      </div>
    </div>
  </div>
</div>
</script>
