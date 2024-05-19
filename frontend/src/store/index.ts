import axios from 'axios';
import { createStore } from 'vuex';
import { PublicationType, FullUserType } from '@/types';

const domain = 'http://ouvrard.niels.free.fr/index.php?';
// const domain = 'http://localhost:8000/index.php?';

interface State {
  jwt: string | null;
  profile: FullUserType | null;
}

export default createStore<State>({
  state: {
    jwt: null,
    profile: null,
  },
  getters: {
    isAuthenticated(state) {
      return state.jwt !== null;
    },
    getProfile(state) {
      return state.profile;
    },
  },
  mutations: {
    setJwt(state, jwt) {
      state.jwt = jwt;
    },
    setProfile(state, profile) {
      state.profile = profile;
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
      const profile = await response.data.user;
      commit('setProfile', profile);
      const jwt = await response.data.token;
      commit('setJwt', jwt);

      // this works
      // console.log('profile', this.state.profile);
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

    logout({ state }) {
      state.jwt = null;
      state.profile = null;
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
