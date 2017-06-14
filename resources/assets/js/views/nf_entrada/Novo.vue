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
            frete: 0,
            transportadora: 0,
            seguro: 0,
            icms_substituicao: 0,
            acrescimo: 0,
            desconto: 0,
            obs: '',
            total_ipi: '',
            total_icms: '',
            total_produtos: '',
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
                self.nf.filial.nome = response.data.filial.nome
                self.nf.filiais_id = response.data.filiais_id
                self.nf.fornecedor.nome = response.data.fornecedor.nome
                self.nf.contatos_id = response.data.fornecedor_id
                self.nf.numero = response.data.numero
                self.nf.total = response.data.total
                self.nf.frete = response.data.frete
                self.nf.transportadora = response.data.transportadora
                self.nf.seguro = response.data.seguro
                self.nf.icms_substituicao = response.data.icms_substituicao
                self.nf.acrescimo = response.data.acrescimo
                self.nf.desconto = response.data.desconto
                self.nf.produtos = response.data.nf_produtos

                self.upload = base_url + 'attach/Produtos/' + self.nf.id + '/' + self.nf.filiais_id;

              });
        }

      },
      methods: {
        onSubmit() {
          var self = this;

          if (this.nf.filiais_id==null || this.nf.filiais_id==0 || this.nf.filiais_id==false){

            self.$root.$refs.toastr.e("Selecione a filial recebendo os produtos", "Erro");

          } else if (this.nf.contatos_id==null || this.nf.contatos_id==0 || this.nf.contatos_id==false){

            self.$root.$refs.toastr.e("Selecione um fornecedor", "Erro");

          }else {

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

                  self.$router.push({ name: 'nfentrada_lista'})


                })
            }

            // Confere se é uma edicao de  contato pela rota
            if (this.$route.name == "nfentrada_editar") {
              this.nf.post(base_url + 'novo/nf_entrada/' + self.nf.id)
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
