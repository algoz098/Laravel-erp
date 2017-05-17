require('./bootstrap');

import VueRouter from 'vue-router';
window.Vue = require('vue');
Vue.use(VueRouter);

// import Vuex from 'vuex';
// Vue.use(Vuex);

import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

import Moment from 'vue-moment';
Vue.use(Moment);

import Toastr from 'vue-toastr';
Vue.use(Toastr);
Vue.component('vue-toastr', Toastr);

import VueSticky from 'vue-sticky';

import MaskedInput from 'vue-text-mask'
Vue.component('masked-input', MaskedInput);

import {default as Vuedals, Component as Vuedal, Bus as VuedalsBus} from 'vuedals';
Vue.use(Vuedals);
Vue.component('vuedal', Vuedal);

import navbar from 'bootstrap-vue/lib/components/navbar';
import button from 'bootstrap-vue/lib/components/button';
import tooltip from 'bootstrap-vue/lib/components/tooltip';
import table from 'bootstrap-vue/lib/components/table';
import collapse from 'bootstrap-vue/lib/components/collapse';
import modal from 'bootstrap-vue/lib/components/modal';
import tab from 'bootstrap-vue/lib/components/tab';
Vue.component('button-group', require('bootstrap-vue/lib/components/button-group.vue'));

Vue.component('icone', require('./components/Icone.vue'));
Vue.component('selecionar-data', require('./components/Selecionar-data.vue'));
Vue.component('painel-acao', require('./components/Painel-acao.vue'));
Vue.component('busca-mais', require('./components/Busca-mais.vue'));
Vue.component('botao-busca-mais', require('./components/Botao-busca-mais.vue'));
Vue.component('busca-padrao', require('./components/Busca-padrao.vue'));
Vue.component('botao-novo', require('./components/Botao-novo.vue'));

Vue.component('contatos-detalhes', require('./views/contatos/Detalhes.vue'));
Vue.component('contatos-tab-detalhes', require('./views/contatos/partials/Tab-detalhes.vue'));
Vue.component('contatos-enderecos', require('./views/contatos/partials/Enderecos.vue'));
Vue.component('contatos-telefones', require('./views/contatos/partials/Telefones.vue'));
Vue.component('contatos-anexos', require('./views/contatos/partials/Anexos.vue'));

var Filters = require('./filters.js');
import router from './routes';

import Form from './core/Form';
import Errors from './core/Errors';

// const store = new Vuex.Store({
//   state: {
//     perms: []
//   },
// })

new Vue({
    el: '#app',
    router: router,
    // store: store,
    data:{
      'erpDono': 'ERP',
      menus: [],
      perms: [],
    },
    directives:{
      'sticky': VueSticky,
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
          self.perms = response.data.perms;
        });
    },
    filters: Filters
});
