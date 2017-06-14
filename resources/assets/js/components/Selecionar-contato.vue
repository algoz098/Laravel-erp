<template>
  <div class="form-group" :class="{ 'has-warning': erros.length > 0 }">

    <label class="form-control-label">{{titulo}}</label>

    <div class="input-group">
      <input type="text" class="form-control" v-model="nome" readonly :class="{ 'form-control-warning': erros.length > 0}">
      <button type="button" class="input-group-addon btn btn-info" @click="$root.$emit('show::contatos-selecionar', 'contatos', id)" :class="{ 'form-control-warning': erros.length > 0}"><icone icon="gear" /></button>
    </div>

  </div>
</template>

<script>
    export default {
      props: {
        id: '',
        nome: '',
        titulo: {
          default: 'Selecionar Contato:'
        },
        erros: {
          type: Array,
          default: function() { return [] }
        }
      },
      data(){
        return {
          contato_selecionado: '',
        }
      },
      created(){
        this.contato_selecionado = this.nome;

        this.$root.$on('retornar', (contato, id) => {
          if (id == this.id){
            this.contato_selecionado = contato.nome + " (" + contato.sobrenome + ")";

            this.$emit('retornado_contato', contato)
          }
        });
      },
    }
</script>
