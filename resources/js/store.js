import { isNull } from "lodash"
import Vue from "vue"
import Vuex from "vuex"

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    user: {
      loggedIn: false,
      data: null
    },
    bucket: null,
    prefix: null
  },
  getters: {
    user(state){
      return state.user
    },

    bucket(state) {
      return state.bucket
    },

    prefix(state) {
      return state.prefix
    }
  },
  mutations: {
    SET_LOGGED_IN(state, value) {
      state.user.loggedIn = value;
    },
    SET_USER(state, data) {
      state.user.data = data;
    },
    SET_CURRENT_BUCKET(state, value) {
      state.bucket = value;
    },
    SET_CURRENT_PREFIX(state, value) {
      state.prefix = value;
    }
  },
  actions: {
    fetchUser({ commit }, user) {
      commit("SET_LOGGED_IN", user !== null);
      if (user) {
        commit("SET_USER", {
          displayName: user.displayName,
          email: user.email
        });
      } else {
        commit("SET_USER", null);
      }
    },
    changeBucket({commit}, bucket) {
      commit("SET_CURRENT_BUCKET", bucket);
    },
    changePrefix({commit}, prefix) {
      commit("SET_CURRENT_PREFIX", prefix);
    }
  }
})