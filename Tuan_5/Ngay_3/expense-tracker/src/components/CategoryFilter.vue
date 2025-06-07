<template>
  <div class="category-filter">
    <label for="category-select">Lọc theo danh mục:</label>
    <select id="category-select" v-model="selected" @change="updateCategory">
      <option value="">Tất cả</option>
      <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
    </select>
  </div>
</template>

<script>
export default {
  name: 'CategoryFilter',
  props: {
    categories: {
      type: Array,
      required: true
    },
    modelValue: String
  },
  emits: ['update:modelValue'],
  computed: {
    selected: {
      get() {
        return this.modelValue || ''
      },
      set(value) {
        this.$emit('update:modelValue', value)
      }
    }
  },
  methods: {
    updateCategory(event) {
      this.$emit('update:modelValue', event.target.value)
    }
  }
}
</script>

<style scoped>
.category-filter {
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 12px;
  font-weight: 600;
  color: #2c5282;
  user-select: none;
}

.category-filter label {
  font-size: 1rem;
}

.category-filter select {
  padding: 6px 12px;
  font-size: 1rem;
  border: 1.8px solid #cbd5e0;
  border-radius: 6px;
  background-color: #f7fafc;
  color: #2d3748;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  outline-offset: 2px;
}

.category-filter select:hover {
  border-color: #3182ce;
  box-shadow: 0 0 5px rgba(49, 130, 206, 0.5);
}

.category-filter select:focus {
  border-color: #3182ce;
  box-shadow: 0 0 8px rgba(49, 130, 206, 0.7);
  outline: none;
  background-color: #fff;
  color: #1a202c;
  font-weight: 700;
}
</style>
