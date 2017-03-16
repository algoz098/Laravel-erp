{{ csrf_field() }}
<div>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#basico" aria-controls="basico" role="tab" data-toggle="tab">Basico</a></li>
    <li role="presentation"><a href="#extras" aria-controls="extras" role="tab" data-toggle="tab">Campos Extras</a></li>
    <!-- <li role="presentation"><a href="#descricao" aria-controls="descricao" role="tab" data-toggle="tab">Descrição</a></li>-->
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="basico"><br>
      <div class="row">
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="form-group">
                <label for="barras">Codigo de barras</label>
                <div class="input-group">
                  @if(isset($produto))
                    <input type="text" class="form-control" id="barras" name="barras" value="{{$produto->barras}}">
                  @else
                    <input type="text" class="form-control" id="barras" name="barras">
                  @endif
                 <span class="input-group-btn">
                   <button class="btn btn-info" type="button" onclick="gerarBarras()"><i class="fa fa-gear"></i></button>
                 </span>
               </div>
             </div>
             @if(isset($produto))
                @selecionaProdutoGrupo($produto->tipos->id*$produto->tipos->nome)
                @selecionaContato(Seleciona Fabricante*$produto->fabricante->id*$produto->fabricante->nome)
            @else
              @selecionaProdutoGrupo
              @selecionaContato(Seleciona Fabricante)
            @endif
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-body">
              @if(isset($produto))
                 @campoTexto(Nome do Produto*nome*$produto->nome)
             @else
               @campoTexto(Nome do Produto*nome*)
             @endif
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
          </div>
        </div>
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-body">
              @if(isset($produto))
                @campoDinheiro(Valor de custo*custo*$produto->custo)
                <div class="form-group">
                  <label for="">Margem</label>
                  <div class="input-group">
                    <input type="text" class="form-control moneymask" value="{{$produto->margem}}" name="margem" id="margem" onchange="calculaVenda()">
                    <span class="input-group-addon">%</span>
                  </div>
                </div>
              @else
                @campoDinheiro(Valor de custo*custo*)
                <div class="form-group">
                  <label for="">Margem</label>
                  <div class="input-group">
                    <input type="text" class="form-control moneymask" name="margem" id="margem" onchange="calculaVenda()">
                    <span class="input-group-addon">%</span>
                  </div>
                </div>
              @endif
              @if(isset($produto))
                @campoDinheiro(Valor de venda*venda*$produto->custo)
              @else
                @campoDinheiro(Valor de venda*venda*)
              @endif
            </div>
          </div>
        </div>
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
              <div class="form-group">
                <label for="">Ativo?</label>
                <select class="form-control" id="estado" name="estado">
                  <option value="1" selected>Sim</option>
                  <option value="0">Não</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="extras"><br>
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Campos extras</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-2 pull-right text-right">
                  <div data-spy="affix" data-offset-top="60" data-offset-bottom="200"  style="width: 100px;">
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
        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="descricao"><br>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="descricao">Descricao:</label>
            <textarea name="descricao" id="descricao"></textarea>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>




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
<script>
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
