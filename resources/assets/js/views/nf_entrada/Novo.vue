<template>
  <form method="POST" @submit.prevent="onSubmit" @keydown="nf.errors.clear($event.target.name)">

    <b-card header="NF de entrada" class="mb-2" v-sticky="{ zIndex: 500, stickyTop: 7 }" >
      <div class="row">

        <div class="col text-left h3" v-if="edicao">
          ID: {{nf.id}}
        </div>

        <div class="col text-right">
          <botao-salvar-lista :lista="caminho_lista" />
        </div>

      </div>
    </b-card>

    <nf-editar-inicio v-model="nf" :nf="nf" />

    <br>

    <div class="row" v-if="edicao==true">
      <div class="col-4 offset-4">

        <carta zIndex="499" top="136">

          <template slot="header">Anexos</template>

          <anexos :attachs="nf.attachs" :upload="upload" v-if="nf.id" />

        </carta>

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
        modal: false,
      },
      data:function () {
        return {
          tabIndex: 0,
          edicao: false,
          caminho_lista: '/lista/nfentrada',
          upload: "",
          nf: new Form({
            naoResete: true,
            id: false,
            filiais_id: '',
            contatos_id: '',
            numero: '',
            total: '',
            frete: '',
            transportadora: '',
            icms_substituicao: '',
            acrescimo: '',
            desconto: '',
            obs: '',
            fornecedor: {
              nome: ''
            },
            filial: {
              nome: ''
            },
            produtos: [],
            produtos: [],
            attachs: [],
          }),
        }
      },
      mounted(){
        if (this.$route.name == "nfentrada_editar") {
          this.edicao = true;

          var self = this;
          axios.get(base_url + 'novo/nf_entrada/' + self.$route.params.id)
              .then(function(response){
                self.nf.id = response.data.id

                self.upload = base_url + 'attach/Produtos/' + self.nf.id + '/' + self.nf.filiais_id;

              });
        }

      },
      methods: {
        onSubmit() {
          var self = this;

          if (this.nf.fabricante_id==null || this.nf.fabricante_id==0 || this.nf.fabricante_id==false){

            self.$root.$refs.toastr.e("Selecione um fabricante", "Erro");

          } else {

            // Confere se é um novo conta pela rota
            if (this.$route.name == "nfentrada_novo" || this.modal) {

              this.nf.post(base_url + 'novo/nf_entrada')
                .then(function(response){
                  self.$root.$refs.toastr.s("NF adicionado com sucesso", "Informativo");

                  var a = self.modal;

                  if (!a){
                    self.$router.push({ name: 'nfentrada_lista'})
                  }

                  if (a){
                    self.$emit('nf-salvo');
                  }

                })
            }

            // Confere se é uma edicao de  contato pela rota
            if (this.$route.name == "nfentrada_editar") {
              this.nf.post(base_url + 'novo/produtos/' + self.nf.id)
                .then(function(response){
                  self.$root.$refs.toastr.s("NF atualizado com sucesso", "Informativo");
                  self.$router.push({ name: 'nfentrada_lista'})
                });
            }

          }


        }
      }
    }
</script>
