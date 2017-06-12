<template>
    <div class="form-group" :class="{ 'has-warning': erros.length > 0 }" >
      <label v-if="titulo!='false'" class="form-control-label">{{titulo}}</label>
        <input :disabled="disabled" :type="type" :id="id" :class="[classe, {'form-control-warning': erros.length > 0}]"
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
        size:{
          default: 'md'
        },
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
      computed:{
        classe(){
          return 'form-control form-control-' + this.size;
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
