<template>
  <div class="form-group" :class="{ 'has-warning': erros.length > 0 }">
    <label class="form-control-label">{{titulo}}</label>
    <select value="value" class="form-control"
      @input="onInput($event)"
      @change="onChange($event)"
      @focus="$emit('focus')"
      @blur="$emit('blur')"
      :value="value"
    >
      <option v-for="option in options" :value="option.value">{{option.label}}</option>
    </select>
    <!-- <multiselect
        :options="options"
        placeholder="Clique para escolher"
        tagPlaceholder="Aperte ENTER para selecionar"
        selectedLabel="Selecionado"
        deselectLabel="Aperte ENTER para deselecionar"
        :custom-label="labelize"
        :value="value"
        @input="onInput($event)"
        @change="onChange($event)"
        @keyup="onKeyUp($event)"
        @focus="$emit('focus')"
        @blur="$emit('blur')"
    ><template slot="noResult">Não encontrei resultado</template></multiselect> -->
    <p class="form-control-feedback" v-for="erro in erros">{{erro}}</p>
  </div>
</template>

<script>
    export default {
      props: {
        titulo: '',
        value:'',
        options: {
          type: Array,
          default: function() { return [] }
        },
        url: '',
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
