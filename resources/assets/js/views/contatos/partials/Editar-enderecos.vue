<template>
  <b-card header="Enderecos">
    <div class="row">

      <div class="col-11">
        <div v-for="(endereco, index) in contato.enderecos">
          <b-card>
            <div class="row">

              <div class="col-1 text-center" v-if="contato.id != null">
                <div class="form-group">
                  <label for="">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label><br>
                  <b-button variant="danger" size="sm" type="button" @click="apagar_endereco(index)" ><icone icon="ban" /></b-button>
                </div>
              </div>

              <div class="col-4">
                <div class="row">

                  <div class="col-6">
                    <selecionar-busca v-model="endereco.tipo" titulo="Tipo" :options="enderecos_tipo"/>
                  </div>

                  <div class="col-6">

                    <div class="row">

                      <div class="col-8">
                        <input-mascara v-model="endereco.cep" titulo="CEP"  :mascara="cep_mascara" />
                      </div>

                      <div class="col-4">
                        <label>Consultar</label>
                        <b-button type="button" variant="info" @click="consultarCep(index)"><icone icon="search" /></b-button>
                      </div>

                    </div>

                  </div>

                </div>
              </div>

            </div>

            <div class="row">

              <div class="col-7">
                <input-texto v-model="endereco.endereco" titulo="Endereço" :id="'endereco' + index" />
              </div>

              <div class="col-2">
                <input-texto v-model="endereco.numero"  titulo="Numero" />
              </div>

              <div class="col-3">
                <input-texto v-model="endereco.complemento"  titulo="Complemento" />
              </div>

            </div>

            <div class="row">

              <div class="col-4">
                <input-texto v-model="endereco.bairro" :id="'bairro' + index" titulo="Bairro" />
              </div>

              <div class="col-4">
                <input-texto v-model="endereco.cidade" :id="'cidade' + index" titulo="Cidade" />
              </div>

              <div class="col-2">
                <input-texto v-model="endereco.uf" titulo="UF" :id="'uf' + index" :disabled="consultando_cep" />
              </div>

            </div>
          </b-card>
          <br>
        </div>
      </div>

      <div class="col-1" >
        <div v-sticky="{ zIndex: 500, stickyTop: 150 }">
          <b-button variant="success" type="button" @click="adicionar_endereco"><icone icon="plus" /></b-button>
          <b-button variant="danger" type="button" @click="remover_endereco"><icone icon="minus" /></b-button>
        </div>
      </div>

    </div>
  </b-card>
</template>

<script>
  import VueSticky from 'vue-sticky';
    export default {
      directives:{
        'sticky': VueSticky,
      },
      props: {
        contato: {type: Object}
      },
      data(){
        return {
          consultando_cep: false,
          cep_mascara: "##.###-###",
          enderecos_tipo: [
            {value: 'Correspondencia', label: 'Correspondencia'},
            {value: 'Faturamento', label: 'Faturamento'},
            {value: 'Entrega', label: 'Entrega'},
            {value: 'Comercial', label: 'Comercial'},
            {value: 'Residencia', label: 'Residencia'},
            {value: 'Outro', label: 'Outro'},
          ],
        }
      },
      methods: {
        consultarCep(index){
          if(this.contato.enderecos[index].cep.split('.').join("").split('_').length == 1) {

            var self = this;
            $('#bairro' + index).prop('disabled', true);
            $('#cidade' + index).prop('disabled', true);
            $('#uf' + index).prop('disabled', true);
            $('#endereco' + index).prop('disabled', true);
            var cep = [this.contato.enderecos[index].cep.slice(0, 5), '-', this.contato.enderecos[index].cep.slice(5)].join('');
            console.log (cep);
            axios.get(base_url + '/busca/cep/' + cep)
              .then(function(response){
                console.log(response.data);
                if (response.data==""){
                  self.$root.$refs.toastr.w("Este CEP não foi encontrado", "Erro");

                } else {
                  self.contato.enderecos[index].bairro = response.data.bairro;
                  $('#bairro' + index).val(self.contato.enderecos[index].bairro);
                  self.contato.enderecos[index].cidade = response.data.cidade;
                  $('#cidade' + index).val(self.contato.enderecos[index].cidade);
                  self.contato.enderecos[index].uf = response.data.uf;
                  $('#uf' + index).val(self.contato.enderecos[index].uf);
                  self.contato.enderecos[index].endereco = response.data.tp_logradouro + " " + response.data.logradouro;
                  $('#endereco' + index).val(self.contato.enderecos[index].endereco);

                  self.$root.$refs.toastr.i("Achei o CEP, e coloquei nos campos", "Informativo");
                }

                $('#bairro' + index).prop('disabled', false);
                $('#cidade' + index).prop('disabled', false);
                $('#uf' + index).prop('disabled', false);
                $('#endereco' + index).prop('disabled', false);
              });
          } else {
            self.$root.$refs.toastr.w("Preencha o CEP corretamente", "Erro");

          }
        },
        apagar_endereco(index){
          var self = this;
          axios.get(base_url + 'lista/contatos/enderecos/' + self.contato.enderecos[index].id + '/delete')
            .then(function(response){
              self.$root.$refs.toastr.i("Apagado endereço do contato", "Aviso");
              self.contato.enderecos.splice(index, 1);
            })
        },
        adicionar_endereco(){
          // é importante colocar a estrutura aqui.
          // - artur
          this.contato.enderecos.push({ tipo: '', cep: '', endereco: '', numero: '', complemento: '', bairro: '', cidade: '', uf: '', });
        },
        remover_endereco(){
          if (this.contato.enderecos[this.contato.enderecos.length - 1].id == null) {
            this.contato.enderecos.splice(-1,1);
          } else {
            this.$root.$refs.toastr.w("Use o botão apagar para remover o endereço", "Erro");
          }
        },
      }
    }
</script>
