<template>
<div>
  <div class="row">

    <div class="col" style="margin-bottom:15px;">
      <span class="h2">
        <icone icon="user" :level="contato.active"  />
        <icone icon="signal" :level="contato.sociabilidade" />
      </span>
    </div>

  </div>
  <div class="row">

    <div class="col">
      <strong v-if="contato.tipo==0">Nome fantasia:</strong>
      <strong v-if="contato.tipo==1">Nome:</strong>
    </div>

  </div>
  <div class="row">

    <div class="col">
      <span style="font-size: 30px">
        {{contato.nome}}
        <span v-if="contato.tipo==1"> {{contato.sobrenome}}</span>
      </span>
    </div>

  </div>
  <div class="row" v-if="contato.funcionario">

    <div class="col">
      <strong>Cargo:</strong> {{contato.funcionario.cargo}}
    </div>

  </div>
  <div class="row" v-if="contato.funcionario">

    <div class="col">
      Data adm.: <span class="">{{contato.funcionario.data_adm}}</span>
      Data dem.: <span class="">{{contato.funcionario.data_dem}}</span>
    </div>

  </div>
  <hr>
  <div class="row">

    <div class="col-md-12">

      <div class="row"  v-if="contato.tipo=='0' || contato.id=='1'">

        <div class="col-md-2">
          <strong>Razão Social:</strong>
        </div>
        <div class="col-md-10">
          <span class="">{{contato.nome}}</span>
        </div>

      </div>
      <div class="row">

        <div class="col-md-2">
          <strong v-if="contato.tipo==0 || contato.id==1">CNPJ:</strong>
          <strong v-if="contato.tipo==1 || contato.funcionario">CPF:</strong>
        </div>

        <div class="col-md-5">
          <span class="">{{contato.cpf}}</span>
        </div>

      </div>
      <div class="row">

        <div class="col-md-2">
          <strong v-if="contato.tipo==0 || contato.id==1">I.E.:</strong>
          <strong v-if="contato.tipo==1 || contato.funcionario">RG:</strong>
        </div>

        <div class="col-md-5">
          <span class="">{{contato.rg}}</span>
        </div>

      </div>
      <div class="row" v-if="contato.tipo==1 || contato.funcionario">

        <div class="col-md-2">
          <strong>Dt. Nasc.:</strong>
        </div>

        <div class="col-md-10">
          {{contato.nascimento}}
        </div>

      </div>
      <div class="row">

        <div class="col-md-2">
          <strong>Ins. Pref.:</strong>
        </div>

        <div class="col-md-5">
          <span class="">{{contato.cod_prefeitura}}</span>
        </div>

      </div>
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
