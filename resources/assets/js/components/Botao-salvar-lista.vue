<template>
  <b-button-group>
    <b-tooltip content="Ver listagem">
      <b-button type="button" variant="warning" @click="botao_lista" ><icone icon="bars" /> Lista</b-button>
    </b-tooltip>

    <b-tooltip content="Salvar registro">
      <b-button  variant="success" type="submit"><icone icon="plus" /> {{salvarLabel}}</b-button>
    </b-tooltip>
  </b-button-group>
</template>

<script>
    export default {
      props: {
        modal: {
          default: false
        },
        salvar: '',
        lista: {
          default: ''
        },
        salvarLabel: {
          default: 'Salvar'
        },
      },
      methods:{
        botao_lista(){
          this.$emit('lista');

          if (this.modal==false) {
            this.$router.replace(this.lista)
          }
        },
      }
    }
</script>
