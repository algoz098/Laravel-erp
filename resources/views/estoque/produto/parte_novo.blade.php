{{ csrf_field() }}
<div class="row">
  <div class="col-md-2 pull-right">
    <div class="form-group">
      <label for="">Ativo?</label>
      <select class="form-control" id="estado" name="estado">
        <option value="1" selected>Sim</option>
        <option value="0">Não</option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    @if(isset($produto))
     @campoTexto(Codigo*nome*$produto->nome)
     @selecionaProdutoGrupo($produto->tipos->id*$produto->tipos->grupo->nome." -> ".$produto->tipos->nome)
     @selecionaContato(Seleciona Fabricante*$produto->fabricante->id*$produto->fabricante->nome)
   @else
     @campoTexto(Codigo*nome*)
     @selecionaProdutoGrupo
     @selecionaContato(Seleciona Fabricante)
   @endif
  </div>
</div>
<div class="row">
  <div class="col-md-9">
    <div class="form-group">
      <label for="barras">Codigo de barras</label>
      <div class="input-group">
        @if(isset($produto))
          <input type="text" class="form-control" id="barras" name="barras" value="{{$produto->barras}}">
        @else
          <input type="text" class="form-control" id="barras" name="barras">
        @endif
        <span class="input-group-btn">
          <button class="btn btn-info" type="button" data-toggle="tooltip" title="Gerar codigo" onclick="gerarBarras()"><i class="fa fa-gear"></i></button>
        </span>
      </div>
    </div>
    @if(isset($produto))
       @campoTexto(Aplicação*aplicacao*$produto->aplicacao)
     @else
       @campoTexto(Aplicação*aplicacao*)
     @endif
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    @if(isset($produto))
       @if ($produto->armazenagens!="[]")
         @foreach ($produto->armazenagens as $key => $armazenagem)
           @if ($armazenagem->pivot->filiais_id==Auth::user()->trabalho_id)
             @campoTexto(Local armazenagem*armazenagem*$armazenagem->pivot->local)
           @else
             @campoTexto(Local armazenagem*armazenagem*)
           @endif
         @endforeach
       @else
         @campoTexto(Local armazenagem*armazenagem*)
       @endif
     @else
       @campoTexto(Local armazenagem*armazenagem*)
     @endif
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="unidade">Embalagem:</label>
          <select class="form-control" id="embalagem" name="embalagem">
            @if(isset($produto))
              <option value="{{$produto->embalagem}}" selected>{{$produto->embalagem}} (atual)</option>
            @else
              <option selected>- Escolha -</option>
            @endif
            @foreach ($embalagens as $key => $embalagem)
              <option value="{{$embalagem->text}}">{{$embalagem->value}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-md-3">
        @if(isset($produto))
          @campoTexto(Peso*peso*$produto->peso)
        @else
          @campoTexto(Peso*peso*)
        @endif
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="unidade">Unidade de medida:</label>
          <select class="form-control" id="unidade" name="unidade">
            @if(isset($produto))
              <option value="{{$produto->unidade}}" selected>{{$produto->unidade}} (atual)</option>
            @else
              <option selected>- Escolha -</option>
            @endif
            @foreach ($medidas as $key => $medida)
              <option value="{{$medida->text}}">{{$medida->value}}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-body">
    <div class="row">
      <div class="col-md-3">
        @if(isset($produto))
          @campoDinheiro(Valor de custo*custo*$produto->custo)
        @else
          @campoDinheiro(Valor de custo*custo*)
        @endif
      </div>
      <div class="col-md-3">
        @if(isset($produto))
          <div class="form-group">
            <label for="">Margem</label>
            <div class="input-group">
              <input type="text" class="form-control moneymask" value="{{$produto->margem}}" name="margem" id="margem" onchange="calculaVenda()">
              <span class="input-group-addon">%</span>
            </div>
          </div>
        @else
          <div class="form-group">
            <label for="">Margem</label>
            <div class="input-group">
              <input type="text" class="form-control moneymask" name="margem" id="margem" onchange="calculaVenda()">
              <span class="input-group-addon">%</span>
            </div>
          </div>
        @endif
      </div>
      <div class="col-md-3">
        @if(isset($produto))
          @campoDinheiro(Valor de venda*venda*$produto->custo)
        @else
          @campoDinheiro(Valor de venda*venda*)
        @endif
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-body">
        @if(isset($produto))
          @campoTexto(Estoque minimo*minimo*$produto->qtd_minima)
          @campoTexto(Estoque maximo*maximo*$produto->qtd_maxima)
        @else
          @campoTexto(Estoque minimo*minimo*)
          @campoTexto(Estoque maximo*maximo*)
        @endif
      </div>
    </div>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Semelhantes internos</h3>
  </div>
  <div class="panel-body" id="semelhantesHolderLinhas">
    <div class="row">
      <div class="col-md-2 pull-right">
        <a class="btn btn-danger" onclick="removeSemelhante()">
          <i class="fa fa-minus"></i>
        </a>
        <a class="btn btn-success" onclick="addSemelhante()">
          <i class="fa fa-plus"></i>
        </a>
      </div>
      <div class="col-md-9">
        <div id="maisSemelhante" class="colocar-rolagem">
          @if (isset($produto->semelhantes_to))
            @foreach ($produto->semelhantes_to as $key => $semelhante)
              <div class="3397 col-md-10" id="semelhante{{$semelhante->id}}">
                <div class="form-group">
                  <label for="por">Semelhante a:</label>
                  <div class="input-group">
                    <input type="hidden" class="form-control" id="semelhantes{{$semelhante->id}}Hidden" name="semelhante_id_to[{{$key}}]" value="{{$semelhante->id}}">
                    <input type="text" class="form-control" id="semelhantes{{$semelhante->id}}" disabled value="{{$semelhante->nome}}">
                    <a onclick="window.activeTarget='semelhantes{{$semelhante->id}}', openModal('{{URL('lista/produtos/selecionar')}}')" class="input-group-addon btn btn-info"><i class="fa fa-gear"></i></a>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
          @if (isset($produto->semelhantes_from))
            @foreach ($produto->semelhantes_from as $key => $semelhante)
              <div class="3397 col-md-10" id="semelhante{{$semelhante->id}}">
                <div class="form-group">
                  <label for="por">Semelhante a:</label>
                  <div class="input-group">
                    <input type="hidden" class="form-control" id="semelhantes{{$semelhante->id}}Hidden" name="semelhante_id_from[{{$key}}]" value="{{$semelhante->id}}">
                    <input type="text" class="form-control" id="semelhantes{{$semelhante->id}}" disabled value="{{$semelhante->nome}}">
                    <a onclick="window.activeTarget='semelhantes{{$semelhante->id}}', openModal('{{URL('lista/produtos/selecionar')}}')" class="input-group-addon btn btn-info"><i class="fa fa-gear"></i></a>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Semelhantes externos</h3>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-2 pull-right">
        <a class="btn btn-danger" onclick="removeExterno()">
          <i class="fa fa-minus"></i>
        </a>
        <a class="btn btn-success" onclick="addExterno()">
          <i class="fa fa-plus"></i>
        </a>
      </div>
      <div class="col-md-10">
        <div id="maisExterno">
          @if (isset($produto))
            @foreach ($produto->externos as $key => $externo)
              <div class="panel panel-default" id="externo_edit{{$externo->id}}">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-1 text-center">
                      <label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                      <a onclick="apagaExterno({{$externo->id}})" class="btn btn-danger btn-xs">
                        <i class="fa fa-ban"></i>
                      </a>
                    </div>
                    <div class="col-md-3">
                      @campoTexto(Codigo*codigo_edit[$externo->id]*$externo->codigo)
                    </div>
                    <div class="col-md-4">
                      @campoTexto(Nome*nome_edit[$externo->id]*$externo->nome)
                    </div>
                    <div class="col-md-4">
                      @campoTexto(Origem*origem_edit[$externo->id]*$externo->origem)
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Campos Extras</h3>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-2 pull-right text-right">
        <div>
          <a class="btn btn-danger" onclick="remove()">
            <i class="fa fa-minus"></i>
          </a>
          <a class="btn btn-success" onclick="add()">
            <i class="fa fa-plus"></i>
          </a>
        </div>
      </div>
      <div id="mais" class="colocar-rolagem">
        @if (isset($produto))
          @foreach ($produto->campos as $key => $campo)
            <div class="col-md-9" id="campo{{$campo->id}}">
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="col-md-1">
                    <label>&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                    <a onclick="apagaCampoExtra({{$campo->id}})" class="btn btn-danger btn-xs">
                      <i class="fa fa-ban"></i>
                    </a>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Nome do campo</label>
                      <input type="hidden" class="form-control" name="campo_id_edit[{{$key}}]" id="campo_nome_edit" value="{{$campo->id}}">
                      <input type="text" class="form-control" name="campo_nome_edit[{{$key}}]" id="campo_nome_edit" value="{{$campo->nome}}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Valor do campo</label>
                      <input type="text" class="form-control" name="campo_valor_edit[{{$key}}]" id="campo_valor_edit" value="{{$campo->valor}}" onchange="calculaVenda()">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </div>
  </div>
</div>

  <script id="ToClone" type="text/template">
  <span>
    <div class="3397 col-md-12" id="a">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="col-md-3">
            <div class="form-group">
              <label for="text" id="numeroText">Nome do campo</label>
              <input type="text" class="form-control" value="" name="campo_nome" id="campo_nome">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="text">Valor do campo</label>
              <input type="text" class="form-control" value="" name="campo_valor" id="campo_valor">
            </div>
          </div>
        </div>
      </div>
    </div>
  </span>
  </script>
<script>
$(document).ready(function(){
    if (($("#modal").data('bs.modal') || {}).isShown) {
      $("#semelhantesHolderLinhas").html("<p>DESABILITADO EM MODAL</P>");
    }
})

function calculaVenda(){
  var custo = parseFloat($('#custo').val());
  var margem = parseFloat($('#margem').val());
  $('#venda').val(custo+custo*(margem/100));
}
  $('#custo').maskMoney({thousands:'', decimal:'.', allowZero:true});

  function gerarBarras(){
    var url = "{{url('novo/produto/barras')}}";
    $('#barras').prop('disabled', true);
    $.ajax({
      type: 'GET',
      url: url,
      data: { get_param: 'value' },
      dataType: 'json',
      success: function( data ) {
        $("#barras").val(data);
      },
      complete: function () {
        $('#barras').prop('disabled', false);
      }
    });
  }

  $(document).ready(function(){
    window.e = 0;
    window.eSemelhante = 0;
    window.eExterno = 0;
  });
  function apagaCampoExtra(id){
    a = "{{url('/lista/produtos')}}/campos/"+id+"/delete"
    $.get( a, function( data ) {
      $( "#campo"+id ).remove();
    });
  }
  function add() {
    var $clone = $($('#ToClone').html());
    $('#campo_nome', $clone).attr('name', 'campo_nome['+e+']');
    $('#campo_valor', $clone).attr('name', 'campo_valor['+e+']');
    $('#campo_nome', $clone).attr('id', 'campo_nome'+e);
    $('#campo_valor', $clone).attr('id', 'campo_valor'+e);
    $('.3397', $clone).attr('id', 'linha'+e);
    e = e + 1;
    $clone.appendTo('#mais');
  }
  function remove() {
    if (e<0){}else {
      $('#linha'+e).remove();
      if(e>0){
        e = e - 1;
      }
    }
  }

  function addSemelhante() {
    var $clone = $($('#ToCloneSemelhante').html());
    $('#semelhantesHidden', $clone).attr('name', 'semelhante_id['+eSemelhante+']');
    $('#semelhantes', $clone).attr('id', 'semelhantes'+eSemelhante);
    $('#semelhantesHidden', $clone).attr('name', 'semelhante_id['+eSemelhante+']');
    $('#aSemelhantes', $clone).attr('onclick', 'window.activeTarget="semelhantes'+eSemelhante+'", openModal("{{URL('lista/produtos/selecionar')}}")');
    $('#semelhantesHidden', $clone).attr('id', 'semelhantes'+eSemelhante+'Hidden');
    $('.3397', $clone).attr('id', 'linhaSemelhante'+eSemelhante);
    eSemelhante = eSemelhante + 1;
    $clone.appendTo('#maisSemelhante');
  }
  function removeSemelhante() {
    if (eSemelhante<0){}else {
      $('#linhaSemelhante'+eSemelhante).remove();
      if(eSemelhante>0){
        eSemelhante = eSemelhante - 1;
      }
    }
  }
  function addExterno() {
    var $clone = $($('#toCloneExterno').html());
    $('#codigoExterno', $clone).attr('name', 'codigoExterno['+eExterno+']');
    $('#nomeExterno', $clone).attr('name', 'nomeExterno['+eExterno+']');
    $('#origemExterno', $clone).attr('name', 'origemExterno['+eExterno+']');
    $('#codigoExterno', $clone).attr('id', 'codigoExterno'+eExterno);
    $('#nomeExterno', $clone).attr('id', 'nomeExterno'+eExterno);
    $('#origemExterno', $clone).attr('id', 'origemExterno'+eExterno);
    $('.3397', $clone).attr('id', 'linhaExterno'+eExterno);
    eExterno = eExterno + 1;
    $clone.appendTo('#maisExterno');
  }
  function removeExterno() {
    if (eExterno<0){}else {
      $('#linhaExterno'+eExterno).remove();
      if(eExterno>0){
        eExterno = eExterno - 1;
      }
    }
  }
  function apagaExterno(id){
    a = "{{url('/lista/produtos')}}/externos/"+id+"/delete"
    $.get( a, function( data ) {
      $( "#externo_edit"+id ).remove();
    });
  }
</script>
<script id="ToClone" type="text/template">
<span>
  <div class="3397 col-md-9" id="a">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="col-md-3">
          <div class="form-group">
            <label for="text" id="numeroText">Nome do campo</label>
            <input type="text" class="form-control" value="" name="campo_nome" id="campo_nome">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="text">Valor do campo</label>
            <input type="text" class="form-control" value="" name="campo_valor" id="campo_valor">
          </div>
        </div>
      </div>
    </div>
  </div>
</span>
</script>
<script id="ToCloneSemelhante" type="text/template">
  <span>
    <div class="3397 col-md-10" id="a">
      <div class="form-group">
        <label for="por">Semelhante a:</label>
        <div class="input-group">
          <input type="hidden" class="form-control" id="semelhantesHidden" name="semelhante_id">
          <input type="text" class="form-control" id="semelhantes" disabled>
          <a id="aSemelhantes" onclick="" class="input-group-addon btn btn-info"><i class="fa fa-gear"></i></a>
        </div>
      </div>
    </div>
  </span>
</script>
<script id="toCloneExterno" type="text/template">
  <span>
    <div class="panel panel-default 3397" id="externo_edit">
    <div class="panel-body">
      <div class="row">
        <div class="col-md-4">
          @campoTexto(Codigo*codigoExterno*)
        </div>
        <div class="col-md-4">
          @campoTexto(Nome*nomeExterno*)
        </div>
        <div class="col-md-4">
          @campoTexto(Origem*origemExterno*)
        </div>
      </div>
    </div>
  </div>
  </span>
</script>
