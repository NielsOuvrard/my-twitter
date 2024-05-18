<script setup lang="ts">
import { useStore } from 'vuex';

const store = useStore();
const isAuthenticated = !!store.state.jwt;
</script>

<template>
  <nav>
    <router-link to="/">Home</router-link> |
    <router-link to="/about">About</router-link> |
    <router-link to="/users">Users</router-link> |
    <!-- <router-link to="/messages">Messages</router-link> | -->
    <router-link to="/login">login</router-link> |
    <router-link to="/register">register</router-link> |
    <template v-if="isAuthenticated">
      <router-link to="/profile">profile</router-link> |
      <router-link to="/logout">logout</router-link>
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
