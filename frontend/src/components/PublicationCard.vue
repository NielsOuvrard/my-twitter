<script setup lang="ts">
import { defineProps } from 'vue';
import { PublicationType } from '@/types';
import router from '@/router';

const props = defineProps<{
  publication: PublicationType | undefined;
}>();

// todo buttons
// todo click on publication to go to publication page
</script>

<template>
  <div v-if="!props.publication" animation="wave" :delay="0">
    <div>
      <div>
        <div variant="circle" width="1rem" height="48px" />
        <div variant="text" :lines="2" />
      </div>
      <div>
        <div variant="rounded" inline width="82px" height="32px" />
        <div variant="rounded" inline width="64px" height="32px" />
      </div>
    </div>
  </div>
  <div
    v-else-if="!!props.publication && !!props.publication.user"
    class="publication-card"
    @click="router.push(`/users/${props.publication.user.id}`)"
  >
    <div class="user-info">
      <div class="avatar-wrapper">
        <img
          class="avatar"
          v-if="props.publication.user.avatar"
          :src="props.publication.user.avatar"
        />
        <img
          class="avatar"
          v-else
          :src="`https://i.pravatar.cc/150?img=${props.publication.user.id}`"
        />
        <h4 class="username">{{ props.publication.user.username }}</h4>
      </div>
      <p class="content">{{ props.publication.content }}</p>
    </div>
    <div class="actions">
      <button class="action-button like-button">Like</button>
      <button class="action-button comment-button">Comment</button>
    </div>
  </div>
</template>

<style scoped lang="scss">
.publication-card {
  display: flex;
  flex-direction: column;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 4px;
  max-width: 600px;
  width: 100%;

  .user-info {
    display: flex;
    flex-direction: row;
    align-items: center;
    margin-bottom: 20px;

    .avatar-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-right: 20px;

      .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
      }

      .username {
        font-size: 18px;
        font-weight: bold;
      }
    }

    .content {
      flex-grow: 1;
      font-size: 16px;
    }
  }

  .actions {
    display: flex;
    justify-content: space-between;

    .action-button {
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

  @media (max-width: 768px) {
    padding: 10px;

    .user-info {
      flex-direction: column;
      align-items: flex-start;

      .avatar-wrapper {
        flex-direction: row;
        justify-content: flex-start;
        margin-right: 0;
        margin-bottom: 10px;

        .avatar {
          margin-right: 10px;
        }
      }
    }
  }
}
</style>
