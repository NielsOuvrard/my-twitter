<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useStore } from 'vuex';
import { PublicationType } from '@/types/types';
import PublicationCard from '@/components/PublicationCard.vue';

const store = useStore();
const publications = ref<PublicationType[] | null>(null);

onMounted(async () => {
  publications.value = await store.dispatch('fetchLastPublications');
});
</script>

<template>
  <div :aria-busy="!!publications">
    <PublicationCard
      v-for="publication in publications"
      :key="publication.id"
      :publication="publication"
    />
  </div>
</template>

<style scoped></style>
