import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomePage.vue'
import PostListView from '@/views/PostListView.vue'
import PostDetailView from '@/views/PostDetail.vue'
import PostCreateView from '@/views/PostCreateView.vue'
import PostEditView from '@/views/PostEditView.vue'

const routes = [
  { path: '/', name: 'Home', component: HomeView },
  { path: '/posts', name: 'Posts', component: PostListView },
  { path: '/posts/create', name: 'CreatePost', component: PostCreateView },
  { path: '/posts/:id', name: 'PostDetail', component: PostDetailView },
  { path: '/posts/:id/edit', name: 'EditPost', component: PostEditView },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
