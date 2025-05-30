import { createRouter, createWebHistory } from 'vue-router'
import axios from 'axios'

import Login from '../components/Login.vue'
import ProductList from '../components/ProductList.vue'
import ProductCreate from '../components/ProductCreate.vue'
import ProductEdit from '../components/ProductEdit.vue'
import ProductDetail from '../components/ProductDetail.vue'
import MainLayout from '../components/MainLayout.vue'

const routes = [
  { path: '/login', component: Login },

  {
    path: '/',
    component: MainLayout,
    children: [
      { path: '', redirect: 'products' },
      { path: 'products', component: ProductList },
      { path: 'products/create', component: ProductCreate },
      { path: 'products/:id', component: ProductDetail, props: true },
      { path: 'products/:id/edit', component: ProductEdit, props: true },
    ],
  },

  // Route fallback
  { path: '/:catchAll(.*)', redirect: '/login' },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// ✅ Cấu hình axios để gửi cookie theo mặc định
axios.defaults.withCredentials = true
axios.defaults.baseURL = 'http://localhost:8000' // Hoặc domain của API nếu dùng khác cổng

// ✅ Navigation Guard chuẩn Sanctum
router.beforeEach(async (to, from, next) => {
  const publicPages = ['/login']
  const authRequired = !publicPages.includes(to.path)

  try {
    const res = await axios.get('/api/user')
    const isLoggedIn = !!res.data

    if (to.path === '/login' && isLoggedIn) {
      return next('/') // Đã đăng nhập thì không vào lại login
    }

    return next()
  } catch (err) {
    if (authRequired) {
      return next('/login')
    } else {
      return next()
    }
  }
})

export default router
