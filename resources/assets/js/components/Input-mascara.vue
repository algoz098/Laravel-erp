<template>
  <div>
    <div class="form-group" :class="{ 'has-warning': erros.length > 0 }" v-if="mascara != ''">
      <label class="form-control-label">{{titulo}}</label>
      <the-mask id="este" :class="{ 'form-control-warning': erros.length > 0 }"
        type="text"
        class="form-control"
        :mask="mascara"
        :value="value"
        @input="onInput($event)"
        @change="onChange($event)"
        :placeholder="placeholder"
      />
      <p class="form-control-feedback" v-for="erro in erros">{{erro}}</p>
    </div>
    <input-texto :value="value" @input="onInput($event)" @change="onChange($event)" :titulo="titulo" :erros="erros" v-if="mascara == '' || mascara == null" />

  </div>
</template>

<script>
    export default {
      props: {
        mascarado: {
          type: Boolean,
          default: true
        },
        mascara: {
          default: ''
        },
        value: '',
        titulo: '',
        placeholder: '',
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
            // value = this.format(value);
            // this.$emit('input', value);
            this.$emit('change', value);
        },
        onKeyUp(e) {
            this.$emit('keyup', e);
        }
      }
    }
</script>
