import axios from 'axios';
import { createStore } from 'vuex';
import { PublicationType } from '@/types/types';

const domain = 'http://ouvrard.niels.free.fr/index.php?';
// const domain = 'http://localhost:8000/index.php?';

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
    // * //////////////////////////////////////// Authentification

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

    // * //////////////////////////////////////// Users

    async fetchUser(_, user_id) {
      const response = await axios.get(`${domain}/users/${user_id}`, {});
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

    // * //////////////////////////////////////// Publications

    async fetchLastPublications() {
      try {
        const response = await axios.get(`${domain}/publications`, {});
        if (!response.data) {
          throw new Error('No publications');
        }
        const publications: PublicationType[] = response.data;
        return publications;
      } catch (e) {
        throw new Error('Bad publications');
      }
    },

    async sendPublication({ state }, message) {
      const response = await axios.post(
        `${domain}/publications`,
        {
          message: message.message,
        },
        {
          headers: {
            Authorization: `Bearer ${state.jwt}`,
          },
        },
      );
      if (!response.data.id) {
        throw new Error('Bad token');
      }
    },

    // * //////////////////////////////////////// Messages

    async fetchMessages({ state }) {
      const response = await axios.get(`${domain}/messages`, {
        headers: {
          Authorization: `Bearer ${state.jwt}`,
        },
      });
      if (!response.data) {
        throw new Error('No messages');
      }
      return response.data;
    },

    async sendPrivateMessage({ state }, message) {
      const response = await axios.post(
        `${domain}/messages/${message.recipient_id}`,
        {
          message: message.message,
        },
        {
          headers: {
            Authorization: `Bearer ${state.jwt}`,
          },
        },
      );
      if (!response.data.id) {
        throw new Error('Bad token');
      }
    },
  },
  modules: {},
});
