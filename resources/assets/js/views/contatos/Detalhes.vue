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

      <template slot="modal-footer">
        aaaaaa
      </template>
    </b-tabs>

  </b-modal>
</template>

<script>
export default {
  props:{
    id: '',
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
      upload: "",
    }
  },
  methods: {
    carregarContato() {
      this.tabIndex = 0;
      var self = this;
      axios.get(base_url + '/lista/contatos/' + self.id)
      .then(function(response){
        self.contato = response.data.contato;
        self.upload = base_url + 'attach/contatos/' + self.contato.id + '/' + self.contato.id;
        self.comboboxes_telefones = response.data.comboboxes_telefones;
      })
    },
    editarContato() {
      this.$router.push('/novo/contatos/' + this.id);
    }
  }
}
</script>
