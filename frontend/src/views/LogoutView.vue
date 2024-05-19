<script setup lang="ts">
import router from '@/router';
import { onMounted } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

onMounted(async () => {
  await store.dispatch('logout');
  router.push('/');
});
</script>

<template>
  <div class="logout">
    <h1>Logout</h1>
  </div>
</template>

<style scoped lang="scss">
.logout {
  width: 100%;
  max-width: 300px;
  margin: 0 auto;
  padding: 20px;
}
</style>
