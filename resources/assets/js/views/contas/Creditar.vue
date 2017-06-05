<template>
  <form method="POST" @submit.prevent="onSubmit" @keydown="conta.errors.clear($event.target.name)">

        <b-card header="Creditar historico bancario" class="mb-2" v-sticky="{ zIndex: 500, stickyTop: 7 }" >
          <div class="row">

            <div class="col text-left h3">
              ID: {{conta.id}}
            </div>

            <div class="col text-right">
              <botao-salvar-lista :lista="caminho_lista" salvarLabel="Creditar" />
            </div>

          </div>
        </b-card>

         <b-card class="mb-2">
           <strong>Dados do historico bancario:</strong>
           ID: {{conta.id}},
           {{conta.nome}},
           R$ {{conta.valor}},
           {{conta.contato.nome}}
         </b-card>

         <div class="row">

           <div class="offset-md-3 col-md-6">

             <b-card header="Dados de credito" >
               <div class="row">

                 <div class="col-6">
                   <selecionar-banco id="banco_id" :nome="banco" @retornado_banco="retornado_banco" />
                 </div>

                 <div class="col-6">
                   <input-dinheiro v-model="historico.valor" titulo="Valor pago:" />
                 </div>

               </div>
             </b-card>

           </div>

           <div class="col-md-3">

             <b-card header="Calculos" >

               <div class="row">

                 <div class="col-6">
                   <strong>Total da conta =</strong>
                 </div>

                 <div class="col-6">
                   {{conta.valor}}
                 </div>

               </div>
               <div class="row">

                 <div class="col-6">
                   <strong>Valor sendo pago =</strong>
                 </div>

                 <div class="col-6">
                   {{historico.valor}}
                 </div>

               </div>
               <div class="row">

                 <div class="col-6">
                   <strong>Irá faltar =</strong>
                 </div>

                 <div class="col-6">
                   {{restante_pago}}
                 </div>

               </div>

             </b-card>

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
      data:function () {
        return {
          caminho_lista: '/lista/contas',
          banco: '',
          conta: {
            id: '',
            contatos_id: '',
            tipo: '',
            nome: '',
            valor: '',
            contato: '',
          },
          historico: new Form({
            naoResete: true,
            bancos_id: '',
            valor: '',
          }),
        }
      },
      computed:{
        restante_pago(){
          return this.conta.valor - this.historico.valor;
        }
      },
      mounted(){
        var self = this;
        axios.get(base_url + 'novo/contas/' + self.$route.params.id)
            .then(function(response){
              self.conta.id = response.data.id;
              self.conta.contatos_id = response.data.contatos_id;
              self.conta.tipo = response.data.tipo;
              self.conta.nome = response.data.nome;
              self.conta.valor = response.data.valor;
              self.conta.contato = response.data.contato;

              self.historico.valor = response.data.valor;
            });
      },
      methods: {
        onSubmit() {
          var self = this;
          if(this.historico.estado==0){

            this.historico.post(base_url + 'lista/contas/' + self.conta.id + '/pago')
            .then(function(response){
              self.$root.$refs.toastr.s("Valor creditado com sucesso", "Informativo");
              self.$router.push({ name: 'contas_lista'})
            });

          } else {
            self.$root.$refs.toastr.d("Historico já consta como pago.", "Opa!");

          }
        },
        retornado_banco(banco) {
          this.banco = banco.banco.nome;
          this.historico.bancos_id = banco.id;
        }
      }
    }
</script>
