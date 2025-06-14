<template>
  <div class="product-list">
    <h2>Danh sách sản phẩm</h2>
    <div class="items">
      <ProductItem
        v-for="product in store.products"
        :key="product.id"
        :product="product"
        @edit="$emit('edit', product)"
        @delete="store.deleteProduct"
      />
    </div>
  </div>
</template>

<script setup>
import { useInventoryStore } from '../stores/inventory'
import ProductItem from './ProductItem.vue'

const store = useInventoryStore()
defineEmits(['edit'])
</script>

<style scoped>
.product-list {
  margin-top: 24px;
  padding: 16px;
  background-color: #fafafa;
  border-radius: 12px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}

.product-list h2 {
  margin-bottom: 12px;
  font-size: 20px;
  color: #333;
  border-bottom: 1px solid #e0e0e0;
  padding-bottom: 6px;
}

.items {
  display: flex;
  flex-direction: column;
  gap: 12px;
}
</style>
