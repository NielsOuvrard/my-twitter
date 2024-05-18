<script setup lang="ts">
import UserCard from '@/components/UserCard.vue';
import { onMounted, ref } from 'vue';
import { FullUserType } from '@/types/types';
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';

// todo do no execute a request again, check if the user is already in the store

const route = useRoute();
const user = ref<FullUserType | null>(null);
const is_loading = ref(true);
const store = useStore();

onMounted(async () => {
  const userId = route.params.id;
  try {
    user.value = await store.dispatch('fetchUser', userId);
    is_loading.value = false;
  } catch (error) {
    console.error(error);
  }
});
</script>

<template>
  <div class="user">
    <h1>User</h1>
    <div v-if="!user">Loading...</div>
    <div v-else>
      <UserCard :user="user" />
    </div>
  </div>
</template>

<style scoped>
.illustration {
  width: 100%;
  max-width: 300px;
  cursor: pointer;
}

@media (min-width: 768px) {
  .illustration {
    max-width: 400px;
  }
}

@media (min-width: 1024px) {
  .illustration {
    max-width: 600px;
  }
}
</style>
