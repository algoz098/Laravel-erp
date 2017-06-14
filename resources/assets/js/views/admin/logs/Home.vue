<template lang="html">
<div class="row">

  <div class="col-2 flex-last">
    <carta zIndex="499" top="57">

      <template slot="header" >
        <div class="row">

          <div class="col-9">
            Arquivos de LOG
          </div>

        </div>
      </template>

      <ul class="list-unstyled">
        <li v-for="log in logs">
          {{log}}
          <button type="button" class="btn btn-sm btn-outline-success" @click="ver(log)">
            <icone icon="eye"/> Ver
          </button>
        </li>

      </ul>

    </carta>
  </div>

  <div class="col-10">

    <carta zIndex="499" top="57">

      <template slot="header" >
        <div class="row">

          <div class="col-9">
            Logs do ERP
          </div>

        </div>
      </template>

      <div class="row" v-for="linha in log_carregado">

        <div class="col">
          {{linha}}
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
      reaizando: false,
      log_carregado: '',
      logs: '',
    }
  },
  created(){
    var self = this
    axios.get(base_url + 'admin/logs')
      .then(function(response){
        self.logs = response.data
      })
  },
  methods:{
    ver(file){
      var self = this

      axios.get(base_url + 'admin/logs/' + file )
        .then(function(response){

          self.log_carregado = response.data

          self.$root.$refs.toastr.s("Log carregado com sucesso", "Informativo");

        })
    },
  }
}
</script>

<style lang="css">
</style>
