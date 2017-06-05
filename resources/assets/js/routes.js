import VueRouter from 'vue-router';


let routes = [
  {
    path: '/',
    component: require('./views/Home.vue')
  },
  {
    path: '/lista/contatos',
    name: 'contato_lista',
    component: require('./views/contatos/Home.vue')
  },
  {
    path: '/novo/contatos',
    name: 'contato_novo',
    component: require('./views/contatos/Novo.vue'),
    children: [
        {
          // UserProfile will be rendered inside User's <router-view>
          // when /user/:id/profile is matched
          path: ':id',
           name: 'contato_editar',
          component: require('./views/contatos/Novo.vue')
        },
    ]
  },
  {
    path: '/novo/funcionarios',
    name: 'funcionario_novo',
    component: require('./views/contatos/Novo.vue'),
    children: [
        {
          // UserProfile will be rendered inside User's <router-view>
          // when /user/:id/profile is matched
          path: ':id',
           name: 'funcionario_editar',
          component: require('./views/contatos/Novo.vue')
        },
    ]
  },
  {
    path: '/lista/contas',
    name: 'contas_lista',
    component: require('./views/contas/Home.vue'),
  },
  {
    path: '/novo/contas',
    name: 'contas_novo',
    component: require('./views/contas/Novo.vue'),
    children: [
      {
        path: ':id',
         name: 'contas_editar',
        component: require('./views/contas/Novo.vue')
      },
    ],
  },
  {
    path: '/novo/contas/creditar/:id',
    name: 'contas_creditar',
    component: require('./views/contas/Creditar.vue')
  },
  {
    path: '/lista/bancos',
    name: 'bancos_lista',
    component: require('./views/bancos/Home.vue'),
  },
  {
    path: '/novo/bancos',
    name: 'bancos_novo',
    component: require('./views/bancos/Novo.vue'),
    children: [
        {
          path: ':id',
           name: 'bancos_editar',
          component: require('./views/bancos/Novo.vue')
        },
    ]
  }
]

export default new VueRouter({
  routes
})
