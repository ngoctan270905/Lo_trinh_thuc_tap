<template>
  <form @submit.prevent="submitTask" class="task-form">
    <input v-model="title" placeholder="Nhập công việc..." />
    <button type="submit">Thêm</button>
  </form>
</template>

<script setup>
import { ref } from 'vue'
const emit = defineEmits(['add'])

const title = ref('')
const submitTask = () => {
  if (title.value.trim()) {
    emit('add', title.value.trim())
    title.value = ''
  }
}
</script>

<style scoped>
form {
  display: flex;
  gap: 12px;
  margin-bottom: 24px;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}

input[type="text"] {
  flex-grow: 1;
  padding: 12px 18px;
  font-size: 18px;
  border: 2px solid #ddd;
  border-radius: 8px;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  box-shadow: inset 0 1px 3px rgb(0 0 0 / 0.1);
}

input[type="text"]:focus {
  border-color: #42b983;
  box-shadow: 0 0 8px #42b983aa;
  outline: none;
}

button {
  padding: 12px 24px;
  background-color: #42b983;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  font-size: 16px;
  letter-spacing: 0.03em;
  transition: background-color 0.3s ease, transform 0.2s ease;
  box-shadow: 0 4px 8px rgb(66 185 131 / 0.3);
}

button:hover {
  background-color: #36976d;
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgb(66 185 131 / 0.5);
}

button:active {
  transform: translateY(0);
  box-shadow: 0 4px 8px rgb(66 185 131 / 0.3);
}

</style>


