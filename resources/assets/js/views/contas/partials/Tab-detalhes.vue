<template>
  <b-card>

    <div class="row">

      <div class="col-2">
        <strong>ID:</strong>
      </div>

      <div class="col-6">
        {{conta.id}}
      </div>

    </div>

    <div class="row">

      <div class="col-2">
        <strong>Entidade:</strong>
      </div>

      <div class="col-6">
        {{conta.contato.nome}} ({{conta.contato.sobrenome}})
      </div>

    </div>

    <div class="row">

      <div class="col-2">
        <strong>Tipo</strong>
      </div>

      <div class="col-6">
        <span v-if="conta.tipo=='0'">Debito</span>
        <span v-if="conta.tipo=='1'">Credito</span>
        <span v-if="conta.tipo=='2'">Conta de consumo</span>
      </div>

    </div>

    <div class="row">

      <div class="col-2">
        <strong>Referencia:</strong>
      </div>

      <div class="col-6">
        {{conta.nome}}
      </div>

    </div>

    <div class="row">

      <div class="col-2">
        <strong>Vencimento:</strong>
      </div>

      <div class="col-6">
        {{conta.vencimento}}
      </div>

    </div>

    <div class="row">

      <div class="col-2">
        <strong>Valor:</strong>
      </div>

      <div class="col-6">
        R$ {{conta.valor}}
      </div>

    </div>

    <div class="row">

      <div class="col-2">
        <strong>Estado:</strong>
      </div>

      <div class="col-6">
        <span v-if="conta.estado=='0' && (conta.tipo=='0' || conta.tipo=='2')">A pagar</span>
        <span v-if="conta.estado=='0' && (conta.tipo=='1' || conta.tipo=='2')">A receber</span>
        <span v-if="conta.estado=='1' && (conta.tipo=='0' || conta.tipo=='2')">Pago</span>
        <span v-if="conta.estado=='1' && (conta.tipo=='1' || conta.tipo=='2')">Recebido</span>
      </div>

    </div>

    <div class="row">

      <div class="col-2">
        <strong>Lançado:</strong>
      </div>

      <div class="col-6">
        {{conta.created_at}}
      </div>

    </div>
    <div class="row">

      <div class="col-2">
        <strong>Usuario:</strong>
      </div>

      <div class="col-6">

      </div>

    </div>

  </b-card>
</template>

<script>
    export default {
      props: {
        conta: {
          type: Object,
          default: function() { return {} }
        }
      }
    }
</script>
