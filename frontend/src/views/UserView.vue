<script setup lang="ts">
import axios from 'axios';
import UserCard from '@/components/UserCard.vue';
import { onMounted, ref } from 'vue';
import { UserType } from '@/types/types';
import { useRoute } from 'vue-router';

const route = useRoute();
const user = ref<UserType>({
  id: 0,
  username: '',
  email: '',
  created_at: '',
});
const is_loading = ref(true);

onMounted(async () => {
  const userId = route.params.id;
  try {
    const response = await axios.get(
      `http://ouvrard.niels.free.fr/api?/user/${userId}`,
    );
    user.value = response.data as UserType;
    is_loading.value = false;
  } catch (error) {
    console.error(error);
  }
});
</script>

<template>
  <div class="user">
    <h1>User</h1>
    <div v-if="is_loading">Loading...</div>
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
