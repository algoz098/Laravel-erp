<template>
<div class="row">

  <div class="col-3">
    <b-card header="Informações basicas">

      <selecionar-contato :nome="conta.contato.nome" @retornado_contato="retornado_contato" />

      <selecionar-busca v-model="conta.tipo" titulo="Tipo:" :erros="conta.errors.errors.tipo" :options="tipos" v-if="edicao==false" />

      <selecionar-busca v-model="conta.nome" titulo="Referencia:" :erros="conta.errors.errors.nome" :options="referencias" />

    </b-card>
  </div>

  <div class="col-3">
    <b-card header="Pagamentos e valores">

      <input-mascara v-model="conta.vencimento" titulo="Vencimento:" :erros="conta.errors.errors.vencimento" mascara="##/##/####" />

      <input-dinheiro v-model="conta.valor" titulo="Valor Cheio:" />

      <input-dinheiro v-model="conta.desconto" titulo="Desconto:" />

    </b-card>
  </div>

  <div class="col-3">
    <b-card header="Detalhes">

      <input-texto v-model="conta.dm" titulo="D.M. - Num. Documento:" :erros="conta.errors.errors.dm" />

    </b-card>
  </div>

</div>
</template>

<script>
    export default {
      props: {
        conta: {type: Object},
      },
      data(){
        return {
          false: true,
          edicao: false,
          contato: '',
          referencias: [
            {value: '', label: '- Escolha - '},
          ],
          tipos: [
            {value: '0', label: 'Provisionamento de conta'},
            {value: '1', label: 'Provisionamento de recebimento'}
          ],
        }
      },
      created(){
        var self = this;
        axios.get(base_url + 'lista/combobox/contas')
          .then(function(response){
            console.log(response);
            for (var i = 0; i < response.data.length; i++) {
              self.referencias.push({value: response.data[i].value, label: response.data[i].value});
            }
          });


      },
      methods: {
        retornado_contato(a){
          this.conta.contato.nome = a.nome;
          this.conta.contatos_id = a.id;
        },
        onInput(value) {
          this.$emit('input', value);
        }
      }
    }
</script>
