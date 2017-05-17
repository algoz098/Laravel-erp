<template>
<div>

  <strong>Telefone e E-Mails</strong><br>
  <div class="row">

    <div class="col-md-6" v-for="comboboxes in comboboxes_telefones">
      <b-card>

        <strong>{{comboboxes.text}}</strong><br>

        <span :key="'telefone' + telefone.id" v-for="telefone in contato.telefones" v-if="telefone.tipo==comboboxes.text">

          <b-button size="sm" variant="danger" @click="deletarTelefone(telefone.id, index)">
            <icone icon="ban" />
          </b-button>
          
          <span class="">{{telefone.contato}}, {{telefone.setor}}</strong></span> {{ telefone.numero }}<br>

        </span>

      </b-card>
    </div>

  </div>

</div>
</template>

<script>
    export default {
      props: {
        contato: {
          type: Object,
          default: function() { return {} }
        },
        comboboxes_telefones: {
          type: Object,
          default: function() { return {} }
        }
      },
      methods: {
        deletarTelefone(id, index) {
          var self = this;
          axios.get(base_url + 'lista/contatos/telefones/' + id + '/delete')
            .then(function(response){
              self.contato.telefones.splice(index, 1);
            })
        }
      }
    }
</script>
