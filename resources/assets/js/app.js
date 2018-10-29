require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css'
import VueProgressBar from 'vue-progressbar';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import App from './App.vue';
import {routes} from './routes';
import store from './store';

Vue.use(VueProgressBar, {
  color: '#ff5a00',
  failedColor: '#c90800',
  thickness: '2px',
  transition: {
    speed: '0.3s',
    opacity: '0.6s',
    termination: 0
  },
  autoRevert: false,
  location: 'top',
  inverse: false
});

Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.use(Vuex);

const router = new VueRouter({
  routes,
  mode: 'history'
});

const app = new Vue({
  el: '#app',
  router,
  store,
  components: {'main-app': App}
});
