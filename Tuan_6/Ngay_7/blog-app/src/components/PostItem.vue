<template>
  <div class="post-item">
    <h3>{{ post.title }}</h3>
    <p>{{ post.body.slice(0, 100) }}...</p>
    <router-link :to="`/posts/${post.id}`">Xem chi tiết</router-link>
  </div>
</template>

<script>
export default {
  props: {
    post: Object
  }
}
</script>


<style scoped>
.post-item {
  padding: 8px;
  border-bottom: 1px solid #ddd;
  display: flex;
  justify-content: space-between;
}
</style>
