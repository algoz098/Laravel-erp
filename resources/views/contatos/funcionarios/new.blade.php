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
          @if (isset($contato->funcionario))
            <input type="text" class="form-control" value="{{ $contato->funcionario->cargo or "" }}" name="cargo" id="cargo">
          @else
            <input type="text" class="form-control" name="cargo" id="cargo">
          @endif
        </div>
        <div class="form-group">
          <label for="uf">Data de Admissão</label>
          @if (isset($contato->funcionario))
            <input type="text" class="form-control datepicker" value="{{ $contato->funcionario->data_adm or "" }}" name="data_adm" id="data_adm" placeholder="Data de adm.">
          @else
            <input type="text" class="form-control datepicker" name="data_adm" id="data_adm" placeholder="Data de adm.">

          @endif
        </div>
        <div class="form-group">
          <label for="uf">Data de Demissão</label>
          @if (isset($contato->funcionario))
            <input type="text" class="form-control datepicker" value="{{ $contato->funcionario->data_dem or "" }}" name="data_dem" id="data_dem" placeholder="Data de adm.">
          @else
            <input type="text" class="form-control datepicker" name="data_dem" id="data_dem" placeholder="Data de adm.">

          @endif
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
            @if (isset($contato->funcionario))
              <input type="text" class="form-control real-mask" value="{{ $contato->funcionario->sal or "" }}" name="sal" id="sal" >
            @else
              <input type="text" class="form-control real-mask" name="sal" id="sal" >

            @endif
          </div>
        </div>
        <div class="form-group">
          <label for="uf">Salario real</label>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">R$</span>
            @if (isset($contato->funcionario))
              <input type="text" class="form-control real-mask" value="{{ $contato->funcionario->sal_real or "" }}" name="sal_real" id="sal_real" >
            @else
              <input type="text" class="form-control real-mask" name="sal_real" id="sal_real" >

            @endif
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label for="uf">Vale Transporte</label>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">R$</span>
                @if (isset($contato->funcionario))
                  <input type="text" class="form-control real-mask" value="{{ money_format('%.2n', $contato->funcionario->vt)}}" name="vt" id="vt" disabled>
                @else
                  <input type="text" class="form-control real-mask" name="vt" id="vt" disabled>

                @endif
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="uf">Percentual</label>
              @if (isset($contato->funcionario))
                <div class="input-group">
                  <input type="text" class="form-control integer" value="{{ $contato->funcionario->vt_percentual or "" }}" name="vt_percentual" id="vt_percentual" onchange="calcVT()">
                  <span class="input-group-addon" id="basic-addon1">%</span>
                </div>
              @else
                <div class="input-group">
                  <input type="text" class="form-control integer" name="vt_percentual" id="vt_percentual" onchange="calcVT()">
                  <span class="input-group-addon" id="basic-addon1">%</span>
                </div>
              @endif
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="uf">Vale Alimentação</label>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">R$</span>
            @if (isset($contato->funcionario))
              <input type="text" class="form-control real-mask" value="{{ $contato->funcionario->va or "" }}" name="va" id="va">
            @else
              <input type="text" class="form-control real-mask" name="va" id="va">

            @endif
          </div>
        </div>
        <div class="form-group">
          <label for="uf">Vale Refeição</label>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">R$</span>
            @if (isset($contato->funcionario))
              <input type="text" class="form-control real-mask" value="{{ $contato->funcionario->vr or "" }}" name="vr" id="vr">
            @else
              <input type="text" class="form-control real-mask" name="vr" id="vr">

            @endif
          </div>
        </div>
        <div class="form-group">
          <label for="uf">Periculosidade</label>
          <div class="row">
            <div class="col-md-8">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">R$</span>
                @if (isset($contato->funcionario))
                  <input type="text" class="form-control real-mask" value="{{money_format( '%.2n', $contato->funcionario->inss)}}" name="peri" id="peri" disabled>
                @else
                  <input type="text" class="form-control real-mask" name="peri" id="peri" disabled>

                @endif
              </div>
            </div>
            <div class="col-md-4">
              @if (isset($contato->funcionario))
                <div class="input-group">
                  <input type="text" class="form-control integer" value="{{ $contato->funcionario->peri_percentual or "" }}" name="peri_percentual" id="peri_percentual" onchange="calcPeri()">
                  <span class="input-group-addon" id="basic-addon1">%</span>
                </div>
              @else
                <div class="input-group">
                  <input type="text" class="form-control integer" name="peri_percentual" id="peri_percentual" onchange="calcPeri()">
                  <span class="input-group-addon" id="basic-addon1">%</span>
                </div>
              @endif
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
          @if (isset($contato))
            <input type="text" class="form-control" value="{{ $contato->user->user or "" }}" name="user" id="user3322" >
          @else

            <input type="text" class="form-control" name="user" id="user3322" >
          @endif
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
          @if (isset($contato))
            <input type="text" class="form-control" value="{{ $contato->funcionario->cart_trab_num or "" }}" name="cart_trab_num" id="cart_trab_num">
          @else
            <input type="text" class="form-control" name="cart_trab_num" id="cart_trab_num">

          @endif
        </div>
        <div class="form-group">
          <label for="uf">Serie da Cart. Trabalho</label>
          @if (isset($contato))
            <input type="text" class="form-control" value="{{ $contato->funcionario->cart_trab_serie or "" }}" name="cart_trab_serie" id="cart_trab_serie">
          @else
            <input type="text" class="form-control" name="cart_trab_serie" id="cart_trab_serie">

          @endif
        </div>
        <div class="form-group">
          <label for="uf">Numero do PIS</label>
          @if (isset($contato))
            <input type="text" class="form-control" value="{{ $contato->funcionario->pis or "" }}" name="pis" id="pis">
          @else
            <input type="text" class="form-control" name="pis" id="pis">

          @endif
        </div>
        <div class="form-group">
          <label for="uf">Banco do PIS</label>
          @if (isset($contato))
            <input type="text" class="form-control" value="{{ $contato->funcionario->pis_banco or "" }}" name="pis_banco" id="pis_banco">
          @else
            <input type="text" class="form-control" name="pis_banco" id="pis_banco">

          @endif
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label for="uf">INSS</label>
              @if (isset($contato))
                <input type="text" class="form-control" value="{{money_format( '%.2n', $contato->funcionario->inss)}}" name="inss" id="inss" disabled>
              @else
                <input type="text" class="form-control" name="inss" id="inss" disabled>

              @endif
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="uf">Perc.</label>
              @if (isset($contato))
                <input type="text" class="form-control" value="{{ $contato->funcionario->sal_inss or "" }}" name="sal_inss" id="sal_inss" onchange="calcInss()">
              @else
                <input type="text" class="form-control" name="sal_inss" id="sal_inss" onchange="calcInss()">

              @endif
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
          @if (isset($contato))
            <input type="text" class="form-control" value="{{ $contato->funcionario->cnh or "" }}" name="cnh" id="cnh">
          @else
            <input type="text" class="form-control" name="cnh" id="cnh">

          @endif
        </div>
        <div class="form-group">
          <label for="uf">Categoria da CNH</label>
          @if (isset($contato))
            <input type="text" class="form-control" value="{{ $contato->funcionario->cnh_cat or "" }}" name="cnh_cat" id="cnh_cat">
          @else
            <input type="text" class="form-control" name="cnh_cat" id="cnh_cat">

          @endif
        </div>
        <div class="form-group has-error">
          <label class="control-label" >Vencimento da CNH</label>
          @if (isset($contato))
            <input type="text" class="form-control " value="{{ $contato->funcionario->cnh_venc or "" }}" name="cnh_venc" id="cnh_venc">
          @else
            <input type="text" class="form-control "  name="cnh_venc" id="cnh_venc">

          @endif
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
          @if (isset($contato))
            <input type="text" class="form-control" value="{{ $contato->funcionario->eleitor or "" }}" name="eleitor" id="eleitor">
          @else
            <input type="text" class="form-control" name="eleitor" id="eleitor">

          @endif
        </div>
        <div class="form-group">
          <label for="uf">Sessão de Eleitor</label>
          @if (isset($contato))
            <input type="text" class="form-control" value="{{ $contato->funcionario->eleitor_sessao or "" }}" name="eleitor_sessao" id="eleitor_sessao">
          @else
            <input type="text" class="form-control" name="eleitor_sessao" id="eleitor_sessao">

          @endif
        </div>
        <div class="form-group">
          <label for="uf">Zona de Eleitor</label>
          @if (isset($contato))
            <input type="text" class="form-control" value="{{ $contato->funcionario->eleitor_zona or "" }}" name="eleitor_zona" id="eleitor_zona">
          @else
            <input type="text" class="form-control" name="eleitor_zona" id="eleitor_zona">

          @endif
        </div>
        <div class="form-group">
          <label for="uf">Data de Exp de Eleitor</label>
          @if (isset($contato))
            <input type="text" class="form-control" value="{{ $contato->funcionario->eleitor_exp or "" }}" name="eleitor_exp" id="eleitor_exp">
          @else
            <input type="text" class="form-control" name="eleitor_exp" id="eleitor_exp">

          @endif
        </div>
        <div class="form-group">
          <label for="uf">Numero de Reservista</label>
          @if (isset($contato))
            <input type="text" class="form-control" value="{{ $contato->funcionario->reservista or "" }}" name="reservista" id="reservista">
          @else
            <input type="text" class="form-control" name="reservista" id="reservista">

          @endif
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
          @if (isset($contato))
            <input type="text" class="form-control rg" value="{{ $contato->rg or "" }}" id="rg2" disabled>
          @else

            <input type="text" class="form-control rg" id="rg2" disabled>
          @endif
        </div>
        <div class="form-group">
          <label for="uf">Data de Exp. do RG</label>
          @if (isset($contato))
            <input type="text" class="form-control datepicker" value="{{ $contato->funcionario->rg_exp or "" }}" name="rg_exp" id="rg_exp">
          @else
            <input type="text" class="form-control datepicker"  name="rg_exp" id="rg_exp">

          @endif
        </div>
        <div class="form-group">
          <label for="uf">Nome da Mãe</label>
          @if (isset($contato))
            <input type="text" class="form-control" value="{{ $contato->funcionario->rg_mae or "" }}" name="rg_mae" id="rg_mae">
          @else
            <input type="text" class="form-control" name="rg_mae" id="rg_mae">

          @endif
        </div>
        <div class="form-group">
          <label for="uf">Nome do Pai</label>
          @if (isset($contato))
            <input type="text" class="form-control" value="{{ $contato->funcionario->rg_pai or "" }}" name="rg_pai" id="rg_pai">
          @else
            <input type="text" class="form-control"  name="rg_pai" id="rg_pai">

          @endif
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
  var a = (parseFloat($('#sal_real').val())*(parseFloat($('#vt_percentual').val()))/100);
  $('#vt').val(Math.round(a*100)/100);
}
function calcInss() {
  var a = (parseFloat($('#sal_real').val())*parseFloat($('#sal_inss').val()))/100;
  $('#inss').val(Math.round(a*100)/100);
}
function calcPeri() {
  var a = (parseFloat($('#sal_real').val())*parseFloat($('#peri_percentual').val()))/100;
  $('#peri').val(Math.round(a*100)/100);
}
$('#cnh_venc').mask('99-99-9999')
$('#eleitor_exp').mask('99-99-9999')

</script>
