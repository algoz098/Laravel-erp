<template>
  <b-button-group justify>

    <b-tooltip content="Deletar">
      <b-button size="sm" variant="danger" :disabled="disabled" v-if="opcoes.deletar" @click="apagar"><icone icon="ban" /></b-button>
    </b-tooltip>

    <b-tooltip content="Editar">
      <b-button size="sm" variant="info" :disabled="disabled" v-if="opcoes.editar" :to="'/' + opcoes.editar.caminho + selecionado"><icone icon="pencil" /></b-button>
    </b-tooltip>

    <b-tooltip content="Detalhes">
      <b-button size="sm" variant="info" :disabled="disabled" v-if="opcoes.detalhes" @click="$root.$emit('show::modal', opcoes.lista.caminho)"><icone icon="file-text" /></b-button>
    </b-tooltip>

    <b-tooltip content="Relacionamentos">
      <b-button size="sm" variant="info" :disabled="disabled" v-if="opcoes.relacionamentos"><icone icon="users" /></b-button>
    </b-tooltip>

    <b-tooltip content="Anexos">
      <b-button size="sm" variant="warning" :disabled="disabled" v-if="opcoes.anexos"><icone icon="paperclip" /></b-button>
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
