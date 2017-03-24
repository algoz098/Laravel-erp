<?php
use Carbon\Carbon;
?>
@extends('main')
@section('content')
  @if (isset($nf))
    <form method="POST" action="{{ url('/novo/nf-entrada') }}/{{$nf->id}}">
  @else
    <form method="POST" action="{{ url('/novo/nf-entrada') }}">
  @endif
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading ">
            <i class="fa fa-bell-o fa-1x"></i> Adicionar nota fiscal de entrada
          </div>
          <div class="panel-body">
            <div class="row" id="secondNavbar">
              <div class="col-md-3 text-right pull-right">
                @botaoLista(estoques*fa-bell-o)
                @botaoSalvar
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                    @if (isset($estoque))
                      @selecionaFilial($estoque->contato->id*$estoque->contato->nome)
                    @else
                      @selecionaFilial
                      @campoTexto(Numero da nota:*numero_nota*)
                      @selecionaContato(Fornecedor:)
                      @campoDinheiro(Total da nota:*total_nota*)
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="panel panel-default" style="font-size: 10px;">
                <div class="panel-body">
                  <div class="col-md-1 pull-right">
                    <div>
                      <a class="btn btn-danger" onclick="remove()">
                        <i class="fa fa-minus"></i>
                      </a>
                      <a class="btn btn-success" onclick="add()">
                        <i class="fa fa-plus"></i>
                      </a>
                    </div>
                  </div>
                  <div class="col-md-11">
                    <div class="row" >
                      <div class="col-md-2" >
                        <strong>Codigo</strong>
                      </div>
                      <div class="col-md-2">
                        <strong>NCM Nota</strong>
                      </div>
                      <div class="col-md-1">
                        <strong>Quantidade</strong>
                      </div>
                      <div class="col-md-1">
                        <strong>Valor Unid.</strong>
                      </div>
                      <div class="col-md-1">
                        <strong>ICMS</strong>
                      </div>
                      <div class="col-md-1">
                        <strong>IPI</strong>
                      </div>
                      <div class="col-md-1">
                        <strong>Total</strong>
                      </div>
                      <div class="col-md-1">
                        <strong>Vlr ICMS</strong>
                      </div>
                      <div class="col-md-1">
                        <strong>Vlr IPI</strong>
                      </div>
                    </div>
                    <div id="mais"></div>
                  </div>
                  <div class="col-md-11">
                    <div class="row">
                      <div class="col-md-1 pull-right"></div>
                      <div class="col-md-1 pull-right">
                        <div class="form-group">
                          <label>IPI Total:</label>
                          <input type="text" class="form-control input-sm" id="ipiTotal" name="ipiTotal" readonly>
                        </div>
                      </div>
                      <div class="col-md-1 pull-right">
                        <div class="form-group">
                          <label>ICMS Total:</label>
                          <input type="text" class="form-control input-sm" id="icmsTotal" name="icmsTotal" readonly>
                        </div>
                      </div>
                      <div class="col-md-1 pull-right">
                        <div class="form-group">
                          <label>Total:</label>
                          <input type="text" class="form-control input-sm" id="total" name="total" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="col-md-2">
                  @campoDinheiro(Frete da nota*frete_nota*)
                </div>
                <div class="col-md-2">
                  @campoDinheiro(Transportadora*transportadora*)
                </div>
                <div class="col-md-2">
                  @campoDinheiro(Seguro/Dep.*seguro*)
                </div>
                <div class="col-md-2">
                  @campoDinheiro(ICMS Substituição*icms_substituicao*)
                </div>
                <div class="col-md-2">
                  @campoDinheiro(Acrescimo*acrescimo*)
                </div>
                <div class="col-md-2">
                  @campoDinheiro(Desconto*desconto*)
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
<script>
<?php $retornarEstaLocal = 1; ?>
function retornarEsta(id, nome, tipo, barras, ncm) {
  window.contatos_id = id;
  window.contatos_nome = nome;
  $('#codigoBarrasHolder').text(barras);
  $('#subgrupoHolder').text(tipo);
  $('#ncmCadastradoHolder').text(ncm);
  $('#modal').modal('toggle');
}
function calcularLinha(linha){
  qtd = parseFloat($('#qtdNota'+linha).val());
  valor = parseFloat($('#valorUniNota'+linha).val());
  icms = parseFloat($('#IcmsUniNota'+linha).val());
  ipi = parseFloat($('#IpiUniNota'+linha).val());

  $('#valorTotalNota'+linha).val(qtd*valor);

  total = parseFloat($('#valorTotalNota'+linha).val());
  $('#IcmsTotalNota'+linha).val(total*(icms/100));
  $('#IpiTotalNota'+linha).val(total*(ipi/100));

  var esteContador = 0;
  var total = 0;
  var icms = 0;
  var ipi = 0;
  while (esteContador < window.e){
    var total = total+parseFloat($('#valorTotalNota'+esteContador).val());
    var icms = icms+parseFloat($('#IcmsTotalNota'+esteContador).val());
    var ipi = ipi+parseFloat($('#IpiTotalNota'+esteContador).val());
    esteContador = esteContador+1;
  }
  $('#total').val(total);
  $('#ipiTotal').val(ipi);
  $('#icmsTotal').val(icms);
};
window.e = 0;
function add() {
  var $clone = $($('#toCloneProduto').html());
  $('#nota_produtoHidden', $clone).attr('name', 'nota_produto_id['+e+']');
  $('#nota_produtoHidden', $clone).attr('id', 'nota_produto'+e+'Hidden');
  $('#nota_produto', $clone).attr('id', 'nota_produto'+e);
  $('#nota_produtoBotao', $clone).attr('onclick', 'window.activeTarget=\'nota_produto'+e+'\'; openModal(\'{{url('lista/produtos/selecionar')}}\')');
  $('#ncmNota', $clone).attr('name', 'ncmNota['+e+']');
  $('#qtdNota', $clone).attr('name', 'qtdNota['+e+']');
  $('#qtdNota', $clone).attr('onchange', 'calcularLinha('+e+')');
  $('#qtdNota', $clone).attr('id', 'qtdNota'+e);
  $('#valorUniNota', $clone).attr('name', 'valorUniNota['+e+']');
  $('#valorUniNota', $clone).attr('onchange', 'calcularLinha('+e+')');
  $('#valorUniNota', $clone).attr('id', 'valorUniNota'+e);
  $('#IcmsUniNota', $clone).attr('name', 'IcmsUniNota['+e+']');
  $('#IcmsUniNota', $clone).attr('onchange', 'calcularLinha('+e+')');
  $('#IcmsUniNota', $clone).attr('id', 'IcmsUniNota'+e);
  $('#IpiUniNota', $clone).attr('name', 'IpiUniNota['+e+']');
  $('#IpiUniNota', $clone).attr('onchange', 'calcularLinha('+e+')');
  $('#IpiUniNota', $clone).attr('id', 'IpiUniNota'+e);
  $('#valorTotalNota', $clone).attr('name', 'valorTotalNota['+e+']');
  $('#valorTotalNota', $clone).attr('onchange', 'calcularLinha('+e+')');
  $('#valorTotalNota', $clone).attr('id', 'valorTotalNota'+e);
  $('#IcmsTotalNota', $clone).attr('name', 'IcmsTotalNota['+e+']');
  $('#IcmsTotalNota', $clone).attr('onchange', 'calcularLinha('+e+')');
  $('#IcmsTotalNota', $clone).attr('id', 'IcmsTotalNota'+e);
  $('#IpiTotalNota', $clone).attr('name', 'IpiTotalNota['+e+']');
  $('#IpiTotalNota', $clone).attr('onchange', 'calcularLinha('+e+')');
  $('#IpiTotalNota', $clone).attr('id', 'IpiTotalNota'+e);
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
<script type="text/template" id="toCloneProduto">
  <div>
    <div class="row list-contacts 3397">
    <div class="col-md-2">
      <div class="form-group">
        <div class="input-group">
          <input type="hidden" class="form-control" id="nota_produtoHidden" name="nota_produto_id">
          <input type="text" class="form-control input-sm" id="nota_produto" disabled>
          <span id ="nota_produtoBotao" onclick="window.activeTarget='nota_produto'; openModal('{{url('lista/produtos/selecionar')}}')" class=" btn btn-info  input-sm input-group-addon">
            <i class="fa fa-gear"></i>
          </span>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <input type="text" class="form-control input-sm" id="ncmNota" name="ncmNota">
    </div>
    <div class="col-md-1">
      <input type="text" class="form-control input-sm maskMoney" id="qtdNota" name="qtdNota" onchange="cacularLinha()">
    </div>
    <div class="col-md-1">
      <input type="text" class="form-control input-sm maskMoney" id="valorUniNota" name="valorUniNota" onchange="cacularLinha()">
    </div>
    <div class="col-md-1">
      <input type="text" class="form-control input-sm maskMoney" id="IcmsUniNota" name="IcmsUniNota" onchange="cacularLinha()">
    </div>
    <div class="col-md-1">
      <input type="text" class="form-control input-sm maskMoney" id="IpiUniNota" name="IpiUniNota" onchange="cacularLinha()">
    </div>
    <div class="col-md-1">
      <input type="text" class="form-control input-sm maskMoney" id="valorTotalNota" name="valorTotalNota" readonly>
    </div>
    <div class="col-md-1">
      <input type="text" class="form-control input-sm maskMoney" id="IcmsTotalNota" name="IcmsTotalNota" readonly>
    </div>
    <div class="col-md-1">
      <input type="text" class="form-control input-sm maskMoney" id="IpiTotalNota" name="IpiTotalNota" readonly>
    </div>
  </div>
  </div>
</script>
@endsection
