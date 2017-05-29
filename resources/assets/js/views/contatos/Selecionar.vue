<template>
  <b-modal id="contatos-selecionar" title="Selecionar Entidade"  close-title="Fechar" size="xl" >

    <contatos-lista :tipo="tipo" @selecionado="retornar_selecionado" />

  </b-modal>
</template>

<script>
export default {
  props:{
    tipo: {
      default: 'contatos'
    },
  },
  data: function(){
    return {
      tabIndex: 0,
      contato: {
        type: Object,
        default: function() { return {} }
      },
      comboboxes_telefones: {
        type: Object,
        default: function() { return {} }
      },
    }
  },
  methods: {
    retornar_selecionado(a){
      this.$emit('retornar', a)
      this.$root.$emit('hide::modal', 'contatos-selecionar');
    }
  }
}
</script>
