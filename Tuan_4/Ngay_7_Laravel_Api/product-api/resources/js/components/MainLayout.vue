<!-- resources/js/components/MainLayout.vue -->
<template>
  <div>
    <header class="bg-primary text-white p-3">
      <h1>Quản lý sản phẩm</h1>
    </header>

    <div class="d-flex">
      <aside class="bg-light border" style="width: 200px; min-height: 80vh; padding: 1rem;">
        <nav>
          <ul class="list-unstyled">
            <li><router-link to="/products">Danh sách sản phẩm</router-link></li>
            <li><router-link to="/products/create">Tạo sản phẩm mới</router-link></li>
            <li><a href="#" @click.prevent="logout">Đăng xuất</a></li>
          </ul>
        </nav>
      </aside>

      <main class="flex-fill p-3">
        <!-- Nơi hiển thị các trang con -->
        <router-view />
      </main>
    </div>

    <footer class="bg-secondary text-white text-center p-3 mt-4">
      Bản quyền © 2025 - Product Management System
    </footer>
  </div>
</template>

<script>
export default {
  methods: {
    logout() {
      localStorage.removeItem('user');
      this.$router.push('/login');
    }
  }
}
</script>

<style scoped>
/* Tùy chỉnh CSS nhỏ nếu muốn */
</style>
