<template lang="html">
<div class="row">

  <div class="col-6 offset-md-3">

    <carta zIndex="499" top="57">

      <template slot="header" >
        <div class="row">

          <div class="col-9">
            Backup do ERP
          </div>

          <div class="col-md-3 text-right">
            <button type="button" class="btn btn-success btn-sm" :disabled="realizando" @click="realizar_backup">
              <icone icon="gear" />
              Realizar back-up
            </button>
          </div>

        </div>
      </template>

      <div class="row">

        <div class="col">

          <h3>Estado:</h3>

          <span v-if="backups==0">

            <span class="badge badge-danger">ALERTA</span>
            Nenhum backup ainda realizado
            <br>

          </span>

          Ultimo backup: <br>
          {{ backups[0].slice(0, 10) | moment("DD/MM/YY") }}<br>

        </div>

        <div class="col">

          <h3>Backups existentes:</h3>

          <span v-if="backups==0">Nenhum backup ainda realizado</span>

          <ul class="list-unstyled" v-if="backups!='0'">

            <li v-for="backup in backups">
              {{backup}}
              <button type="button" class="btn btn-outline-info btn-sm" @click="download_backup(backup)">
                Download
              </button>
            </li>

          </ul>

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
      backups: '',
    }
  },
  created(){
    var self = this
    axios.get(base_url + 'admin/backup')
      .then(function(response){
        self.backups = response.data
      })
  },
  methods:{
    download_backup(arquivo){

      window.open(base_url + 'admin/backup/download/' + arquivo,'_blank');

      this.$root.$refs.toastr.s("Backup enviado com sucesso", "Informativo");

    },
    realizar_backup(){
      var self = this

      self.realizando = true;
      axios.get(base_url + 'admin/backup/do')
        .then(function(response){

          self.backups = response.data

          self.$root.$refs.toastr.s("Backup realizado com sucesso", "Informativo");

          self.realizando = false;

        })
    },
  }
}
</script>

<style lang="css">
</style>
