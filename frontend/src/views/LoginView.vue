<script setup lang="ts">
import axios from 'axios';
import router from '@/router';
import { ref } from 'vue';

const username = ref('');
const password = ref('');
const error = ref('');
const jwt = ref('');

const login = async () => {
  console.log('login');
  try {
    const response = await axios.post(
      'http://ouvrard.niels.free.fr/index.php?/login',
      {
        email: username.value,
        password: password.value,
      },
    );
    console.log(response);
    if (response.data.success) {
      // jwt.value = response.data.jwt;
      console.log(response.data);
      router.push('/');
    } else {
      error.value = 'Invalid username or password';
    }
  } catch (err) {
    console.error(err);
    error.value = 'An error occurred';
  }
};
</script>

<template>
  <div class="login">
    <h1>Login</h1>
    <div v-if="error">{{ error }}</div>
    <div>
      <label for="username">Username:</label>
      <input id="username" v-model="username" type="text" />
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
