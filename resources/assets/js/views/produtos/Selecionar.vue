<template>
  <b-modal id="produtos-selecionar" title="Selecionar Entidade"  close-title="Fechar" size="xl" >

    <produtos-lista @selecionado="retornar_selecionado" :modal="modal"></produtos-lista>

  </b-modal>
</template>

<script>
export default {
  data: function(){
    return {
      tabIndex: 0,
      modal: true,
      id_retorno: '',
      banco: {
        type: Object,
        default: function() { return {} }
      },
      comboboxes_telefones: {
        type: Object,
        default: function() { return {} }
      },
    }
  },

  created(){
    //Pega o evento do root, e efetua a sequencia de "carregaContato" porem usando o ID passado pelo evento.
    // - artur
    this.$root.$on('show::produtos-selecionar', id => {
      this.id_retorno = id;

      this.$root.$emit('show::modal', 'produtos-selecionar');
    });
  },
  methods: {
    retornar_selecionado(a){
      this.$root.$emit('hide::modal', 'produtos-selecionar');
      this.$root.$emit('retornar', a, this.id_retorno)
    }
  }
}
</script>
