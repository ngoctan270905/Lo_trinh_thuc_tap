<template>
  <div class="container mt-4" style="max-width: 600px;">
    <h2 class="mb-4 text-center">Tạo sản phẩm mới</h2>
    <ProductForm
      :product="emptyProduct"
      submit-url="/api/products"
      submit-method="post"
      button-text="Tạo mới"
      button-text-loading="Đang tạo..."
      success-message="Tạo sản phẩm thành công!"
      @saved="onSaved"
    />
  </div>
</template>

<script>
import ProductForm from './ProductForm.vue'

export default {
  components: { ProductForm },
  data() {
    return {
      emptyProduct: {
        name: '',
        description: '',
        price: 0,
        image_url: ''
      }
    }
  },
  methods: {
    onSaved() {
      // Chuyển về danh sách sản phẩm sau khi tạo thành công
      this.$router.push('/products')
    }
  }
}
</script>
