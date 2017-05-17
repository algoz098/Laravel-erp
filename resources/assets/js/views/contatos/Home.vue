<template>
  <div>

    <b-card header="Lista de Entidades" class="mb-2" v-sticky="{ zIndex: 500, stickyTop: 7 }">
      <div class="row">

        <div class="col-sm-12 col-md-4">
          <painel-acao :disabled="disabled" :selecionado="id_selecionado" :opcoes="opcoes" @recarregar="recarregar_listagem" @apagar="apagar"></painel-acao>
        </div>

        <div class="col-sm-12  col-md-4 text-center">
          <busca-padrao v-model="busca.busca" @efetuarBusca="efetuarBusca" />
        </div>

        <div class="col-sm-12 col-md-4 text-right">
          <botao-novo :opcoes="opcoes.novo" />
        </div>

      </div>

      <busca-mais v-model="busca" :busca-de="busca.de" :busca-ate="busca.ate" :deletados="perms.admin">

        <template slot="1">
          <selecionar-data label="Data de:" v-model="busca.de" />
        </template>

        <template slot="2">
          <selecionar-data label="Data até:" v-model="busca.ate"></selecionar-data>
        </template>

        <template slot="ultimo">
          <b-form-checkbox  value="true" unchecked-value="false" v-model="busca.deletados" v-if="perms.admin==1">
            Buscar deletados?
          </b-form-checkbox>
        </template>

      </busca-mais>
    </b-card>

     <b-card class="mb-2 hidden-md-down">
       <b-table striped hover class="table-sm" :items="lista.data" :fields="fields" :filter="busca.busca"  @row-clicked="linhaSelecionada($event.id)">

         <template slot="nome" scope="item">
           {{item.value}}
           <span v-if="item.item.tipo==1">{{item.item.sobrenome}}</span>
         </template>

         <template slot="sobrenome" scope="item">
           <span v-if="item.item.tipo!=1">{{item.value}}</span>
         </template>

         <template slot="active" scope="item">
           <icone icon="user" :level="item.value"></icone>
           <icone icon="signal" :level="item.item.sociabilidade"></icone>
         </template>

         <template slot="created_at" scope="item">
           {{item.value | moment("DD/MM/YY") }}
         </template>

       </b-table>

       <div class="justify-content-center row my-1">
         <b-pagination size="md" :total-rows="lista.total" :per-page="lista.per_page" v-model="lista.current_page" @input="mudarPagina" />
       </div>
     </b-card>

     <b-card class="mb-2 hidden-md-up">
       <b-table striped hover class="table-sm table-responsive" :items="lista.data" :fields="fields_mobile" :filter="busca.busca" :current-page="lista.current_page" :per-page="lista.per_page" @row-clicked="linhaSelecionada($event.id)">

         <template slot="nome" scope="item">
           {{item.value}}
           <span v-if="item.item.tipo==1">{{item.item.sobrenome}}</span>
         </template>

         <template slot="sobrenome" scope="item">
           <span v-if="item.item.tipo!=1">{{item.value}}</span>
         </template>

         <template slot="active" scope="item">
           <icone icon="user" :level="item.value"></icone>
           <icone icon="signal" :level="item.item.sociabilidade"></icone>
         </template>

         <template slot="created_at" scope="item">
           {{item.value | moment("DD/MM/YY") }}
         </template>

       </b-table>
     </b-card>

     <contatos-detalhes :id="id_selecionado" />

   </div>
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
          disabled: true,
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
                titulo: 'Entidade',
                to: '/novo/contatos'
              },
              1: {
                titulo: 'Funcionario',
                to: '/novo/funcionarios'
              }
            },
            'deletar':{
              caminho: 'novo/contatos/'
            },
            'editar':{
              caminho: 'novo/contatos/'
            },
            'lista':{
              caminho: 'contatos-detalhes'
            },
            'detalhes':true,
            'anexos':true,
            'relacionamentos':true,
          },
          id_selecionado: null,
          fields: {
                id: {
                  label: 'ID',
                  sortable: true
                },
                active: {
                  label: 'Social',
                  sortable: true
                },
                nome: {
                  label: 'Nome',
                  sortable: true
                },
                sobrenome: {
                  label: 'Nome fantasia',
                  sortable: true
                },
                cpf: {
                  label: 'Documento',
                  sortable: true
                },
                created_at: {
                  label: 'Data'
                }
              },
      fields_mobile: {
            active: {
              label: 'Social',
              sortable: true
            },
            nome: {
              label: 'Nome',
              sortable: true
            },
            sobrenome: {
              label: 'Nome fantasia',
              sortable: true
            },
            cpf: {
              label: 'Documento',
              sortable: true
            },
            created_at: {
              label: 'Data'
            }
          }
        }
      },
      methods: {
        efetuarBusca: function(){
          var self = this;
          this.busca.post(base_url + 'lista/contatos').
            then(function(response){
              self.lista = response;
              if (self.lista.data < 1){
                self.$root.$refs.toastr.i("Nao encontrei nada, reveja a busca", "Informativo");
              }
            });
        },
        mudarPagina: function(a){
          var self = this;
          this.busca.post(base_url + "/lista/contatos?page=" + a)
            .then(function(response){
              self.lista = response;
            });
        },
        recarregar_listagem: function() {
          var self = this;
          axios.post(base_url + 'lista/contatos')
            .then(function(response){
              self.lista = response.data;
            });
        },
        apagar: function(a){
          var self = this;
          axios.get(base_url + 'lista/contatos/' + this.id_selecionado + '/delete')
            .then(function(response){
              self.recarregar_listagem();
              self.$root.$refs.toastr.w("Contato: " + self.id_selecionado + " foi apagado", "Alerta!");

            });;
        },
        linhaSelecionada: function(id) {
          this.id_selecionado = id;
          this.disabled = false;
        }
      },
      mounted() {
        var self = this;
        axios.post(base_url + 'lista/contatos')
          .then(function(response){
            self.lista = response.data;
            self.perms = self.$root.perms;
          });
      }

    }
</script>
