<script setup lang="ts">
import router from '@/router';
import UserCard from '@/components/UserCard.vue';
import { onMounted, ref } from 'vue';
import { UserType } from '@/types/types';
import { useStore } from 'vuex';

const users = ref<UserType[]>([]);
const is_loading = ref(true);

const store = useStore();

const exploreUser = (user: UserType) => {
  router.push(`/user/${user.id}`);
};

onMounted(async () => {
  try {
    users.value = await store.dispatch('fetchUsers', {});
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
