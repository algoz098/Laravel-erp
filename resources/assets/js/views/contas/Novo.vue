<template>
  <form method="POST" @submit.prevent="onSubmit" @keydown="conta.errors.clear($event.target.name)">

    <b-card header="Novo historico bancario" class="mb-2" v-sticky="{ zIndex: 500, stickyTop: 7 }" >
      <div class="row">

        <div class="col text-left h3" v-if="edicao">
          ID: {{conta.id}}
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
           <contas-editar-inicio v-model="conta" :conta="conta" />
         </b-tab>

         <b-tab title="Descrição">
           <br>
           <input-editor v-model="conta.descricao" />
         </b-tab>

         <b-tab title="Anexos" v-if="conta.id != null">
           <br>
           <anexos :attachs="conta.attachs" :upload="upload" />
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
      data:function () {
        return {
          tabIndex: 0,
          edicao: false,
          caminho_lista: '/lista/contas',
          combo_telefones: '',
          upload: "",
          conta: new Form({
            naoResete: true,
            descricao: '',
            contatos_id: '',
            tipo: '',
            nome: '',
            vencimento: '',
            valor: '',
            desconto: '',
            dm: '',
            attachs: [],
            contato: {
              nome: '',
            },
          }),
        }
      },
      mounted(){
        if (this.$route.name == "contas_editar") {
          this.edicao = true;

          var self = this;
          axios.get(base_url + 'novo/contas/' + self.$route.params.id)
              .then(function(response){
                self.contato = response.data.contato.nome;

                self.conta.id = response.data.id;
                self.conta.contatos_id = response.data.contatos_id;
                self.conta.tipo = response.data.tipo;
                self.conta.nome = response.data.nome;
                self.conta.contato = response.data.contato;
                self.conta.attachs = response.data.attachs;
                self.conta.vencimento = response.data.vencimento;
                self.conta.valor = response.data.valor;
                self.conta.desconto = response.data.desconto;
                self.conta.descricao = response.data.descricao;
                self.conta.dm = response.data.dm;
                self.conta.obs = response.data.obs;

                self.upload = base_url + 'attach/Contas/' + self.conta.id + '/' + self.conta.contato.id;
              });
        }
      },
      methods: {
        onSubmit() {
          var self = this;
          // Confere se é um novo conta pela rota
          if (this.$route.name == "contas_novo") {
            this.conta.post(base_url + 'novo/contas')
              .then(function(response){
                self.$root.$refs.toastr.s("Historico adicionado com sucesso", "Informativo");
                self.$router.push({ name: 'contas_lista'})
              });
          }
          // Confere se é uma edicao de  contato pela rota
          if (this.$route.name == "contas_editar") {
            this.conta.post(base_url + 'novo/contas/' + self.conta.id)
              .then(function(response){
                self.$root.$refs.toastr.s("Historico salvo com sucesso", "Informativo");
                self.$router.push({ name: 'contas_lista'})
              });
          }
        }
      }
    }
</script>
