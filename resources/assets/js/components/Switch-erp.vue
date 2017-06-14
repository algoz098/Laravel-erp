<template>
  <div class="form-group">
    <label for="">{{label}}</label><br>
    <toggle-button :value="value" sync @change="change" :labels="{checked: 'Sim', unchecked: 'Não'}"/>
    <p class="help-block">Clique para marcar/desmarcar.</p>
  </div>
</template>

<script>
    export default {
      props: {
        label: '',
        value: false,
      },
      methods: {
        change(e){
          this.$emit("change", e)
        }
      }
    }
</script>
