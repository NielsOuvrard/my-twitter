<script setup lang="ts">
import { defineProps } from 'vue';
import { BasicUserType } from '@/types';

const props = defineProps<{
  user: BasicUserType;
}>();
</script>

<template>
  <div class="user">
    <h1>{{ props.user.username }}</h1>
    <p>{{ props.user.email }}</p>
  </div>
</template>

<style scoped lang="scss">
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #b96242;
}
</style>
