<template>
  <form method="POST" @submit.prevent="onSubmit" @keydown="banco.errors.clear($event.target.name)">

    <b-card header="Nova conta bancaria" class="mb-2" v-sticky="{ zIndex: 500, stickyTop: 7 }" >
      <div class="row">

        <div class="col text-left h3" v-if="edicao">
          ID: {{banco.id}}
        </div>

        <div class="col text-right">
          <botao-salvar-lista :lista="caminho_lista" />
        </div>

      </div>
    </b-card>

     <b-card class="mb-2">
       <b-tabs ref="tabs" v-model="tabIndex" >

         <b-tab title="Inicio">
           <br>
           <bancos-editar-inicio v-model="banco" :banco="banco" />
         </b-tab>

         <b-tab title="Anexos" v-if="banco.id">
           <br>
           <anexos :attachs="banco.attachs" :upload="upload" />
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
        modal: false,
      },
      data:function () {
        return {
          tabIndex: 0,
          edicao: false,
          caminho_lista: '/lista/bancos',
          upload: "",
          banco: new Form({
            naoResete: true,
            id: false,
            filial_id: '',
            contatos_id: '',
            tipo: '',
            agencia: '',
            cc: '',
            cc_dig: '',
            comp: '',
            valor: '',
            attachs: [],
            filial: {
              nome: '',
            },
            banco: {
              nome: '',
            },
          }),
        }
      },
      mounted(){
        if (this.$route.name == "bancos_editar") {
          this.edicao = true;

          var self = this;
          axios.get(base_url + 'novo/bancos/' + self.$route.params.id)
              .then(function(response){
                self.banco.id = response.data.id;
                self.banco.filial_id = response.data.filial_id;
                self.banco.filial.nome = response.data.filial.nome;
                self.banco.contatos_id = response.data.contatos_id;
                self.banco.banco.nome = response.data.banco.nome;
                self.banco.tipo = response.data.tipo;
                self.banco.agencia = response.data.agencia;
                self.banco.cc = response.data.cc;
                self.banco.cc_dig = response.data.cc_dig;
                self.banco.comp = response.data.comp;
                self.banco.valor = response.data.valor;

                self.upload = base_url + 'attach/Bancos/' + self.banco.id + '/' + self.banco.contatos_id;
              });
        }

      },
      methods: {
        onSubmit() {
          var self = this;

          // Confere se é um novo conta pela rota
          if (this.$route.name == "bancos_novo" || this.modal) {

            this.banco.post(base_url + 'novo/bancos')
              .then(function(response){
                self.$root.$refs.toastr.s("Conta bancaria adicionado com sucesso", "Informativo");

                var a = self.modal;

                if (!a){
                  self.$router.push({ name: 'bancos_lista'})
                }

                if (a){
                  self.$emit('banco-salvo');
                }

              });
          }

          // Confere se é uma edicao de  contato pela rota
          if (this.$route.name == "bancos_editar") {
            this.banco.post(base_url + 'novo/bancos/' + self.banco.id)
              .then(function(response){
                self.$root.$refs.toastr.s("Conta bancaria atualizado com sucesso", "Informativo");
                self.$router.push({ name: 'bancos_lista'})
              });
          }
        }
      }
    }
</script>
