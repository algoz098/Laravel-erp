<template>
  <div>

    <b-card header="Lista de Contas" class="mb-2" v-sticky="{ zIndex: 500, stickyTop: 7 }">
      <div class="row">

        <div class="col-sm-12 col-md-4">
          <painel-acao  v-if="!em_modal" :disabled="disabled" :selecionado="id_selecionado" :opcoes="opcoes" @recarregar="recarregar_listagem" @apagar="apagar" @perms="editar_perms"></painel-acao>
        </div>

        <div class="col-sm-12  col-md-4 text-center">
          <busca-padrao v-model="busca.busca" @efetuarBusca="efetuarBusca"  />
        </div>

        <!-- <div class="col-sm-12 col-md-4 text-right">
          <botao-novo :opcoes="opcoes.novo" v-if="opcoes.novo" />
        </div> -->

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

     <b-card class="mb-2 hidden-md-down">
       <b-table striped hover class="table-sm" :items="lista.data" :fields="fields" :filter="busca.busca"  @row-clicked="linhaSelecionada($event)">

         <template slot="user" scope="item">

          <span class="badge badge-primary" v-if="item.value.perms.admin">
            ADM
          </span>

           <b-button variant="info" size="sm" @click="mostrar_contato(item.item.user.id)">
             <icone icon="user" />
             {{item.item.nome}} {{item.item.sobrenome}}
           </b-button>

         </template>
         <template slot="usuario" scope="item">

           <span class="badge badge-success" v-if="item.item.user.ativo==1">
             Ativo
           </span>

           <span class="badge badge-waning" v-if="item.item.user.ativo!=1">
             Desativo
           </span>

         </template>
         <template slot="perms" scope="item">

           <span v-if="item.item.user.perms.contatos">

             Entidades

             <span class="badge " :class="{'badge-danger': item.item.user.perms.contatos.leitura==0, 'badge-success': item.item.user.perms.contatos.leitura==1}" >
               L
             </span>

             <span class="badge " :class="{'badge-danger': item.item.user.perms.contatos.adicao==0, 'badge-success': item.item.user.perms.contatos.adicao==1}" >
               A
             </span>

             <span class="badge " :class="{'badge-danger': item.item.user.perms.contatos.edicao==0, 'badge-success': item.item.user.perms.contatos.edicao==1}" >
               E
             </span>

             |

           </span>
           <span v-if="item.item.user.perms.contas">

             Contas

             <span class="badge " :class="{'badge-danger': item.item.user.perms.contas.leitura==0, 'badge-success': item.item.user.perms.contas.leitura==1}" >
               L
             </span>

             <span class="badge " :class="{'badge-danger': item.item.user.perms.contas.adicao==0, 'badge-success': item.item.user.perms.contas.adicao==1}" >
               A
             </span>

             <span class="badge " :class="{'badge-danger': item.item.user.perms.contas.edicao==0, 'badge-success': item.item.user.perms.contas.edicao==1}" >
               E
             </span>

             |

           </span>
           <span v-if="item.item.user.perms.bancos">

             Bancos

             <span class="badge " :class="{'badge-danger': item.item.user.perms.bancos.leitura==0, 'badge-success': item.item.user.perms.bancos.leitura==1}" >
               L
             </span>

             <span class="badge " :class="{'badge-danger': item.item.user.perms.bancos.adicao==0, 'badge-success': item.item.user.perms.bancos.adicao==1}" >
               A
             </span>

             <span class="badge " :class="{'badge-danger': item.item.user.perms.bancos.edicao==0, 'badge-success': item.item.user.perms.bancos.edicao==1}" >
               E
             </span>

             |

           </span>
           <span v-if="item.item.user.perms.estoques">

             Estoques

             <span class="badge " :class="{'badge-danger': item.item.user.perms.estoques.leitura==0, 'badge-success': item.item.user.perms.estoques.leitura==1}" >
               L
             </span>

             <span class="badge " :class="{'badge-danger': item.item.user.perms.estoques.adicao==0, 'badge-success': item.item.user.perms.estoques.adicao==1}" >
               A
             </span>

             <span class="badge " :class="{'badge-danger': item.item.user.perms.estoques.edicao==0, 'badge-success': item.item.user.perms.estoques.edicao==1}" >
               E
             </span>

             |

           </span>


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
  import Form from '../../../core/Form';
  import VueSticky from 'vue-sticky';

    export default {
      directives:{
        'sticky': VueSticky,
      },
      props: {
        tipo: {
          default: "usuarios"
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
            'deletar':{
              caminho: 'novo/usuarios/'
            },
            'editar':{
              caminho: 'admin/usuarios/novo/'
            },
            'lista':{
              caminho: 'admin/usuarios/lista'
            },
            'perms':true,
          },
          id_selecionado: null,
          selecionado: '',
          fields: {
                id: {
                  label: 'ID',
                  sortable: true
                },
                user: {
                  label: 'Entidade',
                  sortable: true
                },
                usuario: {
                  label: 'Usuario',
                  sortable: true
                },
                perms: {
                  label: 'Perms',
                  sortable: false
                },
              },
      fields_mobile: {

          }
        }
      },
      methods: {
        efetuarBusca: function(){
          var self = this;
          this.busca.post(base_url + 'admin/lista/' + this.tipo).
            then(function(response){
              self.lista = response;
              if (self.lista.data < 1){
                self.$root.$refs.toastr.i("Nao encontrei nada, reveja a busca", "Informativo");
              }
            });
        },
        mudarPagina: function(a){
          var self = this;
          this.busca.post(base_url + "admin/lista" + this.tipo + "?page=" + a)
            .then(function(response){
              self.lista = response;
            });
        },
        recarregar_listagem: function() {
          var self = this;
          axios.post(base_url + 'admin/lista/usuarios')
            .then(function(response){
              self.lista = response.data;
            });
        },
        apagar: function(a){
          var self = this;
          axios.get(base_url + 'admin/usuarios/' + this.id_selecionado + '/delete')
            .then(function(response){
              self.recarregar_listagem();
              self.$root.$refs.toastr.w("Usuario: " + self.id_selecionado + " foi apagado", "Alerta!");

            });;
        },
        editar_perms(){
          // console.log("ae")
          this.$router.push({path: '/admin/usuarios/1/perms'})
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
        var self = this;
        axios.post(base_url + 'lista/' + this.tipo)
          .then(function(response){
            self.lista = response.data;
            self.perms = self.$root.perms;
          });
      }

    }
</script>
