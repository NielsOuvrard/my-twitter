<script setup lang="ts">
import { ref } from 'vue';
import router from '@/router';

const search = ref('');
</script>

<template>
  <div>
    <input v-model="search" type="text" placeholder="Search" />
    <button @click="search = ''">Clear</button>
    <button @click="router.push({ name: 'search', query: { search } })">
      Search
    </button>
  </div>
</template>

<style scoped lang="scss">
div {
  display: flex;
  align-items: center;
  gap: 10px;
}

input[type='text'] {
  flex-grow: 1;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  background-color: #007bff;
  color: white;
  cursor: pointer;

  &:hover {
    background-color: #0056b3;
  }
}
</style>
