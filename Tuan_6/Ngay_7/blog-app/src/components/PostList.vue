<template>
  <div class="post-list">
    <PostItem v-for="post in posts" :key="post.id" :post="post" />
    <router-link to="/posts/create">+ Tạo bài viết mới</router-link>

  </div>
</template>

<script setup>
import PostItem from './PostItem.vue'
defineProps({ posts: Array })
</script>
