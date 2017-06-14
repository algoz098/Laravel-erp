<template>
  <b-modal id="contatos-detalhes" title="Detalhes de entidade"  close-title="Fechar" ok-title="Editar" size="xl" @shown="carregarContato" @ok="editarContato">
    <b-tabs ref="tabs" v-model="tabIndex">

      <b-tab title="Detalhes">
        <br>
        <contatos-tab-detalhes :contato="contato"/>
      </b-tab>

      <b-tab title="Endereços">
        <br>
        <contatos-enderecos :contato="contato" />
      </b-tab>

      <b-tab title="Cont/Tels/E-Mails">
        <br>
        <contatos-telefones :contato="contato"  :comboboxes_telefones="comboboxes_telefones"/>
      </b-tab>

      <b-tab title="Funcionario" v-if="contato.tipo=='2'">
        <br>
        <contatos-funcionario :contato="contato" />
      </b-tab>

      <b-tab title="Observações">

        <br>
        <strong>Observações</strong><br>
        <b-card>
          <div v-html="contato.obs"></div>
        </b-card>

      </b-tab>

      <b-tab title="Anexos" >

        <br>
        <contatos-anexos :contato="contato" :upload="upload" @uploaded="carregarContato"/>

      </b-tab>

      <b-tab title="Relacionamentos" >
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
      contato: {
        type: Object,
        default: function() { return {} }
      },
      comboboxes_telefones: {
        type: Object,
        default: function() { return {} }
      },
      upload: "",
    }
  },
  created(){
    //Pega o evento do root, e efetua a sequencia de "carregaContato" porem usando o ID passado pelo evento.
    // - artur
    this.$root.$on('show::contato', (id, triggerEl) => {
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
      axios.get(base_url + '/lista/contatos/' + id)
      .then(function(response){
        self.contato = response.data.contato;
        self.upload = base_url + 'attach/contatos/' + self.contato.id + '/' + self.contato.id;
        self.comboboxes_telefones = response.data.comboboxes_telefones;
        self.$root.$emit('show::modal', 'contatos-detalhes');
      });
    });

    
  },
  methods: {
    carregarContato() {
      var self = this;

      axios.get(base_url + '/lista/contatos/' + self.id)
      .then(function(response){
        self.contato = response.data.contato;
        self.upload = base_url + 'attach/contatos/' + self.contato.id + '/' + self.contato.id;
        self.comboboxes_telefones = response.data.comboboxes_telefones;
      });

      this.tabIndex = 0;


    },
    editarContato() {
      this.$router.push('/novo/contatos/' + this.id);
    }
  }
}
</script>
