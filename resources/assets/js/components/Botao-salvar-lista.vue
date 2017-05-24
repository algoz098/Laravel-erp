<template>
  <b-button-group>
    <b-tooltip content="Ver listagem">
      <b-button variant="warning" :to="this.lista" ><icone icon="bars" /> Lista</b-button>
    </b-tooltip>

    <b-tooltip content="Salvar registro">
      <b-button variant="success" type="submit"><icone icon="plus" /> Salvar</b-button>
    </b-tooltip>
  </b-button-group>
</template>

<script>
    export default {
      props: {
        salvar: '',
        lista: ''
      }
    }
</script>
