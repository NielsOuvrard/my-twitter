<script setup lang="ts">
import { defineProps, ref } from 'vue';
import { FullUserType } from '@/types';

import { useStore } from 'vuex';

const error = ref('');
const store = useStore();

// move this in user page, user card is useless

const follow = async () => {
  try {
    await store.dispatch('createRelationship', {
      followed_id: props.user.id,
    });
  } catch (e) {
    error.value = e.response.data.message;
  }
};

const props = defineProps<{
  user: FullUserType;
}>();
</script>

<template>
  <div v-if="!props.user" class="loading">Loading...</div>
  <div v-else class="user-container">
    <template v-if="props.user.avatar">
      <img :src="props.user.avatar" alt="Avatar" class="avatar" />
    </template>
    <template v-else>
      <img
        :src="`https://i.pravatar.cc/150?img=${props.user.id}`"
        alt="Avatar"
        class="avatar"
      />
    </template>
    <h1 class="username">{{ props.user.username }}</h1>
    <div class="user-details">
      <div class="details">
        <p class="email">{{ props.user.email }}</p>
        <p class="created-at">{{ props.user.created_at }}</p>
        <p class="bio">{{ props.user?.bio }}</p>
      </div>
    </div>
    <div class="follow-section">
      <button class="follow-button" @click="follow">follow</button>
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
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.user-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;

  .avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
  }

  .username {
    font-size: 24px;
    font-weight: bold;
    margin-top: 20px;
  }

  .user-details {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20px;

    .details {
      .email,
      .created-at,
      .bio {
        font-size: 16px;
        margin-top: 10px;
      }
    }
  }

  .follow-section {
    display: flex;
    justify-content: center;
    margin-top: 20px;

    .follow-button {
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      background-color: #007bff;
      color: #fff;
      cursor: pointer;

      &:hover {
        background-color: #0056b3;
      }
    }
  }

  .recent-posts {
    width: 100%;
    margin-top: 40px;

    .section-title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .posts-list {
      list-style: none;
      padding: 0;
    }
  }

  @media (max-width: 768px) {
    .avatar {
      width: 100px;
      height: 100px;
    }

    .username {
      font-size: 20px;
    }

    .user-details {
      .details {
        .email,
        .created-at,
        .bio {
          font-size: 14px;
        }
      }
    }

    .recent-posts {
      .section-title {
        font-size: 18px;
      }
    }
  }
}
</style>
