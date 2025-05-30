<template>
  <div class="container mt-4" style="max-width: 700px;">
    <button @click="$router.back()" class="btn btn-link mb-3">&laquo; Quay lại</button>

    <div v-if="loading" class="text-center">Đang tải dữ liệu...</div>
    <div v-if="error" class="alert alert-danger">{{ error }}</div>

    <div v-if="product" class="card">
      <img :src="product.image_url || placeholder" class="card-img-top" alt="Ảnh sản phẩm" style="height: 300px; object-fit: cover;">
      <div class="card-body">
        <h3 class="card-title">{{ product.name }}</h3>
        <p class="card-text">{{ product.description || 'Không có mô tả' }}</p>
        <p class="card-text fw-bold text-primary">{{ formatPrice(product.price) }}</p>
        <router-link :to="`/products/edit/${product.id}`" class="btn btn-warning me-2">Chỉnh sửa</router-link>
        <button @click="deleteProduct" class="btn btn-danger">Xóa</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      product: null,
      loading: false,
      error: '',
      placeholder: 'https://via.placeholder.com/600x400?text=No+Image',
    }
  },
  methods: {
    formatPrice(value) {
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
    },
    async fetchProduct() {
      this.loading = true
      this.error = ''
      try {
        const id = this.$route.params.id
        const res = await axios.get(`/api/products/${id}`)
        this.product = res.data
      } catch {
        this.error = 'Không tải được thông tin sản phẩm'
      } finally {
        this.loading = false
      }
    },
    async deleteProduct() {
      if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')) return;
      try {
        await axios.delete(`/api/products/${this.product.id}`)
        alert('Xóa thành công!')
        this.$router.push('/products')
      } catch {
        alert('Xóa thất bại!')
      }
    }
  },
  mounted() {
    this.fetchProduct()
  }
}
</script>
