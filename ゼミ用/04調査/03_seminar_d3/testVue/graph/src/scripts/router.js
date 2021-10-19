import Vue from 'vue';
import Router from 'vue-router';
import { VueURL } from '../constants/VueURL.js';
import { VueFileName } from '../constants/VueFileName.js';
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
      path: '/graphCreate/:id',
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
      path: '/test3',
      name: 'test3',
      components: {
        default: loadView('/graph/test3'),
      },
    },
    {
      path: '/test4',
      name: 'test4',
      components: {
        default: loadView('/graph/test4'),
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
      name: VueFileName.NotFound,
      components: {
        default: loadView(VueURL.ERORR + '/' + VueFileName.NotFound),
        menu: loadView('/' + VueFileName.menu),
      },
    },
  ],
});
