<template>

  <b-card header="Telefones e e-mails">
    <div class="row">

      <div class="col-11">
        <b-card v-for="(telefone, index) in contato.telefones" :key="index">
          <div class="row">

            <div class="col-1 text-center" v-if="telefone.id">
              <div class="form-group">
                <label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label><br>
                <b-button variant="danger" size="sm" type="button" @click="apagar_telefone(index)" ><icone icon="ban" /></b-button>
              </div>
            </div>

            <div class="col-2">
              <selecionar-busca v-model="telefone.tipo" titulo="Tipo" @input="mudar_mascara(index)" :options="tipos"/>
            </div>

            <div class="col-2">
              <input-mascara placeholder="" v-model="telefone.numero" titulo="Numero/E-mail" :mascara="telefone.mascara" />
            </div>

            <div class="col-2">
              <input-texto v-model="telefone.contato" titulo="Contato" />
            </div>

            <div class="col-2">
              <input-texto v-model="telefone.setor" titulo="Setor/Depto" />
            </div>

            <div class="col-2">
              <input-texto v-model="telefone.ramal" titulo="Ramal" />
            </div>

          </div>
        </b-card>
      </div>

      <div class="col-1" >
        <div v-sticky="{ zIndex: 500, stickyTop: 150 }">
          <b-button variant="success" type="button" @click="adicionar_telefone"><icone icon="plus" /></b-button>
          <b-button variant="danger" type="button" @click="remover_telefone"><icone icon="minus" /></b-button>
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
        contato: {type: Object},
      },
      data(){
        return {
          combo: '',
          tipos: [],
        }
      },
      mounted(){
        var self = this;
        axios.get(base_url + 'lista/combobox/Telefones')
          .then(function(response){
            self.combo = response.data;
            var i = 0;
            for(i=0; i < self.combo.length; i++){
              //Eu sei que o codigo ta feio, mas se eu separasse e deixasse com varias variaveis, legivel e lindo, buga.
              //java ne? é eu sei, uma merda.
              // - artur
              self.tipos.push({value: self.combo[i].text, label: self.combo[i].text});
            }

            // Se for edicao de contato, aplica a mascara em cada telefone ja guardado
            if (self.contato.id != null) {
              var i = 0;
              for(i=0; i < self.contato.telefones.length; i++){
                self.mudar_mascara(i);
              }
            }

          });
      },
      methods: {
        apagar_telefone(index){
          var self = this;
          axios.get(base_url + 'lista/contatos/' + self.contato.id + '/telefones/' + self.contato.telefones[index].id + '/delete')
            .then(function(response){
              self.contato.telefones.splice(index, 1);
              this.$root.$refs.toastr.i("Apagado telefone do contato", "Aviso");
            })
        },
        mudar_mascara(index){
          var i = 0;
          for(i=0; i < this.combo.length; i++){
            //Filtra atravez dos tipos, seleciona aquele que é igual entre as opçẽos do combo e do selecionado, e retorna na mascara a mascara condizente
            // - artur
            if (this.combo[i].text==this.contato.telefones[index].tipo){
              if(this.combo[i].field==''){
                this.contato.telefones[index].mascarado = false;
              } else {
                this.contato.telefones[index].mascarado = true;
                this.contato.telefones[index].mascara = this.combo[i].field;
              }

            }
          }
        },
        adicionar_telefone(){
          // é importante colocar a estrutura aqui.
          // - artur
          this.contato.telefones.push({ tipo: '', numero: '', contato: '', setor: '', ramal: '', mascara: '' });
        },
        remover_telefone(){
          if (this.contato.telefones[this.contato.telefones.length - 1].id == null) {
            this.contato.telefones.splice(-1,1);
          } else {
            this.$root.$refs.toastr.w("Use o botão apagar para remover o telefone", "Erro");
          }
        },
      }
    }
</script>
