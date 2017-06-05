<template>
  <div class="form-group">

    <label>Selecionar filial</label>

    <div class="input-group">
      <input type="text" class="form-control" v-model="nome" readonly>
      <button type="button" class="input-group-addon btn btn-info" @click="$root.$emit('show::contatos-selecionar', 'filiais', id)" ><icone icon="gear" /></button>
    </div>


  </div>
</template>

<script>
    export default {
      props: {
        id: '',
        nome: ''
      },
      data(){
        return {
          filial_selecionado: '',
        }
      },
      created(){
        this.filial_selecionado = this.nome;

        this.$root.$on('retornar', (contato, id) => {
          if (id == this.id){
            this.filial_selecionado = contato.nome + " (" + contato.sobrenome + ")";

            this.$emit('retornado_filial', contato)
          }
        });
      },
    }
</script>
