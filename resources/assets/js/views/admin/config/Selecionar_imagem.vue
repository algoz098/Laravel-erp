<template>
  <b-modal id="imagens-selecionar" title="Selecionar Imagem"  close-title="Fechar" size="xl" >

    <b-table striped hover class="table-sm" :items="lista" :fields="fields"  @row-clicked="retornar_selecionado($event)">
    </b-table>

  </b-modal>
</template>

<script>
export default {
  data: function(){
    return {
      tabIndex: 0,
      modal: true,
      id_retorno: '',
      lista: [],
      fields: {
            name: {
              label: 'Nome',
              sortable: true
            },
            path: {
              label: 'Arquivo',
              sortable: true
            },
          },
    }
  },

  created(){
    //Pega o evento do root, e efetua a sequencia de "carregaContato" porem usando o ID passado pelo evento.
    // - artur
    this.$root.$on('show::imagens-selecionar', id => {
      this.id_retorno = id;

      var self = this;
      axios.get(base_url + '/lista/contatos/1')
        .then(function(response){
          self.lista = response.data.contato.attachs_too
        })

      this.$root.$emit('show::modal', 'imagens-selecionar');
    });
  },
  methods: {
    retornar_selecionado(a){
      this.$root.$emit('hide::modal', 'imagens-selecionar');
      this.$root.$emit('retornar', a, this.id_retorno)
    }
  }
}
</script>
