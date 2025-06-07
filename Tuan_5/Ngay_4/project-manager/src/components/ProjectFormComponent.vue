<template>
  <form @submit.prevent="submitForm" class="project-form" novalidate>
    <label>
      Tiêu đề:
      <input
        v-model.trim="form.title"
        type="text"
        required
        placeholder="Nhập tiêu đề dự án"
      />
    </label>
    <label>
      Mô tả:
      <textarea
        v-model.trim="form.description"
        rows="4"
        required
        placeholder="Nhập mô tả dự án"
      ></textarea>
    </label>
    <button type="submit">Lưu</button>
  </form>
</template>

<script setup>
import { ref, watch, defineProps, defineEmits } from 'vue';

const props = defineProps({
  project: {
    type: Object,
    default: () => ({ title: '', description: '' }),
  },
});

const emit = defineEmits(['submit']);

const form = ref({
  title: props.project.title,
  description: props.project.description,
});

watch(
  () => props.project,
  (newVal) => {
    form.value.title = newVal.title;
    form.value.description = newVal.description;
  }
);

function submitForm() {
  if (!form.value.title || !form.value.description) {
    // Nếu muốn thêm alert hoặc thông báo riêng thì làm ở đây
    return;
  }
  emit('submit', { ...form.value });
}
</script>

<style scoped>
.project-form {
  display: flex;
  flex-direction: column;
  gap: 12px;
  margin-bottom: 20px;
  max-width: 480px;
}
.project-form label {
  display: flex;
  flex-direction: column;
  font-weight: 600;
  color: #333;
}
.project-form input,
.project-form textarea {
  padding: 10px;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  transition: border-color 0.3s ease;
}
.project-form input:focus,
.project-form textarea:focus {
  outline: none;
  border-color: #1976d2;
  box-shadow: 0 0 5px rgba(25, 118, 210, 0.5);
}
.project-form button {
  width: 120px;
  padding: 10px;
  background-color: #1976d2;
  color: white;
  font-weight: 600;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  align-self: flex-start;
  transition: background-color 0.3s ease;
}
.project-form button:hover {
  background-color: #155a9c;
}
</style>
