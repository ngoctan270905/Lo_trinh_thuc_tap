<template>
  <div class="post-create">
    <div class="header">
      <h2>📝 Thêm bài viết mới</h2>
      <router-link to="/posts" class="btn btn-back">← Quay lại danh sách</router-link>
    </div>

    <PostForm :submitText="'Tạo mới'" @submit="handleCreate" />

    <p v-if="error" class="error">❌ Lỗi: {{ error.message }}</p>
  </div>
</template>

<script setup>
import PostForm from '@/components/PostForm.vue'
import { useMutation } from '@vue/apollo-composable'
import { CREATE_POST } from '@/graphql/mutations'
import { useRouter } from 'vue-router'

const router = useRouter()
const { mutate, onDone, error } = useMutation(CREATE_POST)

const handleCreate = (input) => {
  mutate({ input })
}

onDone(({ data }) => {
  if (data?.createPost?.id) {
    // Lưu bài viết vào localStorage
    const localPosts = JSON.parse(localStorage.getItem('localPosts') || '[]')
    localPosts.unshift(data.createPost)
    localStorage.setItem('localPosts', JSON.stringify(localPosts))

    router.push('/posts')
  }
})

</script>

<style scoped>
.post-create {
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

.btn {
  padding: 6px 12px;
  border: none;
  border-radius: 6px;
  font-size: 0.9rem;
  text-decoration: none;
  cursor: pointer;
  transition: background 0.2s ease;
}

.btn-back {
  background-color: #9e9e9e;
  color: white;
}

.btn-back:hover {
  opacity: 0.9;
}

.error {
  margin-top: 16px;
  color: #d32f2f;
}
</style>
