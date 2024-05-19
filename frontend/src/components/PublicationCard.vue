<script setup lang="ts">
import { defineProps } from 'vue';
import { PublicationType } from '@/types';
import router from '@/router';

const props = defineProps<{
  publication: PublicationType | undefined;
}>();
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
  >
    <div
      class="row"
      @click="router.push(`/users/${props.publication.user.id}`)"
    >
      <div cols="2" class="avatar-col">
        <div
          v-if="props.publication.user.avatar"
          :src="props.publication.user.avatar"
          class="avatar"
        />
        <img
          v-else
          :src="`https://i.pravatar.cc/150?img=${props.publication.user.id}`"
          class="avatar"
        />
      </div>
      <div cols="10" class="content-col">
        <div class="username-row">
          <div class="username-col">
            <h4 class="username">{{ props.publication.user.username }}</h4>
          </div>
        </div>
        <div class="content-row">
          <div class="content-col">
            <p class="content">{{ props.publication.content }}</p>
          </div>
        </div>
        <div class="button-row">
          <div class="button-col">
            <button color="primary" class="follow-button">Follow</button>
            <button color="secondary" class="comment-button">Comment</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.publication-card {
  display: flex;
  flex-direction: column;
  padding: 20px;
  border: 1px solid #ccc;
  margin-bottom: 20px;
}

.row {
  display: flex;
  flex-wrap: wrap;
}

.avatar-col {
  flex: 1 0 50px;
}

.content-col,
.username-col,
.button-col {
  padding: 10px;
  flex: 1 0 100%;
}

.avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
}

.username {
  font-weight: bold;
  margin-bottom: 10px;
}

.content {
  margin-bottom: 20px;
}

.follow-button,
.comment-button {
  padding: 10px 20px;
  margin-right: 10px;
  border-radius: 5px;
  cursor: pointer;
  flex: 1 0 auto;
}

.follow-button {
  background-color: #007bff;
  color: white;
}

.comment-button {
  background-color: #6c757d;
  color: white;
}

@media (min-width: 600px) {
  .avatar-col,
  .content-col,
  .username-col,
  .button-col {
    flex: 1 0 auto;
  }
}
</style>
