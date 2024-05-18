<script setup lang="ts">
import router from '@/router';
import PublicationCard from '@/components/PublicationCard.vue';
import { onMounted, ref } from 'vue';
import { PublicationType } from '@/types/types';
import { useStore } from 'vuex';

const publications = ref<PublicationType[]>([]);
const is_loading = ref(true);

const store = useStore();

const explorePublication = (publication: PublicationType) => {
  router.push(`/publication/${publication.id}`);
};

onMounted(async () => {
  try {
    publications.value = await store.dispatch('fetchPublications', {});
    is_loading.value = false;
  } catch (error) {
    console.error(error);
  }
});
</script>

<template>
  <div class="publications">
    <h1>Publications</h1>
    <div v-if="is_loading">Loading...</div>
    <div v-else>
      <PublicationCard
        v-for="publication in publications"
        :key="publication.id"
        :publication="publication"
        @click="explorePublication(publication)"
      />
    </div>
  </div>
</template>

<style scoped>
.illustration {
  width: 100%;
  max-width: 300px;
  cursor: pointer;
}

@media (min-width: 768px) {
  .illustration {
    max-width: 400px;
  }
}

@media (min-width: 1024px) {
  .illustration {
    max-width: 600px;
  }
}
</style>
