<template>
  <form method="POST" @submit.prevent="onSubmit" @keydown="produto.errors.clear($event.target.name)">

    <b-card header="Novo produto" class="mb-2" v-sticky="{ zIndex: 500, stickyTop: top }" >
      <div class="row">

        <div class="col text-left h3" v-if="edicao">
          ID: {{produto.id}}
        </div>

        <div class="col text-right">
          <botao-salvar-lista @lista="voltar" :lista="caminho_lista" />
        </div>

      </div>
    </b-card>

    <produtos-editar-inicio v-model="produto" :produto="produto" />

    <br>

    <div class="row">
      <div class="col-9 offset-3">

        <carta zIndex="499" top="136">

          <template slot="header">Anexos</template>

          <anexos :attachs="produto.attachs" :upload="upload" v-if="produto.id" />

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
          top: 7,
          edicao: false,
          caminho_lista: '/lista/produtos',
          upload: "",
          produto: new Form({
            naoResete: true,
            id: false,
            fabricante_id: '',
            produtos_tipo_id: '',
            tipo_nome: '',
            nome: '',
            barras: '',
            aplicacao: '',
            armazenagem: '',
            embalagem: '',
            peso: '',
            unidade: '',
            custo: '',
            margem: '',
            venda: '',
            minimo: '',
            maximo: '',
            externos: [],
            campos: [],
            tipo: [],
            attachs: [],
            semelhantes_to: [],
            semelhantes_from: [],
            fabricante: {
              nome: '',
            },
          }),
        }
      },
      mounted(){
        if (this.$route.name == "produtos_editar") {
          this.edicao = true;

          var self = this;
          axios.get(base_url + 'novo/produtos/' + self.$route.params.id)
              .then(function(response){
                self.produto.id = response.data.id
                self.produto.fabricante_id = response.data.fabricante_id

                self.upload = base_url + 'attach/Produtos/' + self.produto.id + '/' + self.produto.contatos_id;

                self.produto.produtos_tipo_id = response.data.produtos_tipo_id
                self.produto.nome = response.data.nome
                self.produto.barras = response.data.barras
                self.produto.aplicacao = response.data.aplicacao


                console.log(response.data.armazenagens[0].pivot.local)
                self.produto.armazenagem = response.data.armazenagens[0].pivot.local
                self.produto.embalagem = response.data.embalagem
                self.produto.peso = response.data.peso
                self.produto.unidade = response.data.unidade
                self.produto.custo = response.data.custo
                self.produto.margem = response.data.margem
                self.produto.venda = response.data.venda
                self.produto.minimo = response.data.minimo
                self.produto.maximo = response.data.maximo
                self.produto.externos = response.data.externos
                self.produto.contato = response.data.contato

                self.produto.semelhantes_to = response.data.semelhantes_to;
                self.produto.semelhantes_from = response.data.semelhantes_from;

                self.produto.fabricante = response.data.fabricante
                self.produto.campos = response.data.campos
                self.produto.tipo_nome = response.data.tipo.nome

              });
        }

      },
      methods: {
        voltar(){
          this.$emit('voltar');
        },
        onSubmit() {
          var self = this;

          if (this.produto.fabricante_id==null || this.produto.fabricante_id==0 || this.produto.fabricante_id==false){

            self.$root.$refs.toastr.e("Selecione um fabricante", "Erro");

          } else {

            // Confere se é um novo conta pela rota
            if (this.$route.name == "produtos_novo" || this.modal) {

              this.produto.post(base_url + 'novo/produtos')
                .then(function(response){
                  self.$root.$refs.toastr.s("Produto criado com sucesso", "Informativo");

                  var a = self.modal;

                  if (!a){
                    self.$router.push({ name: 'produtos_lista'})
                  }

                  if (a){
                    self.$emit('produto-salvo');
                  }

                })
            }

            // Confere se é uma edicao de  contato pela rota
            if (this.$route.name == "produtos_editar") {
              this.produto.post(base_url + 'novo/produtos/' + self.produto.id)
                .then(function(response){
                  self.$root.$refs.toastr.s("Produto atualizado com sucesso", "Informativo");
                  self.$router.push({ name: 'produtos_lista'})
                });
            }

          }


        }
      }
    }
</script>
