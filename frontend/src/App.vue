<script setup lang="ts">
import { useStore } from 'vuex';
import { onMounted, ref, watch } from 'vue';

const store = useStore();
const isAuthenticated = ref<boolean>(false);

onMounted(async () => {
  isAuthenticated.value = await store.getters.isAuthenticated;
});

watch(
  () => store.getters.isAuthenticated,
  (newValue) => {
    isAuthenticated.value = newValue;
  },
);
</script>

<template>
  <nav>
    <router-link to="/">Home</router-link> |
    <router-link to="/search">Search</router-link> |
    <template v-if="isAuthenticated">
      <router-link to="/profile">Profile</router-link> |
      <router-link to="/logout">Logout</router-link>
    </template>
    <template v-else>
      <router-link to="/login">Login</router-link> |
      <router-link to="/register">Register</router-link>
    </template>
  </nav>
  <!-- put a link to profile -->
  <router-view />
</template>

<style lang="scss">
@import 'https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,400;1,700&display=swap';
@import 'https://fonts.googleapis.com/icon?family=Material+Icons';
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
