<template>
  <b-button-group justify>

    <b-tooltip content="Deletar" v-if="opcoes.deletar">
      <b-button size="sm" variant="danger" :disabled="disabled" v-if="opcoes.deletar" @click="apagar"><icone icon="ban" /></b-button>
    </b-tooltip>

    <b-tooltip content="Editar" v-if="opcoes.editar">
      <b-button size="sm" variant="info" :disabled="disabled" v-if="opcoes.editar" :to="'/' + opcoes.editar.caminho + selecionado"><icone icon="pencil" /></b-button>
    </b-tooltip>

    <b-tooltip content="Detalhes" v-if="opcoes.detalhes">
      <b-button size="sm" variant="info" :disabled="disabled" v-if="opcoes.detalhes" @click="$root.$emit('show::' + opcoes.lista.caminho, selecionado)"><icone icon="file-text" /></b-button>
    </b-tooltip>

    <b-tooltip content="Creditar" v-if="opcoes.creditar">
      <b-button size="sm" variant="success" :disabled="disabled" v-if="opcoes.creditar" @click="$emit('creditar')"><icone icon="check" /></b-button>
    </b-tooltip>

    <div class="col-3">
      <b-form-input v-model="selecionado" type="text" size="sm" disabled ></b-form-input>
    </div>

  </b-button-group>
</template>

<script>
    export default {
      props: {
        disabled: {
          type: Boolean,
            default: true
        },
        selecionado: {
          type: Number,
          default: null
        },
        opcoes: {
          type: Object,
          default: function() { return {} }
        }
      },
      methods: {
        apagar() {
            if (this.disabled) {
                e.stopPropagation();
                e.preventDefault();
            } else {
              this.$emit('apagar');
            }
        }
      }
    }
</script>
