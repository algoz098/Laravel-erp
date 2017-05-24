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
  }
]

export default new VueRouter({
  routes
})
