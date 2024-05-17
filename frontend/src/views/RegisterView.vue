<script setup lang="ts">
import router from '@/router';
import { ref } from 'vue';
import { useStore } from 'vuex';

const email = ref('');
const username = ref('');
const password = ref('');
const confirmPassword = ref('');
const error = ref('');

const store = useStore();

const register = async () => {
  if (password.value !== confirmPassword.value) {
    error.value = 'Passwords do not match';
    return;
  }
  try {
    await store.dispatch('register', {
      username: username.value,
      email: email.value,
      password: password.value,
    });
    router.push('/login');
  } catch (err) {
    console.error(err);
    error.value = 'An error occurred';
  }
};
</script>

<template>
  <div class="register">
    <h1>Register</h1>
    <div v-if="error">{{ error }}</div>
    <div>
      <label for="email">Email:</label>
      <input id="email" v-model="email" type="text" />
    </div>
    <div>
      <label for="username">Username:</label>
      <input id="username" v-model="username" type="text" />
    </div>
    <div>
      <label for="password">Password:</label>
      <input id="password" v-model="password" type="password" />
    </div>
    <div>
      <label for="confirmPassword">Confirm Password:</label>
      <input id="confirmPassword" v-model="confirmPassword" type="password" />
    </div>
    <button @click="register">Register</button>
  </div>
</template>

<style scoped>
.register {
  width: 100%;
  max-width: 300px;
  margin: 0 auto;
  padding: 20px;
}

.register input {
  width: 100%;
  margin-bottom: 10px;
}

.register button {
  width: 100%;
}
</style>
