<template>
  <div>
    <div class="form-group" :class="{ 'has-warning': erros.length > 0 }" >
      <label class="form-control-label">{{titulo}}</label>
      <div class="input-group">
        <the-mask :class="{ 'form-control-warning': erros.length > 0 }"
          type="text"
          class="form-control"
          mask="###"
          :value="value"
          @input="onInput($event)"
          @change="onChange($event)"
          placeholder="---"
        />
        <span class="input-group-addon">%</span>
      </div>
      <p class="form-control-feedback" v-for="erro in erros">{{erro}}</p>
    </div>

  </div>
</template>

<script>
    export default {
      props: {
        value: '',
        titulo: '',
        erros: {
          type: Array,
          default: function() { return [] }
        }
      },
      methods: {
        onInput(value) {
          this.$emit('input', value);
        },
        onChange(value) {
            this.$emit('change', value);
        },
        onKeyUp(e) {
            this.$emit('keyup', e);
        }
      }
    }
</script>
