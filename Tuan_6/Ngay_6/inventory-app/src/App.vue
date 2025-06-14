<template>
  <div class="app">
    <h1>📦 Quản lý Kho hàng</h1>


    <ProductForm v-if="!selectedProduct" @submit="handleAdd" />
    <EditProductForm
      v-else
      :product="selectedProduct"
      @update="handleUpdate"
      @cancel="selectedProduct = null"
    />

    <div class="summary">
      <p><strong>Tổng số sản phẩm:</strong> {{ store.productCount }}</p>
      <p><strong>Tổng giá trị kho:</strong> ${{ store.totalValue.toLocaleString() }}</p>
    </div>

    <ProductList @edit="handleEdit" @delete="handleDelete" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useInventoryStore } from './stores/inventory'
import ProductForm from './components/ProductForm.vue'
import EditProductForm from './components/EditProductForm.vue'
import ProductList from './components/ProductList.vue'

const store = useInventoryStore()
const selectedProduct = ref(null)

onMounted(() => {
  store.fetchProducts()
})

function handleAdd(product) {
  store.addProduct(product)
}

function handleEdit(product) {
  selectedProduct.value = { ...product }
}

function handleUpdate(updatedProduct) {
  if (selectedProduct.value) {
    store.updateProduct(selectedProduct.value.id, updatedProduct)
    selectedProduct.value = null
  }
}

function handleDelete(id) {
  store.removeProduct(id)
}
</script>

<style scoped>
.app {
  max-width: 800px;
  margin: 0 auto;
  padding: 24px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #333;
  background-color: #f9f9f9;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
}

h1 {
  text-align: center;
  margin-bottom: 24px;
  color: #2c3e50;
}

.summary {
  display: flex;
  justify-content: space-between;
  margin: 16px 0;
  padding: 12px 16px;
  background-color: #ffffff;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
}
</style>
