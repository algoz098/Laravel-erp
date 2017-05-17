<template>
  <b-modal id="contatos-detalhes" title="Detalhes de entidade"  size="xl" @shown="carregarContato">
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
        <contatos-anexos :contato="contato" />

      </b-tab>

      <b-tab title="Relacionamentos" >

      </b-tab>

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
      }
    }
  },
  methods: {
    carregarContato() {
      this.tabIndex = 0;
      var self = this;
      axios.get(base_url + '/lista/contatos/' + self.id)
      .then(function(response){
        self.contato = response.data.contato;
        self.comboboxes_telefones = response.data.comboboxes_telefones;
      })
    }
  }
}
</script>
