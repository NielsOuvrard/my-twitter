<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useStore } from 'vuex';
import { PublicationType } from '@/types/types';
import router from '@/router';

const store = useStore();
const publications = ref<PublicationType[] | null>(null);

onMounted(async () => {
  publications.value = await store.dispatch('fetchLastPublications');
});
</script>

<template>
  <div :aria-busy="!!publications">
    <VaSkeletonGroup v-if="!publications" animation="wave" :delay="0">
      <VaCard>
        <VaCardContent class="flex items-center">
          <VaSkeleton variant="circle" width="1rem" height="48px" />
          <VaSkeleton variant="text" class="ml-2 va-text" :lines="2" />
        </VaCardContent>
        <VaCardActions class="flex justify-end">
          <VaSkeleton
            class="mr-2"
            variant="rounded"
            inline
            width="82px"
            height="32px"
          />
          <VaSkeleton variant="rounded" inline width="64px" height="32px" />
        </VaCardActions>
      </VaCard>
    </VaSkeletonGroup>

    <VaCard v-else>
      <template v-for="publication in publications" :key="publication.id">
        <VaCardContent class="flex items-center">
          <VaAvatar
            v-if="publication.user && publication.user.avatar"
            :src="publication.user.avatar"
          />
          <p class="ml-2 mb-0 va-text">
            {{ publication.content }}
          </p>
        </VaCardContent>

        <VaCardActions class="flex justify-end">
          <VaButton
            color="primary"
            @click="router.push('/user/' + publication.user.id)"
          >
            Message
          </VaButton>
          <VaButton color="secondary"> Follow </VaButton>
        </VaCardActions>
      </template>
    </VaCard>

    <VaDivider class="my-8" />
  </div>
</template>

<style scoped></style>
