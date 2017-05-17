<template>
<div>

  <strong>Endereços</strong><br>
  <div class="row">

    <div class="col-6" v-for="(endereco, index) in contato.enderecos">
      <b-card :key="'endereco'+endereco.id">

        <b-tooltip content="Deletar endereço"  v-if="$root.perms.contatos.edicao==1">
          <b-button size="sm" variant="danger" @click="deletarEndereco(endereco.id, index)">
            <icone icon="ban" />
          </b-button>
        </b-tooltip>

        <strong>{{endereco.tipo}}</strong><br>
        {{endereco.endereco}} {{endereco.numero}} {{endereco.complemento}}<br>
        {{endereco.bairro}}<br>
        {{endereco.cep}} - {{endereco.cidade}}, {{endereco.uf}}

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
        }
      },
      methods: {
        deletarEndereco(id, index) {
          var self = this;
          axios.get(base_url + 'lista/contatos/enderecos/' + id + '/delete')
            .then(function(response){
              self.contato.enderecos.splice(index, 1);
            })
        }
      }
    }
</script>
