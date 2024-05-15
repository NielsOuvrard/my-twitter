<script setup lang="ts">
// import router from '@/router';
import { ref } from 'vue';
import { useStore } from 'vuex';

const email = ref('');
const password = ref('');
const error = ref('');

const store = useStore();

const login = async () => {
  try {
    await store.dispatch('login', {
      email: email.value,
      password: password.value,
    });
    // router.push('/');
  } catch (e: any) {
    error.value = e.response.data.message;
  }
};
</script>

<template>
  <div class="login">
    <h1>Login</h1>
    <div v-if="error">{{ error }}</div>
    <div>
      <label for="email">Email:</label>
      <input id="email" v-model="email" type="text" />
    </div>
    <div>
      <label for="password">Password:</label>
      <input id="password" v-model="password" type="password" />
    </div>
    <button @click="login">Login</button>
  </div>
</template>

<style scoped>
.login {
  width: 100%;
  max-width: 300px;
  margin: 0 auto;
  padding: 20px;
}

.login input {
  width: 100%;
  margin-bottom: 10px;
}

.login button {
  width: 100%;
}
</style>
