<template>
  <b-modal id="grupos-selecionar" title="Selecionar grupo"  close-title="Fechar" size="xl" >

    <grupos-lista @selecionado="retornar_selecionado" :modal="modal"></grupos-lista>

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
    this.$root.$on('show::grupos-selecionar', id => {
      this.id_retorno = id;

      this.$root.$emit('show::modal', 'grupos-selecionar');
    });
  },
  methods: {
    retornar_selecionado(a){
      this.$root.$emit('hide::modal', 'grupos-selecionar');
      this.$root.$emit('retornar', a, this.id_retorno)
    }
  }
}
</script>
