<template>
  <b-tooltip content="Adicionar registro">
    <b-dropdown text="Novo" variant="success">
      <b-dropdown-item v-for="opcao in opcoes" :to="opcao.to" :key="'novo'+opcao.titulo">{{opcao.titulo}}</b-dropdown-item>
    </b-dropdown>
  </b-tooltip>
</template>

<script>
    export default {
      props: {
        opcoes: {
          type: Object,
          default: function() { return {} }
        }
      }
    }
</script>
