<template>
  <div>
    <label>{{label}}</label>

    <masked-input
      type="text"
      name="phone"
      class="form-control"
      :mask="[/[1-9]/, /\d/, '/',  /\d/, /\d/, '/', /\d/, /\d/]"
      guide
      placeholderChar="_"
      @input="onInput($event)"
      @change="onChange($event)"
      @keyup="onKeyUp($event)"
      @focus="$emit('focus')"
      @blur="$emit('blur')"
      >
    </masked-input>
  </div>
</template>

<script>
    export default {
      props: {
        value: {
            default: null
        },
        label: ''
      },
      methods: {
        onInput(value) {
          console.log(value);
          this.$emit('input', value);
        },
        onChange(value) {
            value = this.format(value);
            this.$emit('input', value);
            this.$emit('change', value);
        },
        onKeyUp(e) {
            this.$emit('keyup', e);
        }
      }
    }
</script>
