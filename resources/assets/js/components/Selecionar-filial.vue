<template>
  <div class="form-group">

    <label>Selecionar filial</label>

    <div class="input-group">
      <input type="text" class="form-control" v-model="filial_selecionado" readonly>
      <button type="button" class="input-group-addon btn btn-info" @click="$root.$emit('show::modal', 'contatos-selecionar')" ><icone icon="gear" /></button>
    </div>

    <contatos-selecionar tipo="filiais" @retornar="retornado_filial" />

  </div>
</template>

<script>
    export default {
      props: {
        nome: ''
      },
      data(){
        return {
          filial_selecionado: '',

        }
      },
      created(){
        this.filial_selecionado = this.nome;
      },
      methods: {
        retornado_filial(a){
          this.filial_selecionado = a.nome + " (" + a.sobrenome + ")";
          this.$emit('retornado_filial', a)
        },

      }
    }
</script>
