<template>
  <div>

    <bancos-novo v-if="cadastrando" modal=true @banco-salvo="cadastrado" />

    <b-card header="Lista de contas Bancarias" class="mb-2" v-sticky="{ zIndex: 500, stickyTop: 7 }" v-if="!cadastrando">
      <div class="row">

        <div class="col-sm-12 col-md-4">
          <painel-acao  v-if="!em_modal" :disabled="disabled" :selecionado="id_selecionado" :opcoes="opcoes" @recarregar="recarregar_listagem" @apagar="apagar"></painel-acao>
        </div>

        <div class="col-sm-12  col-md-4 text-center">
          <busca-padrao v-model="busca.busca" @efetuarBusca="efetuarBusca" />
        </div>

        <div class="col-sm-12 col-md-4 text-right">
          <novo-modal v-if="em_modal" @novo-modal="mostrar_novo" />
          <botao-novo :opcoes="opcoes.novo" v-if="opcoes.novo || !em_modal" />
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

     <b-card class="mb-2 hidden-md-down" v-if="!cadastrando">
       <b-table striped hover class="table-sm" :items="lista.data" :fields="fields" :filter="busca.busca"  @row-clicked="linhaSelecionada($event)">

          <template slot="filial" scope="item">
            <b-button variant="info" size="sm" @click="mostrar_contato(item.value.id)">
              <icone icon="user" />
              {{item.value.nome}} ({{item.value.sobrenome}})
            </b-button>
          </template>

          <template slot="banco" scope="item">
            <b-button variant="info" size="sm" @click="mostrar_contato(item.value.id)">
              <icone icon="user" />
              {{item.value.nome}} ({{item.value.sobrenome}})
            </b-button>
          </template>

         <template slot="cc" scope="item">
           {{item.value}}-{{item.item.cc_dig}}
         </template>

         <template slot="valor" scope="item">
           R$ {{item.value}}
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

         <template slot="filial" scope="item">
           <b-button variant="info" size="sm" @click="mostrar_contato(item.value.id)">
             <icone icon="user" />
             {{item.value.nome}} ({{item.value.sobrenome}})
           </b-button>
         </template>

         <template slot="banco" scope="item">
           <b-button variant="info" size="sm" @click="mostrar_contato(item.value.id)">
             <icone icon="user" />
             {{item.value.nome}} ({{item.value.sobrenome}})
           </b-button>
         </template>

        <template slot="cc" scope="item">
          {{item.value}}-{{item.item.cc_dig}}
        </template>

        <template slot="valor" scope="item">
          R$ {{item.value}}
        </template>

        <template slot="created_at" scope="item">
          {{item.value | moment("DD/MM/YY") }}
        </template>

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
          default: "bancos"
        }
      },
      data:function () {
        return {
          disabled: true,
          cadastrando: false,
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
                titulo: 'Novo banco',
                to: '/novo/bancos'
              },
            },
            'deletar':{
              caminho: 'novo/bancos/'
            },
            'editar':{
              caminho: 'novo/bancos/'
            },
            'lista':{
              caminho: 'banco'
            },
            'detalhes':false,
          },
          id_selecionado: null,
          fields: {
            id: {
              label: 'ID',
              sortable: true
            },
            filial: {
              label: 'Filial',
              sortable: true
            },
            banco: {
              label: 'Banco',
              sortable: true
            },
            tipo: {
              label: 'Tipo',
              sortable: true
            },
            agencia: {
              label: 'Agencia',
              sortable: true
            },
            cc: {
              label: 'CC/Dig',
              sortable: true
            },
            comp: {
              label: 'Comp',
              sortable: true
            },
            valor: {
              label: 'Em conta',
              sortable: true
            },
            created_at: {
              label: 'Data',
              sortable: true
            }
          },
          fields_mobile: {
            id: {
              label: 'ID',
              sortable: true
            },
            filial: {
              label: 'Filial',
              sortable: true
            },
            banco: {
              label: 'Banco',
              sortable: true
            },
            agencia: {
              label: 'Agencia',
              sortable: true
            },
            cc: {
              label: 'CC/Dig',
              sortable: true
            },
            valor: {
              label: 'Em conta',
              sortable: true
            }
          }
        }
      },
      created(){
        if (this.$route.name!="bancos_lista") {

          this.$root.$on('show::bancos-selecionar', id => {
            this.efetuarBusca();
          });

          this.em_modal = true;
          this.opcoes.novo = false;

        } else {
          this.efetuarBusca();
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
        mostrar_novo(){
          this.cadastrando = true;
        },
        cadastrado(){
          this.efetuarBusca();
          this.cadastrando = false;
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
          axios.post(base_url + 'lista/bancos')
            .then(function(response){
              self.lista = response.data;
            });
        },
        apagar: function(a){
          var self = this;
          axios.get(base_url + 'lista/bancos/' + this.id_selecionado + '/delete')
            .then(function(response){
              self.recarregar_listagem();
              self.$root.$refs.toastr.w("Banco: " + self.id_selecionado + " foi apagado", "Alerta!");

            });;
        },
        linhaSelecionada: function(linha) {
          this.id_selecionado = linha.id;
          if ( this.em_modal ){
            this.$emit('selecionado', linha);
          }
          this.disabled = false;
        },
        mostrar_contato(id){
          this.$root.$emit('show::contato', id);
        }
      }

    }
</script>
