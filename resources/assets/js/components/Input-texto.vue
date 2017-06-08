<template>
    <div class="form-group" :class="{ 'has-warning': erros.length > 0 }" >
      <label class="form-control-label">{{titulo}}</label>
      <input :disabled="disabled" :type="type" class="form-control" :id="id" :class="{ 'form-control-warning': erros.length > 0}"
      @input="onInput($event)"
      @change="onChange($event)"
      @focus="$emit('focus')"
      @blur="$emit('blur')"
      :value="value"
      :readonly="readonly"
      />
      <p class="form-control-feedback" v-for="erro in erros">{{erro}}</p>
    </div>
</template>

<script>
    export default {
      props: {
        titulo: '',
        id: '',
        disabled: {
          default: false
        },
        value: '',
        type: {
          default: 'text'
        },
        readonly: {
          default: false
        },
        erros: {
          type: Array,
          default: function() { return [] }
        }
      },
      methods: {
        onInput(value) {
          this.$emit('input', value.target.value);
        },
        onChange(value) {
          this.$emit('input', value.target.value);
          this.$emit('change', value.target.value);
        },
        onKeyUp(e) {
          this.$emit('keyup', e.target.value);
        }
      }
    }
</script>
