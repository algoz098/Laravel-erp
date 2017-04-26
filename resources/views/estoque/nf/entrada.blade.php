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
                @botaoLista(nf-entrada*fa-bell-o)
                @botaoSalvar
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-body">
                    @if (isset($nf))
                      <div class="col-md-3">
                        @selecionaFilial($nf->filial->id*$nf->filial->nome)
                      </div>
                      <div class="col-md-4">
                        @selecionaContato(Fornecedor:*$nf->fornecedor->id*$nf->fornecedor->nome)
                      </div>
                      <div class="col-md-2">
                        @campoTexto(Nro da NF:*numero_nota*$nf->numero)
                      </div>
                      <div class="col-md-2">
                        @campoDinheiro(Total Nota Fiscal:*total_nota*$nf->total)
                      </div>
                    @else
                      <div class="col-md-3">
                        @selecionaFilial
                      </div>
                      <div class="col-md-4">
                        @selecionaContato(Fornecedor:)
                      </div>
                      <div class="col-md-2">
                        @campoTexto(Nro da NF:*numero_nota*)
                      </div>
                      <div class="col-md-2">
                        @campoDinheiro(Total Nota Fiscal:*total_nota*)
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-body">
                @if (isset($nf))
                  <div class="col-md-2">
                    @campoDinheiro(Frete da nota*frete_nota*$nf->frete)
                  </div>
                  <div class="col-md-2">
                    @campoDinheiro(Transportadora*transportadora*$nf->transportadora)
                  </div>
                  <div class="col-md-2">
                    @campoDinheiro(Seguro/Dep.*seguro*$nf->seguro)
                  </div>
                  <div class="col-md-2">
                    @campoDinheiro(ICMS Substituição*icms_substituicao*$nf->icms)
                  </div>
                  <div class="col-md-2">
                    @campoDinheiro(Acrescimo*acrescimo*$nf->acrescimo)
                  </div>
                  <div class="col-md-2">
                    @campoDinheiro(Desconto*desconto*$nf->desconto)
                  </div>
                @else
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
                @endif
              </div>
            </div>
            <div class="row">
              <div class="panel panel-default" style="font-size: 12px;">
                <div class="panel-body">
                  <div class="col-md-1 pull-right">
                    <div>
                      <a class="btn btn-danger" onclick="removeProdutos()">
                        <i class="fa fa-minus"></i>
                      </a>
                      <a class="btn btn-success" onclick="addProdutos()">
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
                        <strong>Tipo</strong>
                      </div>
                      <div class="col-md-1">
                        <strong>Qde</strong>
                      </div>
                      <div class="col-md-1">
                        <strong>Vlr Unit.</strong>
                      </div>
                      <div class="col-md-1">
                        <strong>ICMS</strong>
                      </div>
                      <div class="col-md-1">
                        <strong>IPI</strong>
                      </div>
                      <div class="col-md-1">
                        <strong>Vlr Total</strong>
                      </div>
                      <div class="col-md-1">
                        <strong>Vlr ICMS</strong>
                      </div>
                      <div class="col-md-1">
                        <strong>Vlr IPI</strong>
                      </div>
                    </div>
                    <div id="maisProdutos">
                      @if (isset($nf))
                        @foreach ($nf->nf_produtos as $key => $nfp)
                          <div class="row list-contacts" id="linha{{$key}}">
                          <div class="col-md-2">
                            <div class="form-inline">
                              <strong>
                                <span id="linhaNumeroProduto">{{$key+1}}</span>
                              </strong>
                              <div class="form-group">
                                <div class="input-group">
                                  <input type="hidden" class="form-control" id="nota_produtoHidden" name="nota_produto_id[{{$key}}]" value="{{$nfp->produto->id}}">
                                  <input type="text" class="form-control input-sm" id="nota_produto" value="{{$nfp->produto->nome}}" disabled>
                                  <span id ="nota_produtoBotao" onclick="window.activeTarget='nota_produto'; openModal('{{url('lista/produtos/selecionar')}}')" class=" btn btn-info  input-sm input-group-addon">
                                    <i class="fa fa-gear"></i>
                                  </span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <input type="text" class="form-control input-sm" id="ncmNota" name="ncmNota[{{$key}}]" value="{{$nfp->ncm}}">
                          </div>
                          <div class="col-md-1">
                            <select id="tipoNota" name="tipoNota[{{$key}}]" class="input-sm form-control">
                              <option value="{{$nfp->tipo}}" selected>{{$nfp->tipo}} (atual)</option>
                              <option value="Conjunto">Conj</option>
                              <option value="Fardo">Frd</option>
                              <option value="Jogo">Jg</option>
                              <option value="kilo">Kg</option>
                              <option value="Kit">Kit</option>
                              <option value="Litros">Lts</option>
                              <option value="Peça">Pc</option>
                              <option value="Unidade">Unid</option>
                            </select>
                          </div>
                          <div class="col-md-1">
                            <input type="text" class="form-control input-sm maskMoney" id="qtdNota" name="qtdNota[{{$key}}]" value="{{$nfp->quantidade}}" onchange="cacularLinha({{$key}})">
                          </div>
                          <div class="col-md-1">
                            <input type="text" class="form-control input-sm real-mask" id="valorUniNota" name="valorUniNota[{{$key}}]" value="{{$nfp->valor}}" onchange="cacularLinha({{$key}})">
                          </div>
                          <div class="col-md-1">
                            <input type="text" class="form-control input-sm maskMoney" id="IcmsUniNota" name="IcmsUniNota[{{$key}}]" value="{{$nfp->icms}}" onchange="cacularLinha({{$key}})">
                          </div>
                          <div class="col-md-1">
                            <input type="text" class="form-control input-sm maskMoney" id="IpiUniNota" name="IpiUniNota[{{$key}}]" value="{{$nfp->ipi}}" onchange="cacularLinha({{$key}})">
                          </div>
                          <div class="col-md-1">
                            <input type="text" class="form-control input-sm maskMoney" id="valorTotalNota" name="valorTotalNota[{{$key}}]" value="{{$nfp->total}}" readonly>
                          </div>
                          <div class="col-md-1">
                            <input type="text" class="form-control input-sm maskMoney" id="IcmsTotalNota" name="IcmsTotalNota[{{$key}}]" value="{{$nfp->total_icms}}" readonly>
                          </div>
                          <div class="col-md-1">
                            <input type="text" class="form-control input-sm maskMoney" id="IpiTotalNota" name="IpiTotalNota[{{$key}}]" value="{{$nfp->total_ipi}}" readonly>
                          </div>
                        </div>
                        @endforeach
                      @endif
                    </div>
                  </div>
                  <div class="col-md-11" style="font-size: 11px;">
                    <div class="row">
                      <div class="col-md-1 pull-right">
                        <div class="form-group">
                          <label>TOT IPI</label>
                          <input type="text" class="form-control input-sm" id="ipiTotal" name="ipiTotal" readonly>
                        </div>
                      </div>
                      <div class="col-md-1 pull-right">
                        <div class="form-group">
                          <label>TOT ICMS</label>
                          <input type="text" class="form-control input-sm" id="icmsTotal" name="icmsTotal" readonly>
                        </div>
                      </div>
                      <div class="col-md-1 pull-right">
                        <div class="form-group">
                          <label>TOT PROD</label>
                          <input type="text" class="form-control input-sm" id="total" name="total" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-11">
                      <div class="col-md-3 pull-right">
                        <div class="form-group">
                          <label>TOT Produtos e Impostos</label>
                          <input type="text" class="form-control input-sm" id="totalNotaVerificar" name="totalNotaVerificar" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="form-group">
                    <label for="obs">Observação</label>
                    <textarea id="obsProduto" class="form-control" name="obs">@if (isset($nf)){!!$nf->obs!!}@endif</textarea>
                  </div>
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
$(document).ready(function(){
  // $('button[type="submit"]').addClass('disabled');
  // $('#icms_substituicao').prop('readonly', 'true');
  // $('button[type="submit"]').attr('data-toggle', 'tooltip');
  // $('button[type="submit"]').attr('title', 'Verificar os dados da nota');
  // $('button[type="submit"]').attr('data-placement', 'bottom');
  // $("form").submit(function(e){
  //       e.preventDefault(verificarCamposNf());
  //   });
});
function verificarCamposNf(){
  var totalNota = parseFloat($("#total_nota").val());
  if(typeof totalNota === "undefined"){
    $("#total_nota").parent().parent().addClass('has-error');
  }
  if(totalNota>0){
    $("#total_nota").parent().parent().removeClass('has-error');
  } else {
    $("#total_nota").parent().parent().addClass('has-error');
  }
  var freteNota = parseFloat($("#frete_nota").val());
  var transportadora = parseFloat($("#transportadora").val());
  var icmsSubstituicao = parseFloat($("#icms_substituicao").val());
  var icmsProdutos = parseFloat($("#icmsTotal").val());
  if (icmsSubstituicao != icmsProdutos) {
    $.toaster({ message : 'O total de ICMS e o ICMS dos produtos não bate.', title : 'Cuidado', priority : 'warning' , settings : {'timeout' : 3000,}});
    $("#icms_substituicao").parent().parent().addClass('has-error');
  } else {
    $("#icms_substituicao").parent().parent().removeClass('has-error');
  }
  var acrescimo = parseFloat($("#acrescimo").val());
  var desconto = parseFloat($("#desconto").val());
  var totalProdutos = parseFloat($("#total").val());
  if(window.e <= 0){
    $.toaster({ message : 'A nota precisa de produtos.', title : 'Epa', priority : 'danger' , settings : {'timeout' : 3000,}});
  } else {
    if(typeof totalProdutos === "undefined"){
      $.toaster({ message : 'Não tem total do valor dos produtos.', title : 'Epa', priority : 'danger' , settings : {'timeout' : 3000,}});
    }
    if (totalProdutos<0){
      $.toaster({ message : 'Não tem total do valor dos produtos.', title : 'Epa', priority : 'danger' , settings : {'timeout' : 3000,}});
    }
  }

};
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

  var frete = parseFloat($('#frete_nota').val());
  frete = frete || 0;
  var transportadora = parseFloat($('#transportadora').val());
  transportadora = transportadora || 0;
  var seguro = parseFloat($('#seguro').val());
  seguro = seguro || 0;
  console.log(frete+" "+transportadora+" "+seguro);
  var somatoria = frete+transportadora+custos;
  console.log(somatoria);
  var custos = (frete+transportadora+custos)/window.e;
  console.log(window.e);
  console.log('custos > '+custos);
  custos = custos || 0;
  outroContador = 0
  while (outroContador < window.e){
    $('#valorTotalNota'+outroContador).val(custos+parseFloat($('#valorTotalNota'+outroContador).val()));
    outroContador = outroContador+1;
  }

  $('#total').val(total);
  $('#ipiTotal').val(ipi);
  $('#icmsTotal').val(icms);
  $('#icms_substituicao').val(icms);
  $('#totalNotaVerificar').val(total+ipi+icms);
};
@if (isset($nf))
  window.e = {{$nf->nf_produtos->count()}};
