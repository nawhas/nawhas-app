export const routes = [
  {
    path: '/',
    component: require('./layouts/Public.vue'),
    children: [
      {
        path: '',
        name: 'Home',
        component: require('./pages/Home/Index.vue')
      }
    ]
  }
];