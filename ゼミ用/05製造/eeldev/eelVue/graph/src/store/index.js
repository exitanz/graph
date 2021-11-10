import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    token: null,
    user_id: null,
  },
  getters: {
    getToken(state) {
      return state.token;
    },
    getUserId(state) {
      return state.user_id;
    },
  },
  mutations: {
    setToken(state, token) {
      state.token = token;
    },
    setUserId(state, user_id) {
      state.user_id = user_id;
    },
  },
});
