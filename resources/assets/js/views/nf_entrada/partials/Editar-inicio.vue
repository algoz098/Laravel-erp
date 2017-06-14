<template>
<div>

  <div class="row">
    <div class="col-6 offset-md-3">

      <carta zIndex="499" top="136">

        <template slot="header" >
          Informações basicas da NF
        </template>

        <div class="row">

          <div class="col-4">
            <selecionar-filial :nome="nf.filial.nome" @retornado_filial="retornado_filial" />
          </div>

        </div>
        <div class="row">

          <div class="col-4">
            <selecionar-contato id="fornecedor_id" titulo="Selecionar fornecedor:" :erros="nf.errors.errors.contatos_id" :nome="nf.fornecedor.nome" @retornado_contato="retornado_fornecedor" />
          </div>

        </div>
        <div class="row">

          <div class="col-4">
            <input-texto v-model="nf.numero" titulo="Numero da NF:" />
          </div>

        </div>
        <div class="row">

          <div class="col-4">
            <input-dinheiro v-model="nf.total" titulo="Total da NF:" />
          </div>

        </div>

      </carta>

    </div>
  </div>

  <br>

  <div class="row">
    <div class="col-4 offset-md-4">

      <carta zIndex="499" top="136">

        <template slot="header" >
          Informações gerais da NF
        </template>

        <div class="row">

          <div class="col-md-6">
            <input-dinheiro v-model="nf.frete" titulo="Frete da NF:" />
          </div>

          <div class="col-md-6">
            <input-dinheiro v-model="nf.transportadora" titulo="Transportadora:" />
          </div>

        </div>
        <div class="row">

          <div class="col-md-6">
            <input-dinheiro v-model="nf.seguro" titulo="Seguro/Dep:" />
          </div>

          <div class="col-md-6">
            <input-dinheiro v-model="nf.icms_substituicao" titulo="ICMS Substituição:" />
          </div>

        </div>
        <div class="row">

          <div class="col-md-6">
            <input-dinheiro v-model="nf.acrescimo" titulo="Acrescimo:" />
          </div>

          <div class="col-md-6">
            <input-dinheiro v-model="nf.desconto" titulo="Desconto:" />
          </div>

        </div>

      </carta>

    </div>
  </div>

  <br>

  <div class="row">

    <div class="col-12">

      <carta zIndex="499" top="136">

        <template slot="header" >

          <div class="row">

             <div class="col-9">
               Itens da NF
             </div>

             <div class="col-3 flex-last text-right">
               <button type="button" class="btn btn-success btn-sm" @click="adicionar_item"><icone icon="plus" /></button>
               <button type="button" class="btn btn-danger btn-sm" @click="remover_item"><icone icon="minus" /></button>
             </div>

          </div>

        </template>

        <table  class="table">
          <thead>
            <th>#</th>
            <th></th>
            <th>Produto</th>
            <th>NCM</th>
            <th>Tipo</th>
            <th>Qde</th>
            <th>VLR Unit.</th>
            <th>ICMS</th>
            <th>IPI</th>
            <th>VLR Tot</th>
            <th>ICMS Tot</th>
            <th>IPI Tot</th>
          </thead>
          <tbody>
            <tr v-for="(produto, index) in nf.produtos">
              <th scope="row">{{index}}</th>

              <td >
                <div v-if="produto.id">
                  <button type="button" class="btn btn-danger btn-sm" @click="apagar_item(produto.id, index)">
                    <icone icon="ban" />
                  </button>
                </div>
              </td>

              <td>
                <selecionar-produto portitulo=false size="sm" :nome="produto.nome" @retornado="retornado_item(index, $event)" :id="'produto_id' + index" />
              </td>

              <td>
                <input-texto v-model="produto.ncm" size="sm" titulo=false />
              </td>

              <td>
                <selecionar-busca v-model="produto.tipo" size="sm" titulo=false :options="opcoes.produtos"/>
              </td>

              <td>
                <input-texto v-model="produto.quantidade" size="sm" titulo=false />
              </td>

              <td>
                <input-dinheiro addon=false v-model="produto.valor" size="sm" titulo=false />
              </td>

              <td>
                <input-percentual addon=false v-model="produto.icms" size="sm" titulo=false />
              </td>

              <td>
                <input-percentual addon=false v-model="produto.ipi" size="sm" titulo=false />
              </td>

              <td>
                <input-dinheiro addon=false disabled=true v-model="produto.total" size="sm" titulo=false />
              </td>

              <td>
                <input-dinheiro addon=false disabled=true v-model="produto.total_icms" size="sm" titulo=false />
              </td>

              <td>
                <input-dinheiro addon=false disabled=true v-model="produto.total_ipi" size="sm" titulo=false />
              </td>

            </tr>
            <tr>

              <td colspan="9"></td>

              <td>

                <!--
                  Para o valor computed seja calculado, precisa ser printado.
                  mas deixe-o em display: none para não causar confusão

                  -artur
               -->
               <span style="display:none">{{valor_total}}</span>

                <input-dinheiro addon=false disabled=true v-model="nf.total_produtos" size="sm" titulo='Tot Prod' />
              </td>

              <td>
                <input-dinheiro addon=false disabled=true v-model="nf.total_icms" size="sm" titulo='Tot ICMS' />
              </td>

              <td>
                <input-dinheiro addon=false disabled=true v-model="nf.total_ipi" size="sm" titulo='Tot IPI' />
              </td>

            </tr>
          </tbody>
        </table>

      </carta>

    </div>

  </div>

  <br>

  <div class="row">

    <div class="col-6 offset-md-3">

      <carta zIndex="499" top="136">

        <template slot="header" >Observaçẽos da NF</template>

        <input-editor v-model="nf.obs" />


      </carta>

    </div>

  </div>

