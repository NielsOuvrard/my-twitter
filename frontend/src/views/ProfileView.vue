<script setup lang="ts">
import { FullUserType } from '@/types';
import { onMounted, ref } from 'vue';
import { useStore } from 'vuex';
import router from '@/router';

const store = useStore();
const profile = ref<FullUserType | null>(null);

onMounted(async () => {
  if (!store.getters.isAuthenticated) {
    router.push('/login');
  } else {
    profile.value = await store.getters.getProfile;
  }
});
</script>

<template>
  <div class="profile-view">
    <h1>Profile View</h1>
    <div class="profile-info">
      <div v-if="!profile">Loading...</div>
      <div v-else>
        <h1>{{ profile.username }}</h1>
        <p>{{ profile.email }}</p>
        <p>{{ profile.created_at }}</p>
        <!-- Display user profile information here -->
      </div>
    </div>
    <div class="recent-posts">
      <h2>Recent Posts</h2>
      <ul>
        <!-- Display recent posts here -->
        <!-- <li v-for="post in recentPosts" :key="post.id">
          {{ post.title }}
        </li> -->
      </ul>
    </div>
  </div>
</template>

<style scoped>
/* Add your custom styles here */
</style>
