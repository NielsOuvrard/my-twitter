<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useStore } from 'vuex';
import { MessageWithUserType } from '@/types';
import LastMessage from '@/components/LastMessageCard.vue';

const store = useStore();
const last_messages_from = ref<MessageWithUserType[] | null>(null);

onMounted(async () => {
  last_messages_from.value = await store.dispatch('fetchLastUsersMessages');
});
</script>

<template>
  <div :aria-busy="!!last_messages_from">
    <LastMessage
      v-for="message in last_messages_from"
      :key="message.id"
      :message="message"
      class="last-message"
    />
  </div>
</template>

<style scoped lang="scss">
.last-message {
  margin-bottom: 10px;
}
</style>
