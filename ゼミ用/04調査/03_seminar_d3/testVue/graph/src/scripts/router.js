import Vue from 'vue';
import Router from 'vue-router';
import { VueURL } from '../constants/VueURL.js';
import { VueFaileName } from '../constants/VueFaileName.js';
// import { CommonUtils } from '../common/CommonUtils.js';

Vue.use(Router);

function loadView(view) {
  return () => import(`@/templates${view}.vue`);
}

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'login',
      components: {
        default: loadView('/login/login'),
      },
    },
    {
      path: '/question',
      name: 'question',
      components: {
        default: loadView('/account/question'),
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
      path: '/graphList',
      name: 'graphList',
      components: {
        default: loadView('/graph/graphList')
      },
    },
    {
      path: '/graphCreate',
      name: 'graphCreate',
      components: {
        default: loadView('/graph/graphCreate'),
      },
    },
    {
      path: '/graphSubmit',
      name: 'graphSubmit',
      components: {
        default: loadView('/graph/graphSubmit'),
      },
    },
    {
      path: '/test',
      name: 'test',
      components: {
        default: loadView('/graph/test'),
      },
    },
    {
      path: '/test2',
      name: 'test2',
      components: {
        default: loadView('/graph/test2'),
      },
    },
    {
      path: '/r',
      name: 'r',
      components: {
        default: loadView('/graph/r'),
      },
    },
    {
      path: '*',
      name: VueFaileName.NotFound,
      components: {
        default: loadView(VueURL.ERORR + '/' + VueFaileName.NotFound),
        menu: loadView('/' + VueFaileName.menu),
      },
    },
  ],
});
