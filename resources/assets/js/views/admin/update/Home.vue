<template lang="html">
<div class="row">
  <div class="col-md-4 offset-md-4">
    <carta zIndex="499" top="7">

      <template slot="header" >
        <div class="row">

          <div class="col-9">
            Atualização do ERP
          </div>

          <div class="col-md-3">
            <button type="button" class="btn btn-warning btn-sm" :disabled="atualizando" v-if="disponivel" @click="atualizar_erp">
              <icone icon="gear" />
              Atualizar
            </button>
          </div>

        </div>
      </template>

      <div class="row">

        <div class="col-6">
          <strong> Versão atual</strong><br>
          {{manifest.data}}<br>
          {{manifest.versao}}
        </div>

        <div class="col-6">
          <strong> Ultima versão</strong><br>
          {{remoto.data}}<br>
          {{remoto.versao}}
        </div>

      </div>

    </carta>
  </div>
</div>
</template>

<script>
export default {
  data(){
    return {
      disponivel: false,
      atualizando: false,
      manifest:{
        versao: '',
        data: '',
      },
      remoto:{
        versao: '',
        data: '',
      }
    }
  },
  methods:{
    atualizar_erp(){
      this.atualizando = true

      var self = this
      axios.get(base_url + 'admin/update/do')
        .then(function(response){
          self.$root.$refs.toastr.s("O ERP foi atualizado.", "Sucesso!");

          self.atualizando = false

          this.created()
        })
    }
  },
  created(){
    var self = this
    axios.get(base_url + 'admin/update')
      .then(function(response){
        self.manifest.versao = response.data.manifest.versao
        self.manifest.data = response.data.manifest.data
        self.remoto.versao = response.data.remoto.versao
        self.remoto.data = response.data.remoto.data

        if(self.manifest.versao < self.remoto.versao){
          self.disponivel = true
        }
      })
  }
}
</script>
