<script setup lang="ts">
import { defineProps } from 'vue';
import { PublicationType } from '@/types/types';
// import router from '@/router';

const props = defineProps<{
  publication: PublicationType | undefined;
}>();
</script>

<template>
  <div
    v-if="!props.publication"
    animation="wave"
    :delay="0"
    class="skeleton-group"
  >
    <div class="card">
      <div class="card-content">
        <div
          variant="circle"
          width="1rem"
          height="48px"
          class="avatar-skeleton"
        />
        <div variant="text" :lines="2" class="text-skeleton" />
      </div>
      <div class="card-actions">
        <div
          variant="rounded"
          inline
          width="82px"
          height="32px"
          class="follow-skeleton"
        />
        <div
          variant="rounded"
          inline
          width="64px"
          height="32px"
          class="comment-skeleton"
        />
      </div>
    </div>
  </div>
  <div
    v-else-if="!!props.publication && !!props.publication.user"
    class="publication-card"
  >
    <div class="row">
      <div cols="2" class="avatar-col">
        <div
          v-if="props.publication.user.avatar"
          :src="props.publication.user.avatar"
          class="avatar"
        />
        <div
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
            <div color="primary" class="follow-button">Follow</div>
            <div color="secondary" class="comment-button">Comment</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.card {
  margin-bottom: 16px;
}

.card-content {
  display: flex;
  align-items: center;
}

.avatar-skeleton {
  margin-right: 16px;
}

.text-skeleton {
  flex: 1;
}

.card-actions {
  display: flex;
  justify-content: space-between;
}

.follow-skeleton {
  margin-right: 8px;
}

.comment-skeleton {
  margin-left: 8px;
}

.publication-card {
  margin-bottom: 16px;
}

.row {
  display: flex;
}

.avatar-col {
  display: flex;
  justify-content: top;
  align-items: center;
}

.avatar {
  width: 48px;
  height: 48px;
}

.content-col {
  display: flex;
  flex-direction: column;
}

.username-row {
  margin-bottom: 8px;
}

.username {
  margin: 0;
}

.content-row {
  margin-bottom: 8px;
}

.content {
  margin: 0;
}

.button-row {
  margin-bottom: 8px;
}

.button-col {
  display: flex;
  gap: 8px;
}

.follow-button {
  flex: 1;
}

.comment-button {
  flex: 1;
}

@media (max-width: 600px) {
  .avatar-col {
    display: none;
  }

  .content-col {
    flex: 1;
  }
}

@media (min-width: 600px) {
  .avatar-col {
    flex: 1;
  }

  .content-col {
    flex: 3;
  }
}

@media (min-width: 900px) {
  .avatar-col {
    flex: 1;
  }

  .content-col {
    flex: 4;
  }
}

@media (min-width: 1200px) {
  .avatar-col {
    flex: 1;
  }

  .content-col {
    flex: 5;
  }
}

@media (min-width: 1500px) {
  .avatar-col {
    flex: 1;
  }

  .content-col {
    flex: 6;
  }
}
</style>
