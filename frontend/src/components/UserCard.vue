<script lang="ts">
import { defineComponent } from "vue";
import { UserType } from "@/types/types";

export default defineComponent({
  name: "UserCard",
  props: {
    user: {
      type: Object as () => UserType,
      required: true,
    },
  },
});
</script>

<template>
  <div class="user">
    <h1>{{ user.username }}</h1>
    <p>{{ user.email }}</p>
    <p>{{ user.created_at }}</p>
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
