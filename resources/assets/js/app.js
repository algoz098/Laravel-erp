require('./bootstrap');

import VueRouter from 'vue-router';
window.Vue = require('vue');
Vue.use(VueRouter);

import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

import Moment from 'vue-moment';
Vue.use(Moment);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


import navbar from 'bootstrap-vue/lib/components/navbar';
import button from 'bootstrap-vue/lib/components/button';
// import button_toolbar from 'bootstrap-vue/lib/components/button-toolbar';
import tooltip from 'bootstrap-vue/lib/components/tooltip';
import table from 'bootstrap-vue/lib/components/table';

Vue.component('icone', require('./components/Icone.vue'));
Vue.component('painel-acao', require('./components/Painel-acao.vue'));
Vue.component('button-group', require('bootstrap-vue/lib/components/button-group.vue'));

var Filters = require('./filters.js');
import router from './routes';



new Vue({
    el: '#app',
    router: router,
    data:{
      'erpDono': 'ERP',
      base_url:  window.base_url,
      menus: []
    },
    methods: {
      deslogar: function() {
        axios.post(this.base_url+'logout', {_token: window.Laravel.csrfToken})
          .then(function(response){
            location.reload();
          })
          .catch(function(response){
            location.reload();
          });
      }
    },
    created: function() {
       var self = this;
      axios.get(base_url+'/menus')
        .then(function(response){
          self.menus = response.data.menu;
          self.erpDono = response.data.erp_nome;
        });
    },
    filters: Filters
});
