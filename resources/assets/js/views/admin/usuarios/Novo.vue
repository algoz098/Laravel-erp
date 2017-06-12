<template>
  <form method="POST" @submit.prevent="onSubmit" @keydown="user.errors.clear($event.target.name)">

    <carta>

      <template slot="header">
        Editar usuarios
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

      <div class="col-2 flex-last">

        <carta>
          <switch-erp label="Usuario ativo?" :value="user.ativo" @change="ativo_mudar" />
        </carta>

      </div>
      <div class="col-4 offset-4">

        <carta>

          <input-texto v-model="user.trabalho.nome" disabled="true" titulo="Filial do funcionario:" />
          <input-texto v-model="user.email" titulo="Usuario de acesso:" />
          <input-texto v-model="user.password"  titulo="Senha de acesso:" />

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
            trabalho_id: '',
            email: '',
            password: '',
            trabalho: {},
          }),
        }
      },
      mounted(){

      var self = this;
      axios.get(base_url + 'novo/usuarios/' + self.$route.params.id)
          .then(function(response){
            self.user.id = response.data.id
            self.user.trabalho_id = response.data.trabalho_id
            self.user.email = response.data.email
            self.user.trabalho = response.data.trabalho
        })
      },
      methods: {
        onSubmit() {
          var self = this;

          this.user.post(base_url + 'novo/usuarios/' + self.user.id)
            .then(function(response){
              self.$root.$refs.toastr.s("Usuario atualizado com sucesso", "Informativo");
              self.$router.push({ name: 'usuarios_lista'})
            });
        },
        ativo_mudar(e){
          this.user.ativo = e.value;
        },
      }
    }
</script>
