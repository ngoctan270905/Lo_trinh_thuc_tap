<template>
  <div class="container mt-4">
    <h2 class="mb-4 text-center">Danh sách sản phẩm</h2>
    <div v-if="loading" class="text-center">Đang tải dữ liệu...</div>
    <div v-if="error" class="alert alert-danger">{{ error }}</div>

    <div v-if="products.length === 0 && !loading" class="text-center">Chưa có sản phẩm nào.</div>

    <div class="row">
      <div class="col-md-4 mb-4" v-for="product in products" :key="product.id">
        <div class="card h-100">
          <img :src="product.image_url || placeholder" class="card-img-top" alt="Ảnh sản phẩm" style="height: 200px; object-fit: cover;">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ product.name }}</h5>
            <p class="card-text text-truncate">{{ product.description }}</p>
            <p class="card-text fw-bold text-primary">{{ formatPrice(product.price) }}</p>
            <router-link :to="`/products/${product.id}`" class="btn btn-outline-primary mt-auto">Xem chi tiết</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      products: [],
      loading: false,
      error: '',
      placeholder: 'https://via.placeholder.com/400x300?text=No+Image',
    }
  },
  methods: {
    formatPrice(value) {
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
    },
    async fetchProducts() {
      this.loading = true
      this.error = ''
      try {
        const res = await axios.get('/api/products')
        this.products = res.data
      } catch (e) {
        this.error = 'Không tải được danh sách sản phẩm'
      } finally {
        this.loading = false
      }
    }
  },
  mounted() {
    this.fetchProducts()
  }
}
</script>
