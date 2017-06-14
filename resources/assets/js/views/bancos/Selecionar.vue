<template>
  <b-modal id="bancos-selecionar" title="Selecionar Entidade"  close-title="Fechar" size="xl" >

    <bancos-lista @selecionado="retornar_selecionado" :modal="modal"></bancos-lista>

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
    this.$root.$on('show::bancos-selecionar', id => {
      this.id_retorno = id;

      this.$root.$emit('show::modal', 'bancos-selecionar');
    });
  },
  methods: {
    retornar_selecionado(a){
      this.$root.$emit('hide::modal', 'bancos-selecionar');
      this.$root.$emit('retornar', a, this.id_retorno)
    }
  }
}
</script>
