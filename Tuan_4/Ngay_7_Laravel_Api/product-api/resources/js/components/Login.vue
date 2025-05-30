<template>
  <div class="container mt-5" style="max-width: 400px;">
    <h2 class="mb-4 text-center">Đăng nhập</h2>
    <form @submit.prevent="login" novalidate>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input 
          id="email"
          v-model="email"
          type="email"
          class="form-control"
          placeholder="Nhập email"
          required
        />
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu</label>
        <input 
          id="password"
          v-model="password"
          type="password"
          class="form-control"
          placeholder="Nhập mật khẩu"
          required
        />
      </div>

      <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>

      <div v-if="error" class="alert alert-danger mt-3" role="alert">
        {{ error }}
      </div>

      <div v-if="success" class="alert alert-success mt-3" role="alert">
        Đăng nhập thành công!
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      email: '',
      password: '',
      error: '',
      success: false,
    }
  },
  methods: {
    async login() {
      this.error = ''
      this.success = false
      try {
        // Gọi lấy CSRF token trước
        await axios.get('/sanctum/csrf-cookie')

        // Gửi request login
        const res = await axios.post('/api/login', {
          email: this.email,
          password: this.password
        })

        localStorage.setItem('user', JSON.stringify(res.data.user))
        this.success = true

        // Chuyển hướng sau 1s (bạn có thể đổi theo ý)
        setTimeout(() => {
          this.$router.push('/')
        }, 1000)
      } catch (err) {
  console.log('Lỗi chi tiết:', err.response)
  if (err.response) {
    if (err.response.status === 422) {
      this.error = err.response.data.errors || err.response.data.message || 'Lỗi dữ liệu nhập vào'
    } else {
      this.error = err.response.data.message || 'Lỗi đăng nhập'
    }
  } else {
    this.error = 'Không thể kết nối tới server'
  }
}

    }
  }
}
</script>
