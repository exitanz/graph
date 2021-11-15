// Vue
import Vue from 'vue';

// App(初期画面)
import App from './App.vue';

// css
import style from './style/style.css';

// router
import router from './scripts/router.js';

// Axios
import axios from 'axios';

// AxiosCookiejarSupport
import AxiosCookiejarSupport from 'axios-cookiejar-support';
import tough from 'tough-cookie';

AxiosCookiejarSupport(axios);
// cookiejarを有効化する
axios.defaults.jar = new tough.CookieJar();
axios.defaults.withCredentials = true;

let client = axios.create({
  baseURL: 'http://localhost',
  // baseURL: 'https://testgraphapi.herokuapp.com/',
  headers: {
    'content-type': 'application/json; charset=utf-8',
  },
});

// VueCookies
import VueCookies from 'vue-cookies';

// Vuex
import store from './store';

// Bootstrap
import { BootstrapVue } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

// fortawesome
import { library } from '@fortawesome/fontawesome-svg-core';

import {
  faEye,
  faPlusCircle,
  faArrowCircleLeft,
  faUser,
  faUserPlus,
  faLock,
  faSignature,
  faQuestionCircle,
  faCommentDots,
  faArrowsAltH,
  faUpload,
  faEdit,
  faCog,
  faPencilAlt,
  faTimes,
  faSearch
} from '@fortawesome/free-solid-svg-icons';

import {
  FontAwesomeIcon,
  FontAwesomeLayers,
  FontAwesomeLayersText,
} from '@fortawesome/vue-fontawesome';

library.add(
  faEye,
  faPlusCircle,
  faArrowCircleLeft,
  faUser,
  faUserPlus,
  faLock,
  faSignature,
  faQuestionCircle,
  faCommentDots,
  faArrowsAltH,
  faUpload,
  faEdit,
  faCog,
  faPencilAlt,
  faTimes,
  faSearch
);

Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('font-awesome-layers', FontAwesomeLayers);
Vue.component('font-awesome-layers-text', FontAwesomeLayersText);

Vue.use(BootstrapVue, VueCookies);
Vue.config.productionTip = false;

// グローバル変数設定
Vue.prototype.$http = client;
Vue.prototype.$loginStatus = false;

new Vue({
  router,
  store,
  style,
  render: (h) => h(App),
}).$mount('#app');
