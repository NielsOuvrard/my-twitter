import axios from 'axios';
import { createStore } from 'vuex';

export default createStore({
  state: {
    jwt: null,
  },
  getters: {},
  mutations: {
    setJwt(state, jwt) {
      state.jwt = jwt;
    },
  },
  actions: {
    async login({ commit }, credentials) {
      const response = await axios.post(
        'http://ouvrard.niels.free.fr/index.php?/login',
        //'http://localhost:8000/index.php?/login',
        {
          email: credentials.email,
          password: credentials.password,
        },
      );

      if (!response.data.token) {
        throw new Error('Invalid credentials');
      }

      const jwt = await response.data.token;
      commit('setJwt', jwt);
    },
  },
  modules: {},
});
