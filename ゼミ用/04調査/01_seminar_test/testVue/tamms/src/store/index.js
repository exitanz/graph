import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    JsessionId: null,
  },
  getters: {
    getJsessionId(state) {
      return state.JsessionId;
    },
  },
  mutations: {
    setJsessionId(state, JsessionId) {
      state.JsessionId = JsessionId;
    },
  },
});