@else
  window.e = 0;
@endif
function addProdutos() {
  var $clone = $($('#toCloneProduto').html());
  $('#linhaNumeroProduto', $clone).text(e+1);
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
  $('#valorUniNota', $clone).maskMoney({thousands:'', decimal:'.', allowZero:true});
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
  $clone.appendTo('#maisProdutos');
}
function removeProdutos() {
  if (e>=0){
    e = e - 1;
    $('#linha'+e).remove();
  }
}
</script>
<script type="text/template" id="toCloneProduto">
  <div>
    <div class="row list-contacts 3397">
    <div class="col-md-2">
      <div class="form-inline">
        <strong>
          <span id="linhaNumeroProduto"></span>
        </strong>
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
    </div>
    <div class="col-md-2">
      <input type="text" class="form-control input-sm" id="ncmNota" name="ncmNota">
    </div>
    <div class="col-md-1">
      <select id="tipoNota" name="tipoNota" class="input-sm form-control">
        <option selected>Escolha</option>
        <option value="Conjunto">Conj</option>
        <option value="Fardo">Frd</option>
        <option value="Jogo">Jg</option>
        <option value="kilo">Kg</option>
        <option value="Kit">Kit</option>
        <option value="Litros">Lts</option>
        <option value="Peça">Pc</option>
        <option value="Unidade">Unid</option>
      </select>
    </div>
    <div class="col-md-1">
      <input type="text" class="form-control input-sm maskMoney" id="qtdNota" name="qtdNota" onchange="cacularLinha()">
    </div>
    <div class="col-md-1">
      <input type="text" class="form-control input-sm real-mask" id="valorUniNota" name="valorUniNota" onchange="cacularLinha()">
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
