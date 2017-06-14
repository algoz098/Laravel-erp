<template>
  <div>
    <div class="form-group" :class="{ 'has-warning': erros.length > 0 }">
      <label class="form-control-label" v-if="titulo!='false'">{{titulo}}</label>
      <div class="input-group">
        <span class="input-group-addon" v-if="addon!='false'">R$</span>
        <masked-input :class="[classe, {'form-control-warning': erros.length > 0}]"
          type="text"
          class="form-control"
          :disabled=disabled
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
        addon: {
          default: true
        },
        disabled:true,
      	value: null,
        titulo: '',
        size: {
          default: 'md'
        },
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
              includeThousandsSeparator: false,
              allowDecimal: true
            }),
        }
      },
      computed:{
        classe(){
          return 'form-control form-control-' + this.size;
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
