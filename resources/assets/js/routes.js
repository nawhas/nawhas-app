export const routes = [
  {
    path: '/',
    component: require('./layouts/Public.vue'),
    children: [
      {
        path: '',
        name: 'Home',
        component: require('./pages/Home/Index.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'login',
        name: 'login',
        component: require('./components/auth/Login.vue')
      },
      {
        path: 'reciters',
        name: 'reciters-index',
        component: require('./pages/reciters/Index.vue')
      },
      {
        path: 'reciters/create',
        name: 'reciters-create',
        component: require('./pages/reciters/Create.vue')
      },
      {
        path: 'reciters/:reciter',
        name: 'reciters-show',
        component: require('./pages/reciters/Show.vue')
      }
    ]
  }
];