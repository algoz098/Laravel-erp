<hr>
<input type="hidden" class="form-control" value="1" name="is_funcionario" id="is_funcionario">
<div class="row">
  <div class="col-md-12">
    <h2>Informações do funcionario</h2>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">Informações Basicas</div>
      <div class="panel-body">
        @if (!isset($contato->funcionario))
          @selecionaFilial
        @else
          @selecionaFilial($contato->user->trabalho_id*$contato->user->trabalho->nome)
        @endif
        <div class="form-group">
          <label for="uf">Cargo</label>
          <input type="text" class="form-control" value="{{ $contato->funcionario->cargo or "" }}" name="cargo" id="cargo">
        </div>
        <div class="form-group">
          <label for="uf">Data de Admissão</label>
          <input type="text" class="form-control datepicker" value="{{ $contato->funcionario->data_adm or "" }}" name="data_adm" id="data_adm" placeholder="Data de adm.">
        </div>
        <div class="form-group">
          <label for="uf">Data de Demissão</label>
          <input type="text" class="form-control datepicker" value="{{ $contato->funcionario->data_dem or "" }}" name="data_dem" id="data_dem" placeholder="Data de adm.">
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">Pagamentos e Salario</div>
      <div class="panel-body">
        <div class="form-group">
          <label for="uf">Salario base</label>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">R$</span>
            <input type="text" class="form-control real-mask" value="{{ $contato->funcionario->sal or "" }}" name="sal" id="sal" >
          </div>
        </div>
        <div class="form-group">
          <label for="uf">Salario real</label>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">R$</span>
            <input type="text" class="form-control real-mask" value="{{ $contato->funcionario->sal_real or "" }}" name="sal_real" id="sal" >
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label for="uf">Vale Transporte</label>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">R$</span>
                <input type="text" class="form-control real-mask" value="{{ number_format($contato->funcionario->vt, 2) or "" }}" name="vt" id="vt" disabled>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="uf">Percentual</label>
              <div class="input-group">
                <input type="text" class="form-control integer" value="{{ $contato->funcionario->vt_percentual or "" }}" name="vt_percentual" id="vt_percentual" onchange="calcVT()">
                <span class="input-group-addon" id="basic-addon1">%</span>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="uf">Vale Alimentação</label>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">R$</span>
            <input type="text" class="form-control real-mask" value="{{ $contato->funcionario->va or "" }}" name="va" id="va">
          </div>
        </div>
        <div class="form-group">
          <label for="uf">Vale Refeição</label>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">R$</span>
            <input type="text" class="form-control real-mask" value="{{ $contato->funcionario->vr or "" }}" name="vr" id="vr">
          </div>
        </div>
        <div class="form-group">
          <label for="uf">Periculosidade</label>
          <div class="row">
            <div class="col-md-8">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">R$</span>
                <input type="text" class="form-control real-mask" value="{{ number_format($contato->funcionario->peri, 2) or "" }}" name="peri" id="peri" disabled>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group">
                <input type="text" class="form-control integer" value="{{ $contato->funcionario->peri_percentual or "" }}" name="peri_percentual" id="peri_percentual" onchange="calcPeri()">
                <span class="input-group-addon" id="basic-addon1">%</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">Acesso ao sistema</div>
      <div class="panel-body">
        <div class="form-group">
          <label for="uf">Habilitar acesso</label>
          <select class="form-control" id="ativo" name="ativo">
            @if (isset($contato))
              @if ($contato->user->ativo=="1")
                <option value="1" selected>Habilitar acesso</option>
                <option value="0">Remover acesso</option>
              @else
                <option value="1">Habilitar acesso</option>
                <option value="0" selected>Remover acesso</option>
              @endif
            @else
              <option value="1" selected>Habilitar acesso</option>
              <option value="0">Remover acesso</option>
            @endif
          </select>
        </div>
        <div class="form-group">
          <label for="uf">Usuario</label>
          <input type="text" class="form-control" value="{{ $contato->user->user or "" }}" name="user" id="user3322" >
        </div>
        <div class="form-group">
          <label for="uf">Senha</label>
          <input type="password" class="form-control" value="" name="password" id="password3322" >
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">Dados do Trabalhador</div>
      <div class="panel-body">
        <div class="form-group">
          <label for="uf">Numero da Cart. Trabalho</label>
          <input type="text" class="form-control" value="{{ $contato->funcionario->cart_trab_num or "" }}" name="cart_trab_num" id="cart_trab_num">
        </div>
        <div class="form-group">
          <label for="uf">Serie da Cart. Trabalho</label>
          <input type="text" class="form-control" value="{{ $contato->funcionario->cart_trab_serie or "" }}" name="cart_trab_serie" id="cart_trab_serie">
        </div>
        <div class="form-group">
          <label for="uf">Numero do PIS</label>
          <input type="text" class="form-control" value="{{ $contato->funcionario->pis or "" }}" name="pis" id="pis">
        </div>
        <div class="form-group">
          <label for="uf">Banco do PIS</label>
          <input type="text" class="form-control" value="{{ $contato->funcionario->pis_banco or "" }}" name="pis_banco" id="pis_banco">
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label for="uf">INSS</label>
              <input type="text" class="form-control" value="{{ number_format($contato->funcionario->inss, 2) or "" }}" name="inss" id="inss" disabled>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="uf">Perc.</label>
              <input type="text" class="form-control" value="{{ $contato->funcionario->sal_inss or "" }}" name="sal_inss" id="sal_inss" onchange="calcInss()">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">Referente a CNH</div>
      <div class="panel-body">
        <div class="form-group">
          <label for="uf">Numero da CNH</label>
          <input type="text" class="form-control" value="{{ $contato->funcionario->cnh or "" }}" name="cnh" id="cnh">
        </div>
        <div class="form-group">
          <label for="uf">Categoria da CNH</label>
          <input type="text" class="form-control" value="{{ $contato->funcionario->cnh_cat or "" }}" name="cnh_cat" id="cnh_cat">
        </div>
        <div class="form-group has-error">
          <label class="control-label" >Vencimento da CNH</label>
          <input type="text" class="form-control " value="{{ $contato->funcionario->cnh_venc or "" }}" name="cnh_venc" id="cnh_venc">
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">Referente ao Cidadão</div>
      <div class="panel-body">
        <div class="form-group">
          <label for="uf">Numero de Eleitor</label>
          <input type="text" class="form-control" value="{{ $contato->funcionario->eleitor or "" }}" name="eleitor" id="eleitor">
        </div>
        <div class="form-group">
          <label for="uf">Sessão de Eleitor</label>
          <input type="text" class="form-control" value="{{ $contato->funcionario->eleitor_sessao or "" }}" name="eleitor_sessao" id="eleitor_sessao">
        </div>
        <div class="form-group">
          <label for="uf">Zona de Eleitor</label>
          <input type="text" class="form-control" value="{{ $contato->funcionario->eleitor_zona or "" }}" name="eleitor_zona" id="eleitor_zona">
        </div>
        <div class="form-group">
          <label for="uf">Data de Exp de Eleitor</label>
          <input type="text" class="form-control" value="{{ $contato->funcionario->eleitor_exp or "" }}" name="eleitor_exp" id="eleitor_exp">
        </div>
        <div class="form-group">
          <label for="uf">Numero de Reservista</label>
          <input type="text" class="form-control" value="{{ $contato->funcionario->reservista or "" }}" name="reservista" id="reservista">
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">Referente ao RG</div>
      <div class="panel-body">
        <div class="form-group">
          <label for="uf">RG</label>
          <input type="text" class="form-control rg" value="{{ $contato->rg or "" }}" id="rg2" disabled>
        </div>
        <div class="form-group">
          <label for="uf">Data de Exp. do RG</label>
          <input type="text" class="form-control datepicker" value="{{ $contato->funcionario->rg_exp or "" }}" name="rg_exp" id="rg_exp">
        </div>
        <div class="form-group">
          <label for="uf">Nome da Mãe</label>
          <input type="text" class="form-control" value="{{ $contato->funcionario->rg_mae or "" }}" name="rg_mae" id="rg_mae">
        </div>
        <div class="form-group">
          <label for="uf">Nome do Pai</label>
          <input type="text" class="form-control" value="{{ $contato->funcionario->rg_pai or "" }}" name="rg_pai" id="rg_pai">
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  $("#rg").on("keyup paste", function() {
    $("#rg2").val($(this).val());
  });
});
function calcVT() {
  var a = (parseFloat($('#sal_real').val())*parseFloat($('#vt_percentual').val()))/100;
  $('#vt').val(a);
}
function calcInss() {
  var a = (parseFloat($('#sal_real').val())*parseFloat($('#sal_inss').val()))/100;
  $('#inss').val(a);
}
function calcPeri() {
  var a = (parseFloat($('#sal_real').val())*parseFloat($('#peri_percentual').val()))/100;
  $('#peri').val(a);
}
$('#cnh_venc').mask('99-99-9999')
$('#eleitor_exp').mask('99-99-9999')

</script>
