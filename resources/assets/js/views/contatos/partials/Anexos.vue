<template>
<div>

  <strong>Anexos</strong>

  <div class="row">
    <div class="col-8">

      <dropzone id="anexosUpload" ref="anexosUpload" :url="upload" useFontAwesome vdropzone-success="console.log('as')" v-if="upload && anexo.id==0" @vdropzone-success="arquivoUpload" @vdropzone-queue-complete="limparUpload" :language="upload_language" >
        <input type="hidden" name="_token" :value="token">
      </dropzone>

      <object :data="url" id="objetoAnexos1" width="100%" :height="height + 'px'" v-if="anexo.id!=0"/>

    </div>
    <div class="col-4">

      <b-card>

        <div class="col-6 text-left pull-left">
          <b-button type="button" variant="success" @click="mostrar_upload">Novo anexo</b-button>
        </div>

        <div class="col-6 text-right pull-right">
          <b-input-group v-if="anexo.id">

            <b-form-input v-model="anexo.name" />
            <b-input-group-button slot="right">
              <b-button type="button" variant="info" @click="salvar_nome" :disabled="anexo.id==0"><icone icon="pencil" /></b-button>
            </b-input-group-button>

          </b-input-group>
        </div>

      </b-card>

      <b-card>

        <div class="col-6 pull-left">
          <b-button type="button" variant="outline-info" @click="imagemFull" :disabled="anexo.id==0"><icone icon="search-plus" /></b-button>
          <b-button type="button" variant="outline-info" @click="rotacionar('unclock')" :disabled="anexo.id==0"><icone icon="arrow-left" /></b-button>
          <b-button type="button" variant="outline-info" @click="rotacionar('clock')" :disabled="anexo.id==0"><icone icon="arrow-right" /></b-button>
        </div>

        <div class="col-6 pull-right">
          <b-input-group>

            <b-form-input v-model="width" placeholder="Diminuir largura" type="number" />
            <b-input-group-button slot="right">
              <b-button type="button" variant="outline-info" @click="mudar_largura('clock')" :disabled="width =='' || anexo.id==0"><icone icon="text-width" /></b-button>
            </b-input-group-button>

          </b-input-group>
        </div>

      </b-card>

      <b-card class="lista-anexos">
        <div class="row" v-for="(attach, index) in contato.attachs_too" :class="{'bg-faded': attach.id==anexo.id}">

          <div class="col">
            <b-button type="button" size="sm" variant="outline-success" disabled>Nome: {{attach.name | truncate }}</b-button>
          </div>

          <div class="col text-right">
            <b-button type="button" size="sm" variant="info" @click="verAnexo(attach.id, attach.name, index)"><icone icon="eye" /></b-button>
            <b-button type="button" size="sm" variant="info" @click="downloadAnexo(attach.id)"><icone icon="download" /></b-button>
            <b-button type="button" size="sm" variant="danger" @click="apagarAnexo(attach.id, index)"><icone icon="ban" /></b-button>
          </div>

        </div>
      </b-card>

    </div>
  </div>

</div>
</template>

<script>
import Form from '../../../core/Form';
import Dropzone from 'vue2-dropzone';
    export default {
      props: {
        contato: {
          type: Object,
          default: function() { return {} }
        },
        upload: ""
      },
      data() {
        return {
          upload_language:{
            dictDefaultMessage: '<br>Solte arquivos aqui, ou clique para fazer upload',
            dictCancelUpload: 'Cancelar upload',
            dictCancelUploadConfirmation: 'Tem certeza que quer cancelar o upload?',
            dictFallbackMessage: 'Seu navegador nao suporta este upload, use o botão.',
            dictFallbackText: 'Por favor use o formulario abaixo para fazer o upload.',
            dictFileTooBig: 'Arquivo muito grande, ({{filesize}}MiB). Tamanha maximo: {{maxFilesize}}MiB.',
            dictInvalidFileType: `Você nao pode fazer upload de arquivos deste tipo.`,
            dictMaxFilesExceeded: 'Limite de arquivos alcançado. (max: {{maxFiles}})',
            dictRemoveFile: 'Remover',
            dictRemoveFileConfirmation: null,
            dictResponseError: 'Servidor respondeu com codigo {{statusCode}}.',
          },
          url: '',
          width: '',
          anexo: new Form({
            naoResete: true,
            id: 0,
            index: 0,
            name: '',
          }),
          height: '1',
          token: window.token
        }
      },
      filters: {
        truncate: function(string) {
          return string.substring(0, 20) + '...';
        }
      },
      methods: {
        mostrar_upload(){
          this.anexo.id = 0;
        },
        arquivoUpload(e) {
          this.$emit('uploaded', e.xhr.response);
        },
        salvar_nome() {
          var self = this;
          this.anexo.post(base_url + 'attach/nome/' + self.anexo.id)
            .then(function(response){
              self.$root.$refs.toastr.i("O anexo foi renomeado no servidor", "Renomeado!");
              self.contato.attachs_too[self.anexo.index].name = self.anexo.name;
            });
        },
        limparUpload() {
          this.$refs.anexosUpload.removeAllFiles();
        },
        mudar_largura(){
          var self = this;
          axios.get(base_url + 'attach/' + self.anexo.id + '/resize/' + self.width)
            .then(function(response){
              self.$root.$refs.toastr.i("O anexo foi redimencionado no servidor", "Redimencionado!");
              if (self.url == base_url + 'attach/' + self.anexo.id + '/resize/' + self.width){
                self.url = base_url + 'attach/' + self.anexo.id + '/size/' + self.height;
              } else {
                self.url = base_url + 'attach/' + self.anexo.id + '/resize/' + self.height;
              }
            })
        },
        rotacionar(direcao) {
          var self = this;
          axios.get(base_url + 'attach/' + self.anexo.id + '/rotate/' + direcao)
            .then(function(response){
              self.$root.$refs.toastr.i("O anexo foi rotacionado no servidor", "Rotacionado!");
              if (self.url == base_url + 'attach/' + self.anexo.id + '/rotate/' + direcao ){
                self.url = base_url + 'attach/' + self.anexo.id + '/size/' + self.height;
              } else {
                self.url = base_url + 'attach/' + self.anexo.id + '/rotate/clock';
              }
            })
        },
        imagemFull() {
          this.url = base_url + 'attach/' + this.anexo.id;
        },
        verAnexo(id, nome, index){
          this.anexo.id = id;
          this.anexo.name = nome;
          this.anexo.index = index;
          this.height = window.innerHeight-340;
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
          console.log('id: ' + id + ", index: " + index);
          self.anexo.index = index;

          axios.get(base_url + 'attach/' + id + '/delete')
            .then(function(response, index){
              self.$root.$refs.toastr.w("Anexo foi apagado", "Aviso!");
              self.contato.attachs_too.splice(self.anexo.index, 1);
              console.log("index: " + self.anexo.index);
              self.anexo.id = 0;

            })
            .catch(function(error){
              self.$root.$refs.toastr.e("Algo de errado, a operação falhou.", "Erro " + error.response.status +"!");
            })
        }
      }
    }
</script>
