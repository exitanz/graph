import Vue from 'vue';
import Router from 'vue-router';
// import { VueURL } from '../constants/VueURL.js';
// import { VueFileName } from '../constants/VueFileName.js';
// import store from '../store';

Vue.use(Router);

function loadView(view) {
  return () => import(`@/templates${view}.vue`);
}

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/login',
      name: 'login',
      components: {
        default: loadView('/login/login'),
      },
    },
    {
      path: '/userCreate',
      name: 'userCreate',
      components: {
        default: loadView('/account/userCreate'),
      },
    },
    {
      path: '/',
      name: 'graphList',
      components: {
        default: loadView('/graph/graphList')
      },
    },
    {
      path: '/graphCreate/:id',
      name: 'graphCreate',
      components: {
        default: loadView('/graph/graphCreate'),
      },
    },
    {
      path: '*',
      name: 'top',
      components: {
        default: loadView('/top/top'),
      },
    },
  ],
});
