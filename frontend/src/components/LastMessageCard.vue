<script setup lang="ts">
import { defineProps } from 'vue';
import { MessageWithUserType } from '@/types';
import router from '@/router';

const props = defineProps<{
  message: MessageWithUserType;
}>();

const goToUser = () => {
  router.push('/messages/' + props.message.user.id);
};
</script>

<template>
  <div class="last-message" @click="goToUser">
    <div class="user">
      <template v-if="props.message.user.avatar">
        <img
          class="avatar"
          :src="props.message.user.avatar"
          alt="User Avatar"
        />
      </template>
      <template v-else>
        <img
          class="avatar"
          :src="`https://i.pravatar.cc/150?img=${props.message.user.id}`"
          alt="User Avatar"
        />
      </template>
      <div class="username">{{ props.message.user.username }}</div>
    </div>
    <div class="message">
      <div class="content">{{ props.message.content }}</div>
      <div class="date">{{ props.message.created_at }}</div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.last-message {
  display: flex;
  flex-direction: column;
  padding: 20px;
  border: 1px solid #ccc;
}

.user {
  display: flex;
  align-items: center;
}

.avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  margin-right: 10px;
}

.username {
  font-weight: bold;
}

.message {
  margin-top: 20px;
}

.content {
  margin-bottom: 10px;
}

.date {
  font-size: 0.8em;
  color: #888;
}

@media (min-width: 600px) {
  .last-message {
    flex-direction: row;
    justify-content: space-between;
  }

  .user {
    align-items: flex-start;
    flex: 1;
  }

  .message {
    flex: 2;
    margin-top: 0;
    margin-left: 20px;
  }
}
</style>
