<template>
  <form @submit.prevent="handleSubmit" novalidate>
    <div class="mb-3">
      <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
      <input
        id="name"
        v-model="localProduct.name"
        type="text"
        class="form-control"
        :class="{ 'is-invalid': errors.name }"
        placeholder="Nhập tên sản phẩm"
        required
      />
      <div class="invalid-feedback" v-if="errors.name">{{ errors.name[0] }}</div>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Mô tả</label>
      <textarea
        id="description"
        v-model="localProduct.description"
        class="form-control"
        rows="3"
        placeholder="Nhập mô tả sản phẩm"
      ></textarea>
    </div>

    <div class="mb-3">
      <label for="price" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
      <input
        id="price"
        v-model.number="localProduct.price"
        type="number"
        min="0"
        class="form-control"
        :class="{ 'is-invalid': errors.price }"
        placeholder="Nhập giá sản phẩm"
        required
      />
      <div class="invalid-feedback" v-if="errors.price">{{ errors.price[0] }}</div>
    </div>

    <div class="mb-3">
      <label for="image" class="form-label">Ảnh sản phẩm (URL hoặc upload)</label>
      <input
        id="image"
        v-model="localProduct.image_url"
        type="text"
        class="form-control mb-2"
        placeholder="Nhập URL ảnh sản phẩm"
      />

      <label class="form-label">Hoặc tải ảnh lên:</label>
      <input
        type="file"
        class="form-control"
        @change="handleFileChange"
        accept="image/*"
      />

      <div v-if="preview" class="mt-3">
        <p>Ảnh xem trước:</p>
        <img :src="preview" alt="Ảnh xem trước" class="img-thumbnail" style="max-height: 200px;" />
      </div>
    </div>

    <button type="submit" class="btn btn-primary w-100" :disabled="loading">
      {{ loading ? buttonTextLoading : buttonText }}
    </button>

    <div v-if="error" class="alert alert-danger mt-3" role="alert">
      {{ error }}
    </div>

    <div v-if="success" class="alert alert-success mt-3" role="alert">
      {{ successMessage }}
    </div>
  </form>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    product: {
      type: Object,
      required: true
    },
    submitUrl: {
      type: String,
      required: true
    },
    submitMethod: {
      type: String,
      required: true
    },
    buttonText: {
      type: String,
      default: 'Lưu'
    },
    buttonTextLoading: {
      type: String,
      default: 'Đang lưu...'
    },
    successMessage: {
      type: String,
      default: 'Lưu thành công!'
    }
  },
  data() {
    return {
      localProduct: { ...this.product },
      file: null,
      preview: this.product.image_url || null,
      errors: {},
      error: '',
      success: false,
      loading: false
    }
  },
  methods: {
    handleFileChange(e) {
      this.file = e.target.files[0]
      if (this.file) {
        this.preview = URL.createObjectURL(this.file)
        this.localProduct.image_url = ''
      } else {
        this.preview = this.localProduct.image_url || null
      }
    },

    async handleSubmit() {
      this.error = ''
      this.success = false
      this.errors = {}
      this.loading = true

      try {
        let imageUrl = this.localProduct.image_url

        if (this.file) {
          const formData = new FormData()
          formData.append('image', this.file)

          const uploadRes = await axios.post('/api/upload', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
          })
          imageUrl = uploadRes.data.url
        }

        const dataToSend = {
          name: this.localProduct.name,
          description: this.localProduct.description,
          price: this.localProduct.price,
          image_url: imageUrl
        }

        if (this.submitMethod.toLowerCase() === 'post') {
          await axios.post(this.submitUrl, dataToSend)
        } else if (this.submitMethod.toLowerCase() === 'put') {
          await axios.put(this.submitUrl, dataToSend)
        }

        this.success = true
        this.$emit('saved')
      } catch (err) {
        if (err.response && err.response.status === 422) {
          this.errors = err.response.data.errors
        } else {
          this.error = err.response?.data?.message || 'Có lỗi xảy ra'
        }
      } finally {
        this.loading = false
      }
    }
  },
  watch: {
    product(newVal) {
      this.localProduct = { ...newVal }
      this.preview = newVal.image_url || null
    }
  }
}
</script>
