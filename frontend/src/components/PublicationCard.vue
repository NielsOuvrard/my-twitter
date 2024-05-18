<script lang="ts">
import { defineComponent } from 'vue';
import { PublicationType } from '@/types/types';

export default defineComponent({
  name: 'PublicationCard',
  props: {
    publication: {
      type: Object as () => PublicationType,
      required: true,
    },
  },
});
</script>

<template>
  <div class="publication">
    <h1>{{ publication.user }}</h1>
    <p>{{ publication.content }}</p>
  </div>
</template>

<!-- Add "scoped" attribute to limit CSS to this component only -->
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
