<template>
  <div class="post-list">
    <div class="header">
      <h2>📝 Danh sách bài viết</h2>
      <router-link to="/posts/create" class="btn btn-create">➕ Thêm bài viết mới</router-link>
    </div>

    <div v-if="loading" class="loading">Đang tải...</div>
    <div v-if="error" class="error">❌ Lỗi: {{ error.message }}</div>

    <div v-if="posts.length > 0" class="post-cards">
      <div v-for="post in posts" :key="post.id" class="post-card">
        <h3>{{ post.title }}</h3>
        <p>{{ post.body }}</p>
        <div class="actions">
          <router-link :to="`/posts/${post.id}/edit`" class="btn btn-edit">✏️ Sửa</router-link>
          <button class="btn btn-delete" @click="handleDelete(post.id)">🗑️ Xóa</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useQuery } from '@vue/apollo-composable'
import gql from 'graphql-tag'

const GET_POSTS = gql`
  query {
    posts {
      data {
        id
        title
        body
      }
    }
  }
`

const { result, loading, error } = useQuery(GET_POSTS)
const posts = computed(() => {
  const apiPosts = result.value?.posts?.data || []
  const localPosts = JSON.parse(localStorage.getItem('localPosts') || '[]')
  return [...localPosts, ...apiPosts]
})

const handleDelete = (id) => {
  if (confirm('Bạn có chắc muốn xóa bài viết này?')) {
    posts.value = posts.value.filter(p => p.id !== id)
    localStorage.setItem('localPosts', JSON.stringify(posts.value))
  }
}
</script>

<style scoped>
.post-list {
  padding: 32px;
  background-color: #f9f9f9;
  min-height: 100vh;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

h2 {
  font-size: 2rem;
  color: #333;
}

.loading,
.error {
  font-size: 1.2rem;
  color: #888;
}

.post-cards {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 20px;
}

.post-card {
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 3px 6px rgba(0,0,0,0.1);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.post-card h3 {
  font-size: 1.2rem;
  margin-bottom: 10px;
  color: #1976d2;
}

.post-card p {
  font-size: 1rem;
  color: #555;
  flex-grow: 1;
}

.actions {
  margin-top: 12px;
  display: flex;
  justify-content: flex-end;
  gap: 8px;
}

.btn {
  padding: 6px 12px;
  border: none;
  border-radius: 6px;
  font-size: 0.9rem;
  text-decoration: none;
  cursor: pointer;
  transition: background 0.2s ease;
}

.btn-create {
  background-color: #4caf50;
  color: white;
}

.btn-edit {
  background-color: #1976d2;
  color: white;
}

.btn-delete {
  background-color: #e53935;
  color: white;
}

.btn:hover {
  opacity: 0.9;
}
</style>
