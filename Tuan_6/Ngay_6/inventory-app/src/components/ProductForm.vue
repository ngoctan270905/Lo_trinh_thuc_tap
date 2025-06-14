<template>
  <form @submit.prevent="submitForm" class="form">
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

    <button type="submit">➕ Thêm sản phẩm</button>
  </form>
</template>

<script setup>
import { reactive } from 'vue'

const emit = defineEmits(['submit'])

const form = reactive({
  name: '',
  price: 0,
  quantity: 0,
})

function submitForm() {
  emit('submit', { ...form })
  Object.assign(form, { name: '', price: 0, quantity: 0 })
}
</script>

<style scoped>
.form {
  display: flex;
  flex-direction: column;
  gap: 12px;
  padding: 16px;
  border: 1px solid #ccc;
  border-radius: 12px;
  background-color: #f9f9f9;
  max-width: 500px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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
  border-color: #42b983;
  outline: none;
}

button {
  align-self: flex-start;
  background-color: #42b983;
  color: white;
  border: none;
  padding: 10px 16px;
  font-size: 14px;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.2s;
}

button:hover {
  background-color: #36976e;
}
</style>
