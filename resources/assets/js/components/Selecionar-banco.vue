<template>
  <div class="form-group">

    <label>{{titulo}}</label>

    <div class="input-group">
      <input type="text" class="form-control" v-model="nome" readonly>
      <button type="button" class="input-group-addon btn btn-info" @click="$root.$emit('show::bancos-selecionar', id)" ><icone icon="gear" /></button>
    </div>

  </div>
</template>

<script>
    export default {
      props: {
        id: '',
        nome: '',
        titulo: {
          default: 'Selecionar banco:'
        }
      },
      data(){
        return {
          banco_selecionado: '',
        }
      },
      created(){
        this.banco_selecionado = this.nome;

        this.$root.$on('retornar', (banco, id) => {
          if (id == this.id){
            this.banco_selecionado = banco.nome + " (" + banco.sobrenome + ")";

            this.$emit('retornado_banco', banco)
          }
        });
      },
    }
</script>
