import axios from 'axios';
import { createStore } from 'vuex';

const domain = 'http://ouvrard.niels.free.fr/index.php?';

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
      const response = await axios.post(`${domain}/login`, {
        email: credentials.email,
        password: credentials.password,
      });
      if (!response.data.token) {
        throw new Error('Invalid credentials');
      }
      const jwt = await response.data.token;
      commit('setJwt', jwt);
    },

    async register(_, credentials) {
      const response = await axios.post(`${domain}/register`, {
        username: credentials.username,
        email: credentials.email,
        password: credentials.password,
      });
      if (!response.data.token) {
        throw new Error('Invalid credentials');
      }
    },

    async fetchUser(_, user_id) {
      const response = await axios.get(`${domain}/user/${user_id}`, {});
      if (!response.data) {
        throw new Error('No user');
      }
      return response.data;
    },

    async fetchUsers() {
      const response = await axios.get(`${domain}/users`, {});
      if (!response.data) {
        throw new Error('No users');
      }
      return response.data;
    },

    async logout({ state }) {
      const response = await axios.get(`${domain}/logout`, {
        headers: {
          Authorization: `Bearer ${state.jwt}`,
        },
      });
      if (!response.data.id) {
        throw new Error('Bad token');
      }
    },
  },
  modules: {},
});
