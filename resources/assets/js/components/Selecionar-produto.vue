<template>
  <div class="form-group">

    <label v-if="portitulo==true" >{{titulo}}</label>

    <div :class="'input-group input-group-' + size">
      <input type="text" :class="'form-control form-control-' + size" v-model="nome" readonly>
      <button type="button" class="input-group-addon btn btn-info" @click="$root.$emit('show::produtos-selecionar', id)" ><icone icon="gear" /></button>
    </div>

  </div>
</template>

<script>
    export default {
      props: {
        id: '',
        nome: '',
        size: {
          default: 'md'
        },
        titulo: {
          default: 'Selecionar produto:'
        },
        portitulo: {
          default: true
        }
      },
      data(){
        return {
          produto_selecionado: '',
        }
      },
      created(){
        this.produto_selecionado = this.nome;

        this.$root.$on('retornar', (produto, id) => {
          if (id == this.id){
            this.produto_selecionado = produto.nome;

            this.$emit('retornado', produto)
          }
        });
      },
    }
</script>
