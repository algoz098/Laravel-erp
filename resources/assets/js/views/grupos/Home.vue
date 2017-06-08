<template>
  <div>

    <grupos-novo v-if="cadastrando && !grupo_selecionado" modal=true @salvo="cadastrado" @voltar="cadastrado" :id_selecionado="id_selecionado" />

    <tipos-novo v-if="cadastrando && grupo_selecionado" :valor="tipo_selecionado" :nome="grupo_selecionado" modal=true @salvo="cadastrado_tipos" @voltar="cadastrado" :id_selecionado="id_selecionado" />

    <b-card header="Lista de grupos" class="mb-2" v-sticky="{ zIndex: 500, stickyTop: 7 }" v-if="!cadastrando">
      <div class="row">

        <div class="col-sm-12 col-md-4">
          <painel-acao  v-if="!em_modal" :disabled="disabled" :selecionado="id_selecionado" :opcoes="opcoes" @recarregar="recarregar_listagem" @apagar="apagar"></painel-acao>
        </div>

        <div class="col-sm-12  col-md-4 text-center">
          <busca-padrao busca_padrao=false v-model="busca.busca" @efetuarBusca="efetuarBusca" />
        </div>

        <div class="col-sm-12 col-md-4 text-right">

          <b-button v-if="id_selecionado" type="button" @click="voltar_nivel" class="btn btn-warning">
            <icone icon="arrow-left" />
          </b-button>

          <novo-modal v-if="em_modal" @novo-modal="mostrar_novo" />

          <botao-novo :opcoes="opcoes.novo" v-if="opcoes.novo || !em_modal" />

        </div>

      </div>

      <!-- <busca-mais v-model="busca" :busca-de="busca.de" :busca-ate="busca.ate" :deletados="perms.admin">

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

      </busca-mais> -->

    </b-card>

     <b-card class="mb-2 hidden-md-down" v-if="!cadastrando && !id_selecionado">
       <b-table striped hover class="table-sm" :items="lista.data" :fields="fields" :filter="busca.busca"  >

           <template slot="util" scope="item">
             <b-button variant="info" size="sm" @click="selecionar(item.item.id, item.item.nome)">
               <icone icon="sign-out" />
             </b-button>
             <b-button variant="info" size="sm" @click="editar(item.item.id)">
               <icone icon="pencil" />
             </b-button>
           </template>

          <template slot="tipos" scope="item">
            {{item.value.length}}
          </template>

       </b-table>

       <div class="justify-content-center row my-1">
         <b-pagination size="md" :total-rows="lista.total" :per-page="lista.per_page" v-model="lista.current_page" @input="mudarPagina" />
       </div>
     </b-card>

     <b-card class="mb-2 hidden-md-down" v-if="!cadastrando && id_selecionado">
       <b-table striped hover class="table-sm" :items="lista_tipos.data" :fields="fields_tipos" :filter="busca.busca"  >

           <template slot="util" scope="item">
             <b-button variant="info" size="sm" @click="selecionar_tipo(item.item)">
               <icone icon="sign-out" />
             </b-button>
             <b-button variant="info" size="sm" @click="editar_tipo(item.item.id, item.item)">
               <icone icon="pencil" />
             </b-button>
           </template>

       </b-table>

       <div class="justify-content-center row my-1">
         <b-pagination size="md" :total-rows="lista_tipos.total" :per-page="lista_tipos.per_page" v-model="lista_tipos.current_page" @input="mudarPagina" />
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
          default: "grupos"
        }
      },
      data:function () {
        return {
          disabled: true,
          cadastrando: false,
          grupo_selecionado: false,
          em_modal: false,
          busca: new Form({
            naoResete: true,
            busca: '',
            de: '',
            ate:'',
            deletados: ''
          }),
          lista: [],
          lista_tipos: [],
          perms: [],
          opcoes: {
            'novo': {
              0: {
                titulo: 'Novo Grupo',
                to: '/novo/grupos'
              },
            },
            'deletar':{
              caminho: 'novo/grupos/'
            },
            'editar':{
              caminho: 'novo/grupos/'
            },
            'lista':{
              caminho: 'grupo'
            },
            'detalhes':false,
          },
          id_selecionado: null,
          fields: {
            util: {
              label: 'Util',
              sortable: false
            },
            id: {
              label: 'Id',
              sortable: true
            },
            nome: {
              label: 'Grupo',
              sortable: true
            },
            tipos: {
              label: 'Sub-grupo',
              sortable: true
            },
          },
          fields_tipos: {
            util: {
              label: 'Util',
              sortable: false
            },
            id: {
              label: 'Id',
              sortable: true
            },
            nome: {
              label: 'Sub-Grupo',
              sortable: true
            }
          },
          fields_mobile: {
            id: {
              label: 'ID',
              sortable: true
            },
          }
        }
      },
      created(){
        this.$root.$on('show::grupos-selecionar', id => {
          this.efetuarBusca();
        });

        this.em_modal = true;
        this.opcoes.novo = false;
      },
      methods: {
        efetuarBusca: function(){
          var self = this;
          this.busca.post(base_url + 'lista/produtos/' + this.tipo).
            then(function(response){
              self.lista = response;
              if (self.lista.data < 1){
                self.$root.$refs.toastr.i("Nao encontrei nada, reveja a busca", "Informativo");
              }
            });
        },
        efetuarBusca_tipos: function(id){
          var self = this;
          this.busca.post(base_url + 'lista/produtos/grupos/' + id + '/tipos').
            then(function(response){
              self.lista_tipos = response;
              if (self.lista.data < 1){
                self.$root.$refs.toastr.i("Nao existe sub-grupos,", "Informativo");
              }
            });
        },
        voltar_nivel(){
          this.id_selecionado = null;
          this.grupo_selecionado = null;
        },
        mostrar_novo(){
          // this.id_selecionado = null;
          this.cadastrando = true;
        },
        cadastrado(){
          this.efetuarBusca();
          this.cadastrando = false;
        },
        cadastrado_tipos(){
          this.efetuarBusca_tipos(this.id_selecionado);
          this.cadastrando = false;
        },
        editar(id){
          this.id_selecionado = id;
          this.cadastrando = true;
        },
        editar_tipo(id, tipo){
          this.id_selecionado = id;
          this.tipo_selecionado = tipo;
          this.cadastrando = true;
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
          axios.post(base_url + 'lista/produtos/grupos')
            .then(function(response){
              self.lista = response.data;
            });
        },
        selecionar(id, nome){
          this.id_selecionado = id;
          this.grupo_selecionado = nome;
          this.efetuarBusca_tipos(id);
        },
        selecionar_tipo(tipo){
          this.$emit('selecionado', tipo);
        },
      }

    }
</script>
