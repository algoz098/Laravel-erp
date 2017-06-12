<template>
  <form method="POST" @submit.prevent="onSubmit" @keydown="user.errors.clear($event.target.name)">

    <carta>

      <template slot="header">
        Editar perms usuarios
      </template>

        <div class="row">

          <div class="col text-left h3">
            ID: {{user.id}}
          </div>

          <div class="col text-right">
            <botao-salvar-lista :lista="caminho_lista" />
          </div>

        </div>

    </carta>

    <div class="row">

      <div class="col-4 offset-4">

        <carta>
          <b-table striped hover class="table-sm" :items="lista.data" :fields="fields" :filter="busca.busca"  @row-clicked="linhaSelecionada($event)">

            <template slot="user" scope="item">

             <span class="badge badge-primary" v-if="item.value.perms.admin">
               ADM
             </span>

              <b-button variant="info" size="sm" @click="mostrar_contato(item.item.user.id)">
                <icone icon="user" />
                {{item.item.nome}} {{item.item.sobrenome}}
              </b-button>

            </template>

          </b-table>
        </carta>

      </div>

    </div>

   </form>
</template>

<script>
  import Form from '../../../core/Form';
  import VueSticky from 'vue-sticky';

    export default {
      directives:{
        'sticky': VueSticky,
      },
      data:function () {
        return {
          tabIndex: 0,
          edicao: false,
          caminho_lista: '/admin/usuarios/lista',
          upload: "",
          user: new Form({
            naoResete: true,
            id: false,
            ativo: '',
            perms: ''
          }),
        }
      },
      mounted(){

      var self = this;
      axios.get(base_url + 'novo/usuarios/' + self.$route.params.id)
          .then(function(response){
            self.user.id = response.data.id
            self.user.perms = response.data.perms
        })
      },
      methods: {
        onSubmit() {
          var self = this;

          this.user.post(base_url + 'lista/usuarios/perms' + self.user.id)
            .then(function(response){
              self.$root.$refs.toastr.s("Permissões de usuario atualizado com sucesso", "Informativo");
              self.$router.push({ name: 'usuarios_lista'})
            });
        },
        ativo_mudar(e){
          this.user.ativo = e.value;
        },
      }
    }
</script>
