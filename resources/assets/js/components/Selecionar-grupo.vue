<template>
  <div class="form-group">

    <label>{{titulo}}</label>

    <div class="input-group">
      <input type="text" class="form-control" v-model="nome" readonly>
      <button type="button" class="input-group-addon btn btn-info" @click="$root.$emit('show::grupos-selecionar', id)" ><icone icon="gear" /></button>
    </div>

  </div>
</template>

<script>
    export default {
      props: {
        id: '',
        nome: '',
        titulo: {
          default: 'Selecionar grupo:'
        }
      },
      data(){
        return {
          grupo_selecionado: '',
        }
      },
      created(){
        this.grupo_selecionado = this.nome;

        this.$root.$on('retornar', (grupo, id) => {
          if (id == this.id){
            this.grupo_selecionado = grupo.nome;

            this.$emit('retornado_grupo', grupo)
          }
        });
      },
    }
</script>
