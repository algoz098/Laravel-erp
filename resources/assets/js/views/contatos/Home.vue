<template>
  <div>
    <b-card header="Lista de Entidades" class="mb-2">
      <div class="row">

        <div class="col text-left">

          <painel-acao :disabled="disabled" :selecionado="id_selecionado" :opcoes="opcoes" @recarregar="recarregar_listagem" @apagar="apagar"></painel-acao>

        </div>

        <div class="col text-center">
          -- BUSCA --
        </div>
        <div class="col text-right">
          -- BOTOES --
        </div>
      </div>
     </b-card>

     <b-card class="mb-2">
       <b-table striped hover :items="lista.data" :fields="fields" :current-page="lista.current_page" :per-page="lista.per_page" @row-clicked="linhaSelecionada($event.id)">

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

   </div>
</template>

<script>
    export default {
      data:function () {
        return {
          disabled: true,
          lista: [],
          opcoes: {
            'deletar':{
              caminho: 'novo/contato/'
            },
            'editar':{
              caminho: 'novo/contato/'
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
              }
        }
      },
      methods: {
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
          });
      }

    }
</script>
