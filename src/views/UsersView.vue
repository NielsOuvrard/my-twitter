<script setup lang="ts">
import axios from 'axios';
import router from '@/router';
import UserCard from '@/components/UserCard.vue';
import { onMounted, ref } from 'vue';
import { UserType } from '@/types/types';

const users = ref<UserType[]>([]);
const is_loading = ref(true);

const exploreUser = (user: UserType) => {
  router.push(`/user/${user.id}`);
};

onMounted(async () => {
  try {
    const response = await axios.get(
      'http://ouvrard.niels.free.fr/api/index.php?data=users',
    );
    users.value = response.data as UserType[];
    is_loading.value = false;
  } catch (error) {
    console.error(error);
  }
});
</script>

<template>
  <div class="users">
    <h1>Users</h1>
    <div v-if="is_loading">Loading...</div>
    <div v-else>
      <UserCard
        v-for="user in users"
        :key="user.id"
        :user="user"
        @click="exploreUser(user)"
      />
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
