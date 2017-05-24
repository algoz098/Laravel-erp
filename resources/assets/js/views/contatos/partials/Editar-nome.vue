<template>
<div class="row">
  <div class="col-3">
    <b-card header="Sobre">

      <selecionar-busca v-model="contato.tipo" titulo="Tipo" :erros="contato.errors.errors.tipo" :options="tipos" v-if="edicao==false" />

      <div class="form-group" v-if="edicao==true">
        <label for="">Tipo:</label>
        <span class="form-control" v-if="contato.tipo==0">Empresa</span>
        <span class="form-control" v-else-if="contato.tipo==1">Pessoa fisica</span>
        <span class="form-control" v-else>Funcionario</span>

      </div>

      <input-texto v-model="contato.nome" :titulo="labels[contato.tipo].nome" :erros="contato.errors.errors.nome" />
      <input-texto v-model="contato.sobrenome" :titulo="labels[contato.tipo].sobrenome" :erros="contato.errors.errors.sobrenome" />

    </b-card>
  </div>

  <div class="col-3">
    <b-card header="Documentos">

      <input-mascara v-model="contato.cpf" :titulo="labels[contato.tipo].cpf.label" :erros="contato.errors.errors.cpf" :mascara="labels[contato.tipo].cpf.mascara" />
      <input-mascara v-model="contato.rg" :titulo="labels[contato.tipo].rg.label" :erros="contato.errors.errors.rg" :mascara="labels[contato.tipo].rg.mascara" />
      <input-texto v-model="contato.cod_prefeitura" :titulo="labels[contato.tipo].cod_prefeitura" :erros="contato.errors.errors.cod_prefeitura" />
      <input-mascara v-model="contato.nascimento" :titulo="labels[contato.tipo].nascimento.label" :erros="contato.errors.errors.nascimento" :mascara="labels[contato.tipo].nascimento.mascara"  v-if="contato.tipo!='0'"/>

    </b-card>
  </div>

  <div class="offset-3 col-3 ">
    <b-card header="Interno">

      <switch-erp label="Dados validos?" :value="contato.active" @change="dados_validos_mudar" />

      <div class="custom-controls-stacked">
        <label class="custom-control custom-radio">
          <input type="radio" class="custom-control-input" value="1" v-model="contato.sociabilidade">
          <span class="custom-control-indicator"></span>
          <span class="custom-control-description"><icone icon="signal" level="1" /></span>
        </label>
        <label class="custom-control custom-radio">
          <input type="radio" class="custom-control-input" value="2" v-model="contato.sociabilidade">
          <span class="custom-control-indicator"></span>
          <span class="custom-control-description"><icone icon="signal" level="2" /></span>
        </label>
        <label class="custom-control custom-radio">
          <input type="radio" class="custom-control-input" value="3" v-model="contato.sociabilidade">
          <span class="custom-control-indicator"></span>
          <span class="custom-control-description"><icone icon="signal" level="3" /></span>
        </label>
        <label class="custom-control custom-radio">
          <input type="radio" class="custom-control-input" value="4" v-model="contato.sociabilidade">
          <span class="custom-control-indicator"></span>
          <span class="custom-control-description"><icone icon="signal" level="4" /></span>
        </label>
        <label class="custom-control custom-radio">
          <input type="radio" class="custom-control-input" value="5" v-model="contato.sociabilidade">
          <span class="custom-control-indicator"></span>
          <span class="custom-control-description"><icone icon="signal" level="5" /></span>
        </label>
      </div>

      <switch-erp label="É filial?" :value="contato.tipo_filial" @change="e_filial_mudar" v-if="contato.tipo==0" />

    </b-card>
  </div>
</div>
</template>

<script>
    export default {
      props: {
        contato: {type: Object},
      },
      data(){
        return {
          e_funcionario: false,
          edicao: false,
          tipos: [
            {value: '0', label: 'PJ - Pessoa Juridica'},
            {value: '1', label: 'PF - Pessoa Fisica'}
          ],
          labels:{
            1: {
              nome: 'Nome',
              sobrenome: 'Sobrenome',
              cpf: {
                label: 'CPF',
                mascara: "XXX.XXXX.XXX-XX"
              },
              rg: {
                label: 'RG',
                mascara: "##.###.###-##"
              },
              cod_prefeitura: 'Codigo de autonomo',
              nascimento: {
                label: 'Data de nascimento',
                mascara: "##/##/##"
              }
            },
            0: {
              nome: 'Razão social',
              sobrenome: 'Nome Fantasia',
              cpf: {
                label: 'CNPJ',
                mascara: "##.###.###/####-##"
              },
              rg: {
                label: 'Inscrição Estadual',
                mascara: "###.###.###.###"
              },
              cod_prefeitura: 'Insc. da prefeitura',
              nascimento: {
                label: 'Data de nascimento',
                mascara: "##/##/##"
              },

            }
          }
        }
      },
      created(){
        if (this.$route.fullpath == "/novo/funcionario") {
          this.e_funcionario = true;
          this.edicao = true;
          this.tipos = [{value: '2', label: 'PF - Funcionario'}];
        }
        if (this.$route.name == "contato_editar") {
          this.edicao = true;
        }
      },
      methods: {
        onInput(value) {
          this.$emit('input', value);
        },
        dados_validos_mudar(e){
          this.contato.active = e.value;
        },
        e_filial_mudar(e){
          this.contato.tipo_filial = e.value;
        }
      }
    }
</script>
