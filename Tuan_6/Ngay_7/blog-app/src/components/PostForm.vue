<template>
  <form @submit.prevent="handleSubmit" class="post-form">
    <div class="form-group">
      <label for="title">📝 Tiêu đề:</label>
      <input id="title" v-model="form.title" required class="form-input" />
    </div>

    <div class="form-group">
      <label for="body">🧾 Nội dung:</label>
      <textarea id="body" v-model="form.body" required class="form-textarea" rows="6"></textarea>
    </div>

    <button type="submit" class="btn-submit">{{ submitText }}</button>
  </form>
</template>

<script setup>
import { ref, watch, defineProps, defineEmits } from 'vue'

const props = defineProps({
  modelValue: Object,
  submitText: {
    type: String,
    default: 'Lưu'
  }
})

const emit = defineEmits(['submit'])

const form = ref({
  title: '',
  body: ''
})

watch(
  () => props.modelValue,
  (newValue) => {
    if (newValue) {
      form.value = { ...newValue }
    }
  },
  { immediate: true }
)

const handleSubmit = () => {
  emit('submit', { ...form.value })
}
</script>

<style scoped>
.post-form {
  display: flex;
  flex-direction: column;
  gap: 16px;
  background-color: white;
  padding: 24px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.form-group {
  display: flex;
  flex-direction: column;
}

label {
  margin-bottom: 6px;
  font-weight: bold;
  color: #444;
}

.form-input,
.form-textarea {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 1rem;
  transition: border-color 0.2s ease;
}

.form-input:focus,
.form-textarea:focus {
  border-color: #42b983;
  outline: none;
}

.btn-submit {
  align-self: flex-start;
  padding: 10px 20px;
  background-color: #42b983;
  color: white;
  font-weight: bold;
  font-size: 1rem;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.btn-submit:hover {
  background-color: #369f72;
}
</style>
