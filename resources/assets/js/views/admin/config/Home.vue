<template lang="html">
<div class="row">
  <div class="col-md-6 offset-md-3">
    <carta zIndex="499" top="57">

      <template slot="header" >
        <div class="row">

          <div class="col-9">
            Configurações do ERP
          </div>

          <div class="col-md-3 text-right">
            <button type="button" class="btn btn-success btn-sm" :disabled="configs.atualizando" @click="onSubmit">
              <icone icon="gear" />
              Salvar
            </button>
          </div>

        </div>
      </template>

      <div class="row">

        <div class="col-6">
          <switch-erp label="Modulo 'Atendimentos'" :value="configs.modulo_atendimentos" @change="atendimentos_mudar" />
        </div>

        <div class="col-6">
          <switch-erp label="Modulo 'Tickets'" :value="configs.modulo_tickets" @change="tickets_mudar" />
        </div>

        <div class="col-6">
          <switch-erp label="Modulo 'Contas'" :value="configs.modulo_contas" @change="contas_mudar" />
        </div>

        <div class="col-6">
          <switch-erp label="Modulo 'Bancos'" :value="configs.modulo_bancos" @change="bancos_mudar" />
        </div>

        <div class="col-6">
          <switch-erp label="Modulo 'Caixas'" :value="configs.modulo_caixas" @change="caixas_mudar" />
        </div>

        <div class="col-6">
          <switch-erp label="Modulo 'Vendas'" :value="configs.modulo_vendas" @change="vendas_mudar" />
        </div>

        <div class="col-6">
          <switch-erp label="Modulo 'Estoques'" :value="configs.modulo_estoques" @change="estoques_mudar" />
        </div>

        <div class="col-6">
          <switch-erp label="Modulo 'Frotas'" :value="configs.modulo_frotas" @change="frotas_mudar" />
        </div>

      </div>

    </carta>

    <br>

    <carta zIndex="499" top="57">

      <template slot="header" >
        <div class="row">

          <div class="col-9">
            Geral
          </div>

        </div>
      </template>

      <div class="row">

        <div class="col-6">
          <selecionar-imagem id="admin_img" :nome="configs.img_destaque.value" @retornado="retornado_img" />
        </div>

        <div class="col-6">
          <switch-erp label="Usar campo 'Codigo'" :value="configs.field_codigo" @change="field_codigo_mudar" />
        </div>

        <div class="col-6">
          <input-texto v-model="configs.app_name" titulo="Nome do titulo:" />
        </div>

      </div>

    </carta>
  </div>
</div>
</template>

<script>
import Form from '../../../core/Form';

export default {
  data(){
    return {
      atualizando: false,
      configs: new Form({
        naoResete: true,
        modulo_atendimentos: '0',
        modulo_tickets: '0',
        modulo_contas: '0',
        modulo_bancos: '0',
        modulo_caixas: '0',
        modulo_vendas: '0',
        modulo_estoques: '0',
        modulo_frotas: '0',
        field_codigo: '0',
        app_name: 'ERP',
        img_destaque: {
          attachmentable_id: '',
          value: ''
        },
      }),
    }
  },
  methods:{
    onSubmit() {
      var self = this;

      // Confere se é um novo contato pela rota
      this.configs.post(base_url + 'admin/config')
        .then(function(response){
          self.$root.$refs.toastr.s("Configurações salvas com sucesso", "Informativo");

        });
    },
    retornado_img(a){
      this.configs.img_destaque.attachmentable_id = a.attachmentable_id
      this.configs.img_destaque.value = a.name
    },
    field_codigo_mudar(a){
      this.configs.field_codigo = a.value
    },
    atendimentos_mudar(a){
      this.configs.modulo_atendimentos = a.value
    },
    tickets_mudar(a){
      this.configs.modulo_tickets = a.value
    },
    contas_mudar(a){
      this.configs.modulo_contas = a.value
    },
    bancos_mudar(a){
      this.configs.modulo_bancos = a.value
    },
    caixas_mudar(a){
      this.configs.modulo_caixas = a.value
    },
    vendas_mudar(a){
      this.configs.modulo_vendas = a.value
    },
    estoques_mudar(a){
      this.configs.modulo_estoques = a.value
    },
    frotas_mudar(a){
      this.configs.modulo_frotas = a.value
    },
  },
  created(){
    var self = this
    axios.get(base_url + 'admin/config')
      .then(function(response){

        self.configs.app_name = response.data.app_name;

        self.configs.modulo_atendimentos = response.data.modulo_atendimentos.value;
        self.configs.modulo_tickets = response.data.modulo_tickets.value;
        self.configs.modulo_contas = response.data.modulo_contas.value;
        self.configs.modulo_bancos = response.data.modulo_bancos.value;
        self.configs.modulo_caixas = response.data.modulo_caixas.value;
        self.configs.modulo_vendas = response.data.modulo_vendas.value;
        self.configs.modulo_estoques = response.data.modulo_estoques.value;
        self.configs.modulo_frotas = response.data.modulo_frotas.value;

        self.configs.field_codigo = response.data.field_codigo.value;

        self.configs.img_destaque.attachmentable_id = response.data.img_destaque.options;
        self.configs.img_destaque.value = response.data.img_destaque.value;

      })
  }
}
</script>
