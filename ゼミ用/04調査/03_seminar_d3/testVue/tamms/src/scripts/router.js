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
        menu: loadView('/' + VueFaileName.loginMenu),
      },
    },
    {
      path: '/question',
      name: 'question',
      components: {
        default: loadView('/account/question'),
        menu: loadView('/' + VueFaileName.loginMenu),
      },
    },
    {
      path: '/userCreate',
      name: 'userCreate',
      components: {
        default: loadView('/account/userCreate'),
        menu: loadView('/' + VueFaileName.loginMenu),
      },
    },
    {
      path: '/graphList',
      name: 'graphList',
      components: {
        default: loadView('/graph/graphList'),
        menu: loadView('/' + VueFaileName.listMenu),
      },
    },
    {
      path: '/graphCreate',
      name: 'graphCreate',
      components: {
        default: loadView('/graph/graphCreate'),
        menu: loadView('/' + VueFaileName.createMenu),
      },
    },
    {
      path: '/graphSubmit',
      name: 'graphSubmit',
      components: {
        default: loadView('/graph/graphSubmit'),
        menu: loadView('/' + VueFaileName.submitMenu),
      },
    },
    {
      path: '/test',
      name: 'test',
      components: {
        default: loadView('/graph/test'),
        menu: loadView('/' + VueFaileName.createMenu),
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
        menu: loadView('/' + VueFaileName.createMenu),
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