</div>
</template>

<script>
import VueSticky from 'vue-sticky';

    export default {
      directives:{
        'sticky': VueSticky,
      },
      props: {
        nf: {type: Object},
      },
      data(){
        return {
          false: true,
          edicao: false,
          opcoes: {
            produtos: [
              {value: '', label: '- Escolha - '},
              {value: 'Conjunto', label: 'Conj'},
              {value: 'Fardo', label: 'Frd'},
              {value: 'Jogo', label: 'Jg'},
              {value: 'Kilograma', label: 'Kg'},
              {value: 'Kit', label: 'Kit'},
              {value: 'Litros', label: 'Lts'},
              {value: 'Peça', label: 'Pc'},
              {value: 'Unidade', label: 'Unid'},
            ]
          }
        }
      },
      computed:{
        valor_total(){

          //Passa por todos os produtos somando cada um
          // IPI, VALOR e icms_total
          // - artur
          for (var i = 0; i < this.nf.produtos.length; i++) {
            this.nf.produtos[i].total = this.nf.produtos[i].quantidade * this.nf.produtos[i].valor
            this.nf.produtos[i].total_ipi = this.nf.produtos[i].total * this.nf.produtos[i].ipi/100
            this.nf.produtos[i].total_icms = this.nf.produtos[i].total * this.nf.produtos[i].icms/100
          }

          // Passa novamente pelos produtos agora fazendo o TOTAL de tudo
          // - artur
          var total_prod = 0
          var total_ipi = 0
          var total_icms = 0
          for (var i = 0; i < this.nf.produtos.length; i++) {
            total_prod = total_prod + this.nf.produtos[i].total;
            total_ipi = total_ipi + this.nf.produtos[i].total_ipi;
            total_icms = total_icms + this.nf.produtos[i].total_icms;
          }

          this.nf.total_ipi = total_ipi
          this.nf.total_icms = total_icms
          this.nf.total_produtos = total_prod

          return total_prod
        }
      },
      created(){

      },
      methods: {
        retornado_item(index, a){
          this.nf.produtos[index].nome = a.nome;
          this.nf.produtos[index].produtos_id = a.id;
        },
        adicionar_item(){
          this.nf.produtos.push({
            produtos_id: '',
            nome: '',
            ncm: '',
            tipo: '',
            quantidade: '',
            valor: '',
            icms: '',
            ipi: '',
            total: '',
            total_ipi: '',
            total_icms: '',
          });
        },
        remover_item(){
          if (this.nf.produtos[this.nf.produtos.length - 1].id == null) {
            this.nf.produtos.splice(-1, 1);
          } else {
            this.$root.$refs.toastr.w("Use o botão apagar para remover o item", "Erro");
          }
        },
        retornado_filial(a){
          this.nf.filial.nome = a.nome;
          this.nf.filiais_id = a.id;
        },
        retornado_fornecedor(a){
          this.nf.fornecedor.nome = a.nome;
          this.nf.contatos_id = a.id;
        },
        apagar_externo(index){
          var self = this;
          axios.get(base_url + 'lista/produtos/' + self.produto.id + '/externo/' + self.produto.externos[index].id + '/delete')
            .then(function(response){
              self.produto.externos.splice(index, 1);
              self.$root.$refs.toastr.i("Removido produto externo", "Aviso");
            })
        },
        onInput(value) {
          this.$emit('input', value);
        }
      }
    }
</script>
