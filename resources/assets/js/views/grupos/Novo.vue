<template>
  <form method="POST" @submit.prevent="onSubmit" @keydown="grupo.errors.clear($event.target.name)">

    <b-card header="Novo grupo de produtos" class="mb-2" v-sticky="{ zIndex: 500, stickyTop: 7 }" >
      <div class="row">

        <div class="col text-right">
          <botao-salvar-lista :modal="modal" @lista="voltar" :lista="caminho_lista" />
        </div>

      </div>
    </b-card>

    <br>

    <div class="row">
      <div class="col-4 offset-4">

        <b-card >
          <input-texto titulo="Nome do grupo" v-model="grupo.nome" />
        </b-card>

      </div>
    </div>

   </form>
</template>

<script>
  import Form from '../../core/Form';
  import VueSticky from 'vue-sticky';

    export default {
      directives:{
        'sticky': VueSticky,
      },
      props:{
        id_selecionado: null,
        modal: {
          default: false
        },
        tipo: {
          default: 'grupo'
        }
      },
      data:function () {
        return {
          tabIndex: 0,
          edicao: false,
          caminho_lista: '/lista/produtos/grupos',
          upload: "",
          grupo: new Form({
            naoResete: true,
            id: null,
            nome: '',
          }),
        }
      },
      mounted(){

      },
      beforeMount(){
        if (this.id_selecionado != null) {
          var self = this;

          axios.get(base_url + 'novo/produtos/grupos/' + self.id_selecionado )
            .then(function(response){
              self.grupo.nome = response.data.nome;
              self.grupo.id = response.data.id;
            })
        }
      },
      methods: {
        onSubmit() {
          var self = this;

          this.grupo.post(base_url + 'novo/produtos/grupos')
            .then(function(response){
              self.$emit("salvo")

              self.$root.$refs.toastr.s("Grupo criado com sucesso", "Informativo");
            });
        },
        voltar(){
          this.$emit('voltar');
        }
      }
    }
</script>
