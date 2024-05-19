<script setup lang="ts">
import { ref } from 'vue';
import router from '@/router';

const search = ref('');
</script>
<template>
  <div class="search-container">
    <input
      class="search-input"
      v-model="search"
      type="text"
      placeholder="Search"
    />
    <button class="clear-button" @click="search = ''">Clear</button>
    <button
      class="search-button"
      @click="router.push({ name: 'search', query: { search } })"
    >
      Search
    </button>
  </div>
</template>

<style scoped lang="scss">
.search-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  max-width: 600px;
  margin: auto;

  .search-input {
    flex-grow: 1;
    margin-right: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  .clear-button,
  .search-button {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .clear-button {
    background-color: #f44336;
    color: white;

    &:hover {
      background-color: #d32f2f;
    }
  }

  .search-button {
    background-color: #4caf50;
    color: white;

    &:hover {
      background-color: #388e3c;
    }
  }
}

@media (max-width: 600px) {
  .search-container {
    flex-direction: column;

    .search-input {
      margin-bottom: 10px;
    }
  }
}
</style>
