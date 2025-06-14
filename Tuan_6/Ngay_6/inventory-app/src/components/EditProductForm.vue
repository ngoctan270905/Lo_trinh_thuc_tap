<template>
  <form @submit.prevent="submitForm" class="form">
    <h3>✏️ Sửa sản phẩm</h3>

    <label>
      Tên sản phẩm:
      <input v-model="form.name" placeholder="Nhập tên sản phẩm" required />
    </label>

    <label>
      Giá:
      <input v-model.number="form.price" type="number" placeholder="Nhập giá" required />
    </label>

    <label>
      Số lượng:
      <input v-model.number="form.quantity" type="number" placeholder="Nhập số lượng" required />
    </label>

    <div class="button-group">
      <button type="submit" class="update-btn">💾 Cập nhật</button>
      <button type="button" class="cancel-btn" @click="$emit('cancel')">❌ Hủy</button>
    </div>
  </form>
</template>

<script setup>
import { reactive, watch } from 'vue'

const props = defineProps(['product'])
const emit = defineEmits(['update', 'cancel'])

const form = reactive({
  name: '',
  price: 0,
  quantity: 0,
})

watch(() => props.product, (val) => {
  if (val) Object.assign(form, val)
}, { immediate: true })

function submitForm() {
  emit('update', { ...form })
}
</script>

<style scoped>
.form {
  display: flex;
  flex-direction: column;
  gap: 12px;
  padding: 16px;
  border: 1px solid #ffecb5;
  border-radius: 12px;
  background-color: #fff8e1;
  max-width: 500px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

h3 {
  margin-top: 0;
  color: #8a6d3b;
}

label {
  display: flex;
  flex-direction: column;
  font-weight: 500;
  color: #333;
}

input {
  padding: 8px 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
  margin-top: 4px;
  transition: border-color 0.2s;
}

input:focus {
  border-color: #ffbf00;
  outline: none;
}

.button-group {
  display: flex;
  gap: 10px;
  margin-top: 8px;
}

.update-btn {
  background-color: #ffbf00;
  color: white;
  border: none;
  padding: 10px 16px;
  font-size: 14px;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.update-btn:hover {
  background-color: #d9a300;
}

.cancel-btn {
  background-color: #d9534f;
  color: white;
  border: none;
  padding: 10px 16px;
  font-size: 14px;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.cancel-btn:hover {
  background-color: #b52b27;
}
</style>
