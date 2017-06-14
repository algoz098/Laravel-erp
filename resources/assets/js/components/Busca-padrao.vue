<template>

  <b-tooltip content="Busca">
    <div class="row">

      <div class="col-md-10">
        <b-input-group>

          <b-form-input placeholder="Busca..."
            @input="onInput($event)"
            @change="onChange($event)"
            @keyup="onKeyUp($event)"
            @focus="$emit('focus')"
            @blur="$emit('blur')"></b-form-input>

          <b-input-group-button slot="right" >
            <b-button  variant="info" @click="efetuarBusca">
              <icone icon="search"></icone>
            </b-button>
          </b-input-group-button>

        </b-input-group>
      </div>

      <div class="col-md-2" v-if="busca_mais">
        <botao-busca-mais />
      </div>

    </div>
  </b-tooltip>

</template>

<script>
    export default {
      props: {
        busca_mais: { default: false },
      },
      methods: {
        efetuarBusca() {
          this.$emit('efetuarBusca');
        },
        onInput(value) {
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
