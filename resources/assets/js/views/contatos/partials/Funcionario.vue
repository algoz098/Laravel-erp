<template>
<div>

  <div class="row">
    <div class="col-12">
      <b-card header="Funcionario">

        <div class="row">
          <div class="col-1">
            <strong>N. CNH:</strong>
          </div>
          <div class="col-3">
            {{contato.funcionario.cnh}}
          </div>
          <div class="col-2">
            <strong>N. Eleitor:</strong>
          </div>
          <div class="col-2">
            {{contato.funcionario.eleitor}}
          </div>
          <div class="col-2">
            <strong>N. do Pis:</strong>
          </div>
          <div class="col-2">
            {{contato.funcionario.pis}}
          </div>
        </div>

        <div class="row">
          <div class="col-1">
            <strong>Cat. CNH:</strong>
          </div>
          <div class="col-3">
            {{contato.funcionario.cnh_cat}}
          </div>
          <div class="col-2">
            <strong>Sessão do Eleitor:</strong>
          </div>
          <div class="col-2">
            {{contato.funcionario.eleitor_sessao}}
          </div>
          <div class="col-2">
            <strong>Banco do Pis:</strong>
          </div>
          <div class="col-2">
            {{contato.funcionario.pis_banco}}
          </div>
        </div>

        <div class="row">
          <div class="col-1">
            <strong>Cart. Trab.</strong>
          </div>
          <div class="col-3">
            {{contato.funcionario.cart_trab_num}}
          </div>
          <div class="col-2">
            <strong>Data de Exp. de Eleitor</strong>
          </div>
          <div class="col-2">
            {{contato.funcionario.eleitor_exp}}
          </div>
          <div class="col-2">
            <strong>N. Reservista</strong>
          </div>
          <div class="col-2">
            {{contato.funcionario.reservista}}
          </div>
        </div>

        <div class="row">
          <div class="col-1">
            <strong>Cart. Trab. Serie</strong>
          </div>
          <div class="col-3">
            {{contato.funcionario.cart_trab_serie}}
          </div>
          <div class="col-2">
            <strong>RG:</strong>
          </div>
          <div class="col-2">
            {{contato.rg}}
          </div>
        </div>

        <div class="row">
          <div class="col-2">
            <strong>Nome do Pai:</strong>
          </div>
          <div class="col-3">
            {{contato.funcionario.rg_pai}}
          </div>
        </div>

        <div class="row">
          <div class="col-2">
            <strong>Nome da Mãe:</strong>
          </div>
          <div class="col-3">
            {{contato.funcionario.rg_mae}}
          </div>
        </div>

      </b-card>
    </div>
  </div>

  <br>

  <div class="row">
    <div class="col-12">
      <b-card header="Salario e valores">

        <div class="row">
          <div class="col-1">
            <strong>Salario:</strong>
          </div>
          <div class="col-3">
            {{contato.funcionario.sal}}
          </div>
          <div class="col-2">
            <strong>Usuario:</strong>
          </div>
          <div class="col-2">
            {{contato.user.email}}
          </div>
        </div>

        <div class="row">
          <div class="col-1">
            <strong>Salario real:</strong>
          </div>
          <div class="col-3">
            {{contato.funcionario.sal_real}}
          </div>
          <div class="col-2">
            <strong>Senha:</strong>
          </div>
          <div class="col-2">
            ***
          </div>
        </div>

        <div class="row">
          <div class="col-1">
            <strong>V. Transp.</strong>
          </div>
          <div class="col-3">
            {{contato.funcionario.vt}}
          </div>
          <div class="col-2">
            <strong>Estado:</strong>
          </div>
          <div class="col-2">
            <span v-if="contato.user.estado=='1'">Ativo</span>
            <span v-if="contato.user.estado=='0'">Desativo</span>
          </div>
        </div>

        <div class="row">
          <div class="col-1">
            <strong>Percentual do V.T.:</strong>
          </div>
          <div class="col-3">
            {{contato.funcionario.vt_percentual}}
          </div>
        </div>

        <div class="row">
          <div class="col-1">
            <strong>V. Alim.</strong>
          </div>
          <div class="col-3">
            {{contato.funcionario.va}}
          </div>
        </div>

        <div class="row">
          <div class="col-1">
            <strong>V. Refei.</strong>
          </div>
          <div class="col-3">
            {{contato.funcionario.vr}}
          </div>
        </div>

        <div class="row">
          <div class="col-1">
            <strong>INSS:</strong>
          </div>
          <div class="col-3">
            {{contato.funcionario.inss}}
          </div>
        </div>

      </b-card>
    </div>
  </div>

</div>
</template>

<script>
    export default {
      props: {
        contato: {
          type: Object,
          default: function() { return {} }
        }
      }
    }
</script>
