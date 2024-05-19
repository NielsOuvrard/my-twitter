<script setup lang="ts">
import { defineProps } from 'vue';
import { MinimalMessageType } from '@/types';

// TODO change this component to all in one view

const props = defineProps<{
  message: MinimalMessageType;
  am_i_author: boolean;
}>();
</script>

<template>
  <div
    class="message-card"
    :class="{
      'author-message': props.am_i_author,
      'other-message': !props.am_i_author,
    }"
  >
    <div class="content">{{ props.message.content }}</div>
    <div class="date">{{ props.message.created_at }}</div>
  </div>
</template>

<style scoped lang="scss">
.message-card {
  padding: 10px;
  margin: 10px;
  margin-bottom: 10px;
  max-width: 30%;
  word-wrap: break-word;
  display: flex;
  flex-direction: column;

  @media (max-width: 768px) {
    max-width: 100%;
  }
}

.author-message {
  background-color: #86cbef;
  color: #000;
  border-radius: 15px 15px 0 15px;
  align-self: flex-end;

  // @media (prefers-color-scheme: dark) {
  //   background-color: #0a3576;
  //   color: #fff;
  // }
}

.other-message {
  background-color: #a9e29d;
  color: #000;
  border-radius: 15px 15px 15px 0;
  align-self: flex-start;

  // @media (prefers-color-scheme: dark) {
  //   background-color: #05360f;
  //   color: #fff;
  // }
}
</style>
