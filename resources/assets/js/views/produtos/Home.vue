<template>
  <div>

    <b-card header="Lista de Contas" class="mb-2" v-sticky="{ zIndex: 500, stickyTop: 7 }">
      <div class="row">

        <div class="col-sm-12 col-md-4">
          <painel-acao  v-if="!em_modal" :disabled="disabled" :selecionado="id_selecionado" :opcoes="opcoes" @recarregar="recarregar_listagem" @apagar="apagar"></painel-acao>
        </div>

        <div class="col-sm-12  col-md-4 text-center">
          <busca-padrao v-model="busca.busca" @efetuarBusca="efetuarBusca" />
        </div>

        <div class="col-sm-12 col-md-4 text-right">
          <botao-novo :opcoes="opcoes.novo" v-if="opcoes.novo" />
        </div>

      </div>

      <busca-mais v-model="busca" :busca-de="busca.de" :busca-ate="busca.ate" :deletados="perms.admin">

        <template slot="1">
          <input-mascara v-model="busca.de" titulo="Data de:" mascara="XX/XX/XX" placeholder="__/__/__" />
        </template>

        <template slot="2">
          <input-mascara v-model="busca.ate" titulo="Data até:" mascara="XX/XX/XX" placeholder="__/__/__" />
        </template>

        <template slot="ultimo">
          <b-form-checkbox  value="true" unchecked-value="false" v-model="busca.deletados" v-if="perms.admin==1">
            Buscar deletados?
          </b-form-checkbox>
        </template>

      </busca-mais>
    </b-card>

     <b-card class="mb-2 hidden-md-down">
       <b-table striped hover class="table-sm" :items="lista.data" :fields="fields" :filter="busca.busca"  @row-clicked="linhaSelecionada($event)">

         <template slot="tipo" scope="item">
           <span v-if="item.value != null"> {{item.value.grupo.nome}} -> {{item.value.nome}} </span>
         </template>

       </b-table>

       <div class="justify-content-center row my-1">
         <b-pagination size="md" :total-rows="lista.total" :per-page="lista.per_page" v-model="lista.current_page" @input="mudarPagina" />
       </div>
     </b-card>

     <b-card class="mb-2 hidden-md-up">
       <b-table striped hover class="table-sm table-responsive" :items="lista.data" :fields="fields_mobile" :filter="busca.busca" :current-page="lista.current_page" :per-page="lista.per_page" @row-clicked="linhaSelecionada($event.id)">

       </b-table>
     </b-card>

   </div>
</template>

<script>
  import Form from '../../core/Form';
  import VueSticky from 'vue-sticky';

    export default {
      directives:{
        'sticky': VueSticky,
      },
      props: {
        tipo: {
          default: "produtos"
        }
      },
      data:function () {
        return {
          disabled: true,
          em_modal: false,
          busca: new Form({
            naoResete: true,
            busca: '',
            de: '',
            ate:'',
            deletados: ''
          }),
          lista: [],
          perms: [],
          opcoes: {
            'novo': {
              0: {
                titulo: 'Novo produto',
                to: '/novo/produtos'
              },
            },
            'deletar':{
              caminho: 'novo/produtos/'
            },
            'editar':{
              caminho: 'novo/produtos/'
            },
            'lista':{
              caminho: 'produto'
            },
            'detalhes':true,
            'creditar':false,
          },
          id_selecionado: null,
          selecionado: '',
          fields: {
                id: {
                  label: 'ID',
                  sortable: true
                },
                nome: {
                  label: 'Codigo',
                  sortable: true
                },
                tipo: {
                  label: 'Grupo/Sub-Grupo',
                  sortable: true
                },
                armazem: {
                  label: 'Local',
                  sortable: true
                },
                aplicacao: {
                  label: 'Aplicação',
                  sortable: true
                },
                created_at: {
                  label: 'Data',
                  sortable: true
                },
              },
      fields_mobile: {
            id: {
              label: 'ID',
              sortable: true
            },
            contato: {
              label: 'Entidade',
              sortable: true
            },
            valor: {
              label: 'Valor',
              sortable: true
            },
            vencimento: {
              label: 'Vencimento',
              sortable: true
            },
            estado: {
              label: 'Estado',
              sortable: true
            },
            vencimento: {
              label: 'Vencimento'
            }
          }
        }
      },
      methods: {
        efetuarBusca: function(){
          var self = this;
          this.busca.post(base_url + 'lista/' + this.tipo).
            then(function(response){
              self.lista = response;
              if (self.lista.data < 1){
                self.$root.$refs.toastr.i("Nao encontrei nada, reveja a busca", "Informativo");
              }
            });
        },
        mudarPagina: function(a){
          var self = this;
          this.busca.post(base_url + "/lista" + this.tipo + "?page=" + a)
            .then(function(response){
              self.lista = response;
            });
        },
        recarregar_listagem: function() {
          var self = this;
          axios.post(base_url + 'lista/produtos')
            .then(function(response){
              self.lista = response.data;
            });
        },
        apagar: function(a){
          var self = this;
          axios.get(base_url + 'lista/produtos/' + this.id_selecionado + '/delete')
            .then(function(response){
              self.recarregar_listagem();
              self.$root.$refs.toastr.w("Produto: " + self.id_selecionado + " foi apagado", "Alerta!");

            });;
        },
        linhaSelecionada: function(linha) {
          this.id_selecionado = linha.id;
          this.selecionado = linha;
          if ( this.em_modal ){
            this.$emit('selecionado', linha);
          }
          this.disabled = false;
        },
        mostrar_contato(id){
          this.$root.$emit('show::contato', id);
        }
      },
      mounted() {
        if (this.$route.name!="produtos_lista") {
          this.em_modal = true;
          this.opcoes.novo = false;
        }
        var self = this;
        axios.post(base_url + 'lista/' + this.tipo)
          .then(function(response){
            self.lista = response.data;
            self.perms = self.$root.perms;
          });
      }

    }
</script>
