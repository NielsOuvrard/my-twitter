<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useStore } from 'vuex';
import { BasicUserType, MinimalMessageType } from '@/types';
import MessageCard from '@/components/MessageCard.vue';
import router from '@/router';

const store = useStore();
const messages = ref<MinimalMessageType[] | null>(null);
const user = ref<BasicUserType | null>(null);
const new_message = ref<string>('');

const sendMessage = async () => {
  if (!new_message.value) return;
  await store.dispatch('sendMessage', {
    id: router.currentRoute.value.params.id,
    content: new_message.value,
  });
  new_message.value = '';
  messages.value = await store.dispatch(
    'fetchMessages',
    router.currentRoute.value.params.id,
  );
};

onMounted(async () => {
  messages.value = await store.dispatch(
    'fetchMessages',
    router.currentRoute.value.params.id,
  );
  user.value = await store.dispatch(
    'fetchUser',
    router.currentRoute.value.params.id,
  );
});
</script>

<template>
  <div v-if="!!user">
    <template v-if="user.avatar">
      <img :src="user.avatar" alt="avatar" />
    </template>
    <template v-else>
      <img :src="`https://i.pravatar.cc/150?img=${user.id}`" alt="avatar" />
    </template>
    <h1>{{ user.username }}</h1>
    <h2>{{ user.email }}</h2>
    <template v-if="!!messages">
      <MessageCard
        v-for="message in messages"
        :key="message.id"
        :message="message"
        :am_i_author="message.sender_id === store.state.profile.id"
        class="last-message"
      />
    </template>
    <div>
      <textarea v-model="new_message" />
      <button @click="sendMessage">Send</button>
    </div>
  </div>
</template>

<style scoped lang="scss">
.last-message {
  margin-bottom: 10px;
}
</style>
