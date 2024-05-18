<script setup lang="ts">
import { UserType } from '@/types/types';
import { onMounted, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const profile = ref<UserType | null>(null);

onMounted(async () => {
  try {
    profile.value = await store.dispatch('fetchProfile');
  } catch (error) {
    console.error(error);
  }
});
</script>

<template>
  <div class="profile-view">
    <h1>Profile View</h1>
    <div class="profile-info">
      <div v-if="profile === null">Loading...</div>
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
