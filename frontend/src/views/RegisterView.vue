<script setup lang="ts">
import axios from 'axios';
import router from '@/router';
import { ref } from 'vue';

const username = ref('');
const password = ref('');
const confirmPassword = ref('');
const error = ref('');

const register = async () => {
  if (password.value !== confirmPassword.value) {
    error.value = 'Passwords do not match';
    return;
  }
  try {
    const response = await axios.post(
      'http://ouvrard.niels.free.fr/index.php?/register',
      {
        username: username.value,
        password: password.value,
      },
    );
    if (response.data.success) {
      router.push('/login');
    } else {
      error.value = 'Registration failed';
    }
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
