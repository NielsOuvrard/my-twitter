<script setup lang="ts">
import { FullUserType, PublicationType } from '@/types';
import { onMounted, ref } from 'vue';
import { useStore } from 'vuex';
import router from '@/router';
import PublicationCard from '@/components/PublicationCard.vue';

const store = useStore();
const profile = ref<FullUserType | null>(null);
const recentPosts = ref<PublicationType[]>([]);

const textToPublish = ref('');

const publish = async () => {
  if (!textToPublish.value) {
    return;
  }

  try {
    await store.dispatch('publish', textToPublish.value);
    // todo do not execute a request again
    // todo only from the user
    recentPosts.value = await store.dispatch('fetchLastPublications');
    textToPublish.value = '';
  } catch (error) {
    console.error(error);
  }
};

onMounted(async () => {
  if (!store.getters.isAuthenticated) {
    router.push('/login');
  } else {
    profile.value = await store.getters.getProfile;
  }
});
</script>

<template>
  <div v-if="!profile" class="loading">Loading...</div>
  <div v-else class="profile-container">
    <template v-if="profile.avatar">
      <img :src="profile.avatar" alt="Avatar" class="avatar" />
    </template>
    <template v-else>
      <img
        :src="`https://i.pravatar.cc/150?img=${profile.id}`"
        alt="Avatar"
        class="avatar"
      />
    </template>
    <h1 class="username">{{ profile.username }}</h1>
    <div class="profile-details">
      <div class="details">
        <p class="email">{{ profile.email }}</p>
        <p class="created-at">{{ profile.created_at }}</p>
        <p class="bio">{{ profile?.bio }}</p>
      </div>
    </div>
    <div class="publish-section">
      <h2 class="section-title">Publish</h2>
      <textarea
        class="publish-textarea"
        placeholder="Write something..."
        v-model="textToPublish"
      />
      <button class="publish-button" @click="publish">Publish</button>
    </div>
    <div class="recent-posts">
      <h2 class="section-title">Recent Posts</h2>
      <ul class="posts-list">
        <li v-for="post in recentPosts" :key="post.id">
          <PublicationCard :publication="post" />
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped lang="scss">
.loading {
  font-size: 1.5em;
  text-align: center;
}

.profile-container {
  .username {
    font-size: 2em;
    color: #333;
  }

  .avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    margin: 20px auto;
    display: block;
  }

  .profile-details {
    .details {
      .email,
      .created-at,
      .bio {
        color: #666;
      }
    }
  }

  .publish-section {
    .section-title {
      font-size: 1.5em;
    }

    .publish-textarea {
      width: 100%;
      height: 100px;
      margin-bottom: 10px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .publish-button {
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
  }

  .recent-posts {
    .section-title {
      font-size: 1.5em;
    }

    .posts-list {
      list-style: none;
      padding: 0;
    }
  }
}
</style>
