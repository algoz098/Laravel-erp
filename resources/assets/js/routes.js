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
  },
  {
    path: '/lista/produtos',
    name: 'produtos_lista',
    component: require('./views/produtos/Home.vue'),
  },
  {
    path: '/novo/produtos',
    name: 'produtos_novo',
    component: require('./views/produtos/Novo.vue'),

    children: [
        {
          path: ':id',
           name: 'produtos_editar',
          component: require('./views/produtos/Novo.vue')
        },
    ]
  },
  {
    path: '/novo/nfentrada',
    name: 'nfentrada_novo',
    component: require('./views/nf_entrada/Novo.vue'),

    children: [
        {
          path: ':id',
           name: 'nfentrada_editar',
          component: require('./views/nf_entrada/Novo.vue')
        },
    ]
  },
  {
    path: '/lista/nfentrada',
    name: 'nfentrada_lista',
    component: require('./views/nf_entrada/Home.vue'),
  },

  {
    path: '/admin/usuarios/lista',
    name: 'usuarios_lista',
    component: require('./views/admin/usuarios/Home.vue'),
  },
  {
    path: '/admin/usuarios/:id/perms',
    name: 'usuarios_perms',
    component: require('./views/admin/usuarios/Perms.vue'),
  },
  {
    path: '/admin/usuarios/novo/:id',
    name: 'usuarios_novo',
    component: require('./views/admin/usuarios/Novo.vue'),
  },
  {
    path: '/admin/backup',
    name: 'backup_lista',
    component: require('./views/admin/backup/Home.vue'),
  },
  {
    path: '/admin/update',
    name: 'update_lista',
    component: require('./views/admin/update/Home.vue'),
  },
  {
    path: '/admin/config',
    name: 'admin_config',
    component: require('./views/admin/config/Home.vue'),
  },
  {
    path: '/admin/logs',
    name: 'admin_logs',
    component: require('./views/admin/logs/Home.vue'),
  },

]

export default new VueRouter({
  routes
})
