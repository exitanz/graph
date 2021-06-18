import Vue from 'vue';
import Router from 'vue-router';
import { VueURL } from '../constants/VueURL.js';
import { VueFaileName } from '../constants/VueFaileName.js';
import store from '../store';
// import { CommonUtils } from '../common/CommonUtils.js';

Vue.use(Router);

function loadView(view) {
  return () => import(`@/templates${view}.vue`);
}

export default new Router({
  mode: 'history',
  routes: [
    {
      path: VueURL.HOME,
      name: VueFaileName.login,
      components: {
        default: loadView(VueURL.LOGIN + '/' + VueFaileName.login),
        menu: loadView('/' + VueFaileName.menu),
      },
    },
    {
      path: VueURL.SIGNUP,
      name: VueFaileName.userCreate,
      components: {
        default: loadView(VueURL.ACCOUNT + '/' + VueFaileName.userCreate),
        menu: loadView('/' + VueFaileName.menu),
      },
    },
    {
      path: VueURL.QUESTION,
      name: VueFaileName.question,
      components: {
        default: loadView(VueURL.QUESTION + '/' + VueFaileName.question),
        menu: loadView('/' + VueFaileName.menu),
      },
    },
    {
      path: VueURL.CALENDER,
      name: VueFaileName.calendar,
      components: {
        default: loadView(VueURL.CALENDER + '/' + VueFaileName.calendar),
        menu: loadView('/' + VueFaileName.menu),
      },
      beforeEnter(to, from, next) {
        if (store.getters.getJsessionId) {
          next();
        } else {
          next('/');
        }
      },
    },
    {
      path: VueURL.WALLET,
      name: VueFaileName.walletManage,
      components: {
        default: loadView(VueURL.WALLET + '/' + VueFaileName.walletManage),
        menu: loadView('/' + VueFaileName.menu),
      },
      beforeEnter(to, from, next) {
        if (store.getters.getJsessionId) {
          next();
        } else {
          next('/');
        }
      },
    },
    {
      path: VueURL.WALLET,
      name: VueFaileName.walletCreate,
      components: {
        default: loadView(VueURL.WALLET + '/' + VueFaileName.walletCreate),
        menu: loadView('/' + VueFaileName.menu),
      },
      beforeEnter(to, from, next) {
        if (store.getters.getJsessionId) {
          next();
        } else {
          next('/');
        }
      },
    },
    {
      path: VueURL.INCOME_CATEGORY,
      name: VueFaileName.incCategoryMenu,
      components: {
        default: loadView(
          VueURL.INCOME_CATEGORY + '/' + VueFaileName.incCategoryMenu
        ),
        menu: loadView('/' + VueFaileName.menu),
      },
      beforeEnter(to, from, next) {
        if (store.getters.getJsessionId) {
          next();
        } else {
          console.log(store.getters.getJsessionId);
          next('/');
        }
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
