<template>
  <form method="POST" @submit.prevent="onSubmit" @keydown="contato.errors.clear($event.target.name)">

    <b-card header="Nova Entidade" class="mb-2" v-sticky="{ zIndex: 500, stickyTop: 7 }" >
      <div class="row">

        <div class="col text-left h3" v-if="edicao">
          ID: {{contato.id}}
        </div>

        <div class="col text-right">
          <botao-salvar-lista :lista="caminho_lista" />
        </div>

      </div>
    </b-card>

     <b-card class="mb-2">
       <b-tabs ref="tabs" v-model="tabIndex" >

         <b-tab title="Nome e documentos">
           <br>
           <contatos-editar-nome v-model="contato" :contato="contato" />
         </b-tab>

         <b-tab title="Endereços">
           <br>
           <contatos-editar-enderecos :contato="contato" />
         </b-tab>

         <b-tab title="Formas de contato">
           <br>
           <contatos-editar-telefones :contato="contato" />
         </b-tab>

         <b-tab title="Funcionario" v-if="e_funcionario">
           <br>
           <contatos-editar-funcionario :contato="contato" />
         </b-tab>

         <b-tab title="Observações">
           <br>
           <input-editor v-model="contato.obs" />
         </b-tab>

         <b-tab title="Anexos" v-if="contato.id != null">
           <br>
           <contatos-anexos :contato="contato" :upload="upload" />
         </b-tab>
       </b-tabs>
     </b-card>

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
        modal: {
          default: false
        },
        tipo: {
          default: 'contatos'
        }
      },
      data:function () {
        return {
          tabIndex: 0,
          e_funcionario: false,
          edicao: false,
          caminho_lista: '/lista/contatos',
          combo_telefones: '',
          upload: "",
          contato: new Form({
            naoResete: true,
            active: true,
            tipo_filial: false,
            sociabilidade: '3',
            nome: '',
            sobrenome: '',
            cpf: '',
            rg: '',
            nascimento: '',
            codigo: '',
            cod_prefeitura: '',
            obs: '',
            enderecos: [],
            telefones: [],
            user: {},
            funcionario: {},
            tipo: '0',
          }),
        }
      },
      mounted(){
        if (this.$route.name == "funcionario_novo" || this.$route.name == "funcionario_editar" ) {
          this.e_funcionario = true;
          this.contato.tipo = "2";
          // this.contato.funcionario = {vt:'', vt_percentual:''};
        }
        if (this.$route.name == "contato_editar") {
          this.edicao = true;
          var self = this;
          axios.get(base_url + 'novo/contatos/' + self.$route.params.id)
            .then(function(response){
              // console.log(response.data);
              self.contato.id = response.data.id;
              self.contato.nome = response.data.nome;
              self.contato.tipo = response.data.tipo;
              self.contato.sobrenome = response.data.sobrenome;
              self.contato.cpf = response.data.cpf;
              self.contato.rg = response.data.rg;
              self.contato.sociabilidade = response.data.sociabilidade;
              self.contato.obs = response.data.obs;
              self.contato.codigo = response.data.codigo;
              self.contato.nascimento = response.data.nascimento;
              self.contato.telefones = response.data.telefones;
              self.contato.enderecos = response.data.enderecos;

              if (response.data.funcionario!=null){
                self.contato.funcionario = response.data.funcionario;
                self.contato.user = response.data.user;
                self.e_funcionario = true;

              }

              self.contato.attachs_too = response.data.attachs_too;
              self.upload = base_url + 'attach/contatos/' + self.contato.id + '/' + self.contato.id;

              if(response.data.activo==0 && (response.data.tipo!=true || response.data.tipo!=false)){
                self.contato.active = false;
              }
              if (response.data.activo!=0 && (response.data.tipo!=true || response.data.tipo!=false)){
                self.contato.active = true;

              }
            });
        }
      },
      methods: {
        onSubmit() {
          var self = this;

          // Confere se é um novo contato pela rota
          if (this.$route.name == "contato_novo" || this.tipo=="contatos") {
            this.contato.post(base_url + 'novo/contatos')
              .then(function(response){
                self.$root.$refs.toastr.s("Contato salvo com sucesso", "Informativo");

                var a = self.modal;
                if (!a){
                  self.$router.push({ name: 'contato_lista'})
                }
                if (a){
                  self.$emit('contato-salvo');
                }

              });
          }
          // Confere se é uma edicao de  contato pela rota
          if (this.$route.name == "contato_editar") {
            this.contato.post(base_url + 'novo/contatos/' + self.contato.id)
              .then(function(response){
                self.$root.$refs.toastr.s("Contato salvo com sucesso", "Informativo");
                self.$router.push({ name: 'contato_lista'})
              });
          }
          // Confere se é um novo funcionario pela rota
          if (this.$route.name == "funcionario_novo") {
            this.contato.post(base_url + 'novo/funcionarios')
              .then(function(response){
                self.$root.$refs.toastr.s("Funcionario salvo com sucesso", "Informativo");
                self.$router.push({ name: 'contato_lista'})
              });
          }

        }
      }
    }
</script>
