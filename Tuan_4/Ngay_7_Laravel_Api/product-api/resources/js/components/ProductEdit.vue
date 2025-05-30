<template>
  <div class="container mt-4" style="max-width: 600px;">
    <h2 class="mb-4 text-center">Chỉnh sửa sản phẩm</h2>

    <div v-if="loading" class="text-center">Đang tải dữ liệu...</div>
    <div v-if="error" class="alert alert-danger">{{ error }}</div>

    <ProductForm
      v-if="product"
      :product="product"
      :submit-url="`/api/products/${product.id}`"
      submit-method="put"
      button-text="Cập nhật"
      button-text-loading="Đang cập nhật..."
      success-message="Cập nhật sản phẩm thành công!"
      @saved="onSaved"
    />
  </div>
</template>

<script>
import axios from 'axios'
import ProductForm from './ProductForm.vue'

export default {
  components: { ProductForm },
  data() {
    return {
      product: null,
      loading: false,
      error: ''
    }
  },
  methods: {
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
    onSaved() {
      this.$router.push('/products')
    }
  },
  mounted() {
    this.fetchProduct()
  }
}
</script>
