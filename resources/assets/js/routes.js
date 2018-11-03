export const routes = [
  {
    path: '/',
    component: require('./layouts/Public.vue'),
    children: [
      { path: '', name: 'Home', component: require('./pages/Home/Index.vue'),
        meta: {
          requiresAuth: true
        }
      },
      { path: 'login', name: 'login', component: require('./components/auth/Login.vue') },
      { path: 'reciters', name: 'reciters-index', component: require('./pages/reciters/Index.vue') },
      { path: 'reciters/create', name: 'reciters-create', component: require('./pages/reciters/Create.vue') },
      { path: 'reciters/:reciter', name: 'reciters-show', component: require('./pages/reciters/Show.vue') },
      { path: 'reciters/:reciter/edit', name: 'reciters-edit', component: require('./pages/reciters/Edit.vue') },
      { path: 'reciters/:reciter/albums/create', name: 'album-create', component: require('./pages/albums/Create.vue') },
      { path: 'reciters/:reciter/albums/:album/edit', name: 'album-create', component: require('./pages/albums/Create.vue') },
      { path: 'reciters/:reciter/albums/:album/tracks/create', name: 'track-create', component: require('./pages/tracks/Create.vue') },
    ]
  }
];