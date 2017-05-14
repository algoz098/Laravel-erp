import VueRouter from 'vue-router';


let routes = [
  {
    path: '/',
    component: require('./views/Home.vue')
  },
  {
    path: '/lista/contatos',
    component: require('./views/contatos/Home.vue')
  }
]

export default new VueRouter({
  routes
})
