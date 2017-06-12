<template>
  <b-modal id="nfentrada-detalhes" title="Detalhes da movimentação bancaria"  close-title="Fechar" ok-title="Editar" size="xl" @shown="carregar" @ok="editar">

    <b-tabs ref="tabs" v-model="tabIndex">

      <b-tab title="Detalhes">
        <br>
        aaaaa
      </b-tab>

      <b-tab title="Anexos">
        <br>
        <anexos :attachs="nf.attachs" :upload="upload" @uploaded="carregar" />
      </b-tab>

    </b-tabs>

  </b-modal>
</template>

<script>
export default {

  data: function(){
    return {
      id: '',
      tabIndex: 0,
      nf: {
        type: Object,
        default: function() { return {} }
      },
      upload: "",
    }
  },
  created(){
    //Pega o evento do root, e efetua a sequencia de "carregaContato" porem us&&o o ID passado pelo evento.
    // - artur
    this.$root.$on('show::nfentrada', (id, triggerEl) => {
      //Copiei este codigo do BootstrapVue, não sei ainda para que se usa.
      //Pesquisar
      // - artur
      this.return_focus = triggerEl || this.return_focus || this.returnFocus || null;

      // Toda vez que abrir o modal coloca a primeira tab como ativa
      // - artur
      this.tabIndex = 0;
      this.id = id;

      //Axios ele cria uma promessa, e pro ser uma promessa, ele trabalha "idenpendente" deste escopo, então THIS no axios é o axios.
      //Faça um 'var self = this' para referenciar aos THIS deste elemento ao qual trabalhar
      // - artur
      var self = this;
      axios.get(base_url + 'lista/nf_entrada/' + id)
      .then(function(response){
        self.nf = response.data;

        // Url para anexos sendo:
        // Attach/{modulo}/{ID do item no modulo}/{ID do contato vinculado}
        // - Artur
        self.upload = base_url + 'attach/Nf_entrada/' + self.nf.id + '/' + self.nf.filial.id;

        self.$root.$emit('show::modal', 'nfentrada-detalhes');
      });
    });
  },
  methods: {
    carregar() {
      var self = this;

      axios.get(base_url + 'lista/nf_entrada/' + self.nf.id)
      .then(function(response){
        self.nf = response.data;

        this.tabIndex = 0;

        // Url para anexos sendo:
        // Attach/{modulo}/{ID do item no modulo}/{ID do contato vinculado}
        // - Artur
        self.upload = base_url + 'attach/Nf_entrada/' + self.nf.id + '/' + self.nf.filial.id;
      });

    },
    editar() {
      this.$router.push('/novo/nfentrada/' + this.id);
    }
  }
}
</script>
