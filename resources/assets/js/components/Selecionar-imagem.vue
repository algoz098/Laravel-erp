<template>
  <div class="form-group">

    <label>Selecionar Imagem</label>

    <div class="input-group">
      <input type="text" class="form-control" v-model="nome" readonly>
      <button type="button" class="input-group-addon btn btn-info" @click="$root.$emit('show::imagens-selecionar', id)" ><icone icon="gear" /></button>
    </div>


  </div>
</template>

<script>
    export default {
      props: {
        id: '',
        nome: '',
      },
      data(){
        return {
          selecionado: '',
        }
      },
      created(){
        this.selecionado = this.nome;


        this.$root.$on('retornar', (a, id) => {
          if (id == this.id){
            this.selecionado = a.nome;

            this.$emit('retornado', a)
          }
        });
      },
    }
</script>
