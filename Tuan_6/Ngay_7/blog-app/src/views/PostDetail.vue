<template>
  <div v-if="post">
    <h2>{{ post.title }}</h2>
    <p>{{ post.body }}</p>
    <router-link :to="'/posts/' + post.id + '/edit'">Sửa</router-link>
    <button @click="handleDelete">Xoá</button>
  </div>
</template>

<script setup>
import { useQuery, useMutation } from '@vue/apollo-composable'
import { GET_POST } from '@/graphql/queries'
import { DELETE_POST } from '@/graphql/mutations'
import { useRoute, useRouter } from 'vue-router'
import { ref, watch } from 'vue'

const route = useRoute()
const router = useRouter()
const post = ref(null)

const { result } = useQuery(GET_POST, { id: route.params.id })
watch(result, (data) => {
  if (data?.post) post.value = data.post
})

const { mutate: deletePost } = useMutation(DELETE_POST)

const handleDelete = async () => {
  if (confirm('Bạn có chắc muốn xoá?')) {
    await deletePost({ id: route.params.id })
    router.push('/posts')
  }
}
</script>
