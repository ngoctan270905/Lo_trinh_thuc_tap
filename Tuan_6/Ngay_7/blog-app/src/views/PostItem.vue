<template>
  <div class="post-item" @click="$emit('click')">
    <div>
      <strong>{{ post.title }}</strong>
      <p>{{ post.body.slice(0, 100) }}...</p>
    </div>
    <span class="user">👤 {{ post.user?.name }}</span>
  </div>
</template>

<script setup>
defineProps(['post'])
</script>

<style scoped>
.post-item {
  padding: 12px;
  border-bottom: 1px solid #ccc;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
}
.post-item:hover {
  background: #f8f8f8;
}
.user {
  font-size: 0.8em;
  color: #888;
  margin-left: 12px;
}
</style>
