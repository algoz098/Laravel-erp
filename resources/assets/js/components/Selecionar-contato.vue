<template>
  <div class="form-group">

    <label>{{titulo}}</label>

    <div class="input-group">
      <input type="text" class="form-control" v-model="nome" readonly>
      <button type="button" class="input-group-addon btn btn-info" @click="$root.$emit('show::contatos-selecionar', 'contatos', id)" ><icone icon="gear" /></button>
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
