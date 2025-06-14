<template>
  <div class="post-edit">
    <h2>Chỉnh sửa bài viết</h2>

    <PostForm
      v-if="post"
      :modelValue="post"
      :submitText="'Cập nhật'"
      @submit="handleUpdate"
    />
    
    <p v-if="error">Lỗi: {{ error.message }}</p>
    
    <router-link to="/posts" class="back-link">← Quay lại danh sách</router-link>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useMutation } from '@vue/apollo-composable'
import PostForm from '@/components/PostForm.vue'
import { UPDATE_POST } from '@/graphql/mutations'

const route = useRoute()
const router = useRouter()
const post = ref(null)

onMounted(() => {
  const localPosts = JSON.parse(localStorage.getItem('localPosts') || '[]')
  post.value = localPosts.find(p => p.id === route.params.id)
})

const { mutate, onDone, error } = useMutation(UPDATE_POST)

const handleUpdate = (input) => {
  // Đảm bảo chỉ gửi các trường hợp lệ
  mutate({
    id: route.params.id,
    input: {
      title: input.title,
      body: input.body
    }
  })
}

onDone(({ data }) => {
  if (data?.updatePost?.id) {
    // cập nhật localStorage
    let localPosts = JSON.parse(localStorage.getItem('localPosts') || '[]')
    localPosts = localPosts.map(p =>
      p.id === data.updatePost.id ? data.updatePost : p
    )
    localStorage.setItem('localPosts', JSON.stringify(localPosts))

    router.push('/posts')
  }
})
</script>

<style scoped>
.post-edit {
  padding: 16px;
}
.back-link {
  display: inline-block;
  margin-top: 12px;
  color: #42b983;
  text-decoration: none;
}
.back-link:hover {
  text-decoration: underline;
}
</style>
