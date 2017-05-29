<template>
  <div>
    <div class="form-group" :class="{ 'has-warning': erros.length > 0 }">
      <label class="form-control-label">{{titulo}}</label>
      <div class="input-group">
        <span class="input-group-addon">R$</span>
        <masked-input :class="{ 'form-control-warning': erros.length > 0 }"
          type="text"
          class="form-control"
          :readonly="readonly"
          :mask="mascara"
          :value="value"
          @input="onInput($event)"
          @change="onChange($event)"
        />
      </div>
      <p class="form-control-feedback" v-for="erro in erros">{{erro}}</p>
    </div>
  </div>
</template>

<script>
import createNumberMask from 'text-mask-addons/dist/createNumberMask'

    export default {
      props: {
      	value: null,
        titulo: '',
        readonly: {
          default: false
        },
        erros: {
          type: Array,
          default: function() { return [] }
        }
      },
      data(){
        return {
          mascara: createNumberMask({
              prefix: '',
              suffix: '',
              allowDecimal: true
            }),
        }
      },
      methods: {
        onInput(value) {
          this.$emit('input', value);
        },
        onChange(value) {
          this.$emit('input', value);
          this.$emit('change', value);
        },
      }
    }
</script>
