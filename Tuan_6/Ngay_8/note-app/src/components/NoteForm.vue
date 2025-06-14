<template>
  <form @submit.prevent="onSubmit" class="note-form">
    <md-field class="form-field">
      <label for="title">Tiêu đề</label>
      <input
        id="title"
        v-model="title"
        aria-label="Note title"
        required
      />
    </md-field>

    <md-field class="form-field">
      <label for="content">Nội dung</label>
      <textarea
        id="content"
        v-model="content"
        aria-label="Note content"
        rows="4"
        required
      ></textarea>
    </md-field>

    <md-button type="submit" class="md-raised md-primary save-button">
      Lưu ghi chú
    </md-button>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import { useNotes } from '../composables/useNotes';

const title = ref('');
const content = ref('');
const { addNote } = useNotes();

const onSubmit = () => {
  if (!title.value.trim()) return;
  addNote({ title: title.value, content: content.value });
  title.value = '';
  content.value = '';
};
</script>

<style scoped>
.note-form {
  max-width: 600px;
  margin: 40px auto;
  background: #ffffff;
  padding: 24px;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
  display: flex;
  flex-direction: column;
  gap: 24px;
  font-family: 'Segoe UI', Roboto, sans-serif;
}

.form-field label {
  font-weight: 600;
  margin-bottom: 6px;
  display: inline-block;
  font-size: 15px;
}

.form-field input,
.form-field textarea {
  background-color: #f9f9f9;
  border-radius: 6px;
  padding: 10px 12px;
  border: 1px solid #ddd;
  font-size: 15px;
  width: 100%;
  transition: border 0.3s;
}

.form-field input:focus,
.form-field textarea:focus {
  outline: none;
  border-color: #3f51b5;
  background-color: #fff;
}

.save-button {
  align-self: flex-start;
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px 16px;
  transition: background-color 0.2s;
}

.save-button:hover {
  background-color: #304ffe;
}
</style>
