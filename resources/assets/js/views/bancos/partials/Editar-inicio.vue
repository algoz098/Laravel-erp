<template>
<div class="row">

  <div class="col-3">
    <b-card header="Informações basicas">

      <selecionar-filial id="filial_id" :nome="banco.filial.nome" @retornado_filial="retornado_filial" />

      <selecionar-contato id="bancos_id" titulo="Banco" :nome="banco.banco.nome" @retornado_contato="retornado_banco" />

      <selecionar-busca v-model="banco.tipo" titulo="Tipo:" :erros="banco.errors.errors.tipo" :options="tipos" v-if="edicao==false" />

    </b-card>
  </div>

  <div class="col-3">
    <b-card header="Pagamentos e valores">

      <input-mascara v-model="banco.agencia" titulo="Agencia:" :erros="banco.errors.errors.agencia" mascara="########-#" />

      <div class="row">

        <div class="col-8">
          <input-mascara v-model="banco.cc" titulo="Conta Corrente:" :erros="banco.errors.errors.cc" mascara="########" />
        </div>

        <div class="col-md-4">
          <input-mascara v-model="banco.cc_dig" titulo="Dig:" :erros="banco.errors.errors.cc_dig" mascara="#" />
        </div>

      </div>

      <input-mascara v-model="banco.comp" titulo="Compensação:" :erros="banco.errors.errors.comp" mascara="####-#" />


    </b-card>
  </div>

  <div class="col-3">
    <b-card header="Detalhes">

      <input-dinheiro v-model="banco.valor" titulo="Valor em conta:" />

    </b-card>
  </div>

</div>
</template>

<script>
    export default {
      props: {
        banco: {type: Object},
      },
      data(){
        return {
          false: true,
          edicao: false,
          tipos: [
            {value: '', label: '- Escolha - '},
            {value: 'CC', label: 'CC - Conta corrente'},
            {value: 'CP', label: 'CP - Poupança'}
          ],
        }
      },
      created(){

      },
      methods: {
        retornado_banco(a){
          this.banco.banco.nome = a.nome;
          this.banco.contatos_id = a.id;
        },
        retornado_filial(a){
          this.banco.filial.nome = a.nome;
          this.banco.filial_id = a.id;
        },
        onInput(value) {
          this.$emit('input', value);
        }
      }
    }
</script>
