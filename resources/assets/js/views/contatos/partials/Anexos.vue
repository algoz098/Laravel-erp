<template>
<div>

  <strong>Anexos</strong>

  <div class="row">
    <div class="col-8">

      <object :data="url" id="objetoAnexos1" width="100%" :height="height + 'px'" />

    </div>
    <div class="col-4">

      <b-card class="text-center">
        <b-button variant="success">Novo anexo</b-button>
      </b-card>

      <b-card>

        <div class="col-6 pull-left">
          <b-button variant="outline-info" @click="imagemFull" :disabled="id_selecionado==0"><icone icon="search-plus" /></b-button>
          <b-button variant="outline-info" @click="rotacionar('unclock')" :disabled="id_selecionado==0"><icone icon="arrow-left" /></b-button>
          <b-button variant="outline-info" @click="rotacionar('clock')" :disabled="id_selecionado==0"><icone icon="arrow-right" /></b-button>
        </div>

        <div class="col-6 pull-right">
          <b-input-group>

            <b-form-input v-model="width" placeholder="Diminuir largura" type="number" />
            <b-input-group-button slot="right">
              <b-button variant="outline-info" @click="mudar_largura('clock')" :disabled="width =='' || id_selecionado==0"><icone icon="text-width" /></b-button>
            </b-input-group-button>

          </b-input-group>
        </div>

      </b-card>

      <b-card class="lista-anexos">
        <div class="row" v-for="(attach, index) in contato.attachs_too" :class="{'bg-faded': attach.id==id_selecionado}">

          <div class="col">
            <b-button size="sm" variant="outline-success" disabled>Nome: {{attach.name}}</b-button>
          </div>

          <div class="col text-right">
            <b-button size="sm" variant="info" @click="verAnexo(attach.id)"><icone icon="eye" /></b-button>
            <b-button size="sm" variant="info" @click="downloadAnexo(attach.id)"><icone icon="download" /></b-button>
            <b-button size="sm" variant="danger" @click="apagarAnexo(attach.id, index)"><icone icon="ban" /></b-button>
          </div>

        </div>
      </b-card>

    </div>
  </div>

</div>
</template>

<script>
    export default {
      props: {
        contato: {
          type: Object,
          default: function() { return {} }
        }
      },
      data() {
        return {
          url: '',
          width: '',
          id_selecionado: 0,
          height: '1'
        }
      },
      methods: {
        mudar_largura(){
          var self = this;
          axios.get(base_url + 'attach/' + self.id_selecionado + '/resize/' + self.width)
            .then(function(response){
              self.$root.$refs.toastr.i("O anexo foi redimencionado no servidor", "Redimencionado!");
              if (self.url == base_url + 'attach/' + self.id_selecionado + '/resize/' + self.width){
                self.url = base_url + 'attach/' + self.id_selecionado + '/size/' + self.height;
              } else {
                self.url = base_url + 'attach/' + self.id_selecionado + '/resize/' + self.height;
              }
            })
        },
        rotacionar(direcao) {
          var self = this;
          axios.get(base_url + 'attach/' + self.id_selecionado + '/rotate/' + direcao)
            .then(function(response){
              self.$root.$refs.toastr.i("O anexo foi rotacionado no servidor", "Rotacionado!");
              if (self.url == base_url + 'attach/' + self.id_selecionado + '/rotate/' + direcao ){
                self.url = base_url + 'attach/' + self.id_selecionado + '/size/' + self.height;
              } else {
                self.url = base_url + 'attach/' + self.id_selecionado + '/rotate/clock';
              }
            })
        },
        imagemFull() {
          this.url = base_url + 'attach/' + this.id_selecionado;
        },
        verAnexo(id){
          this.id_selecionado = id;
          this.height = window.innerHeight-340;
          if (this.url==''){
            this.$root.$emit('collapse::toggle', 'ferramentas_imagem');
          }
          // this.url = base_url + 'attach/' + id + '/size/' + this.height;
          this.url = base_url + 'attach/' + id + '/size/' + this.height;
        },
        downloadAnexo(id) {
          var self = this;
          window.location.href = base_url + 'attach/' + id + '/get';
          axios.get(base_url + 'attach/' + id + '/get')
            .then(function(response){
              self.$root.$refs.toastr.i("Seu anexo foi enviado", "Achei!");
            })
            .catch(function(error){
              self.$root.$refs.toastr.e("Algo de errado com o anexo.", "Erro " + error.response.status +"!");
            })
        },
        apagarAnexo(id, index){
          var self = this;
          this.id_selecionado = 0;
          axios.get(base_url + 'attach/' + id + '/delete')
            .then(function(response, index){
              self.$root.$refs.toastr.w("Anexo foi apagado", "Aviso!");
              self.contato.attachs_too.splice(index, 1);
            })
            .catch(function(error){
              self.$root.$refs.toastr.e("Algo de errado, a operação falhou.", "Erro " + error.response.status +"!");
            })
        }
      }
    }
</script>
