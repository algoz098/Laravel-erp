<template>
  <b-modal id="contatos-selecionar" title="Selecionar Entidade"  close-title="Fechar" size="xl" >

    <contatos-lista @selecionado="retornar_selecionado" :modal="modal"></contatos-lista>

  </b-modal>
</template>

<script>
export default {
  data: function(){
    return {
      tabIndex: 0,
      modal: true,
      id_retorno: '',
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

  created(){
    //Pega o evento do root, e efetua a sequencia de "carregaContato" porem usando o ID passado pelo evento.
    // - artur
    this.$root.$on('show::contatos-selecionar', (tipo, id) => {
      this.id_retorno = id;

      this.$root.$emit('show::modal', 'contatos-selecionar');
    });
  },
  methods: {
    retornar_selecionado(a){
      this.$root.$emit('hide::modal', 'contatos-selecionar');
      this.$root.$emit('retornar', a, this.id_retorno)
    }
  }
}
</script>
