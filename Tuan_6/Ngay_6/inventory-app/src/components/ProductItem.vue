<template>
  <div class="product-item">
    <div class="info">
      <strong>{{ product.name }}</strong>
      <div class="detail">${{ product.price }} × {{ product.quantity }}</div>
    </div>
    <div class="actions">
      <button class="edit-btn" @click="$emit('edit', product)">✏️ Sửa</button>
      <button class="delete-btn" @click="$emit('delete', product.id)">🗑️ Xóa</button>
    </div>
  </div>
</template>

<script setup>
defineProps(['product'])
defineEmits(['edit', 'delete'])
</script>

<style scoped>
.product-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px;
  border: 1px solid #eee;
  border-radius: 8px;
  background-color: #fff;
  margin-bottom: 10px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.info {
  display: flex;
  flex-direction: column;
}

.detail {
  font-size: 14px;
  color: #666;
  margin-top: 4px;
}

.actions {
  display: flex;
  gap: 8px;
}

button {
  padding: 6px 12px;
  border: none;
  border-radius: 6px;
  font-size: 13px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.edit-btn {
  background-color: #42b983;
  color: white;
}

.edit-btn:hover {
  background-color: #36976e;
}

.delete-btn {
  background-color: #ff5f5f;
  color: white;
}

.delete-btn:hover {
  background-color: #d94141;
}
</style>
