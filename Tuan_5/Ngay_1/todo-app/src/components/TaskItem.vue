<template>
  <li :class="{ completed: task.completed }" class="task-item">
    <input
      type="checkbox"
      :checked="task.completed"
      @change="$emit('toggle', task.id)"
      class="task-checkbox"
      id="checkbox-{{ task.id }}"
    />
    <label :for="'checkbox-' + task.id" class="task-title">{{ task.title }}</label>
    <button @click="$emit('delete', task.id)" class="delete-btn" aria-label="Xóa công việc">❌</button>
  </li>
</template>

<script setup>
defineProps(['task'])
defineEmits(['toggle', 'delete'])
</script>

<style scoped>
.task-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 16px;
  border-bottom: 1px solid #eee;
  background-color: #fff;
  border-radius: 8px;
  margin-bottom: 8px;
  box-shadow: 0 1px 3px rgb(0 0 0 / 0.05);
  transition: background-color 0.3s ease;
}

.task-item:hover {
  background-color: #f9f9f9;
}

.task-checkbox {
  width: 20px;
  height: 20px;
  cursor: pointer;
  accent-color: #42b983;
  margin-right: 12px;
}

.task-title {
  flex-grow: 1;
  font-size: 16px;
  color: #333;
  user-select: none;
}

.completed .task-title {
  text-decoration: line-through;
  color: #888;
  font-style: italic;
}

.delete-btn {
  background: none;
  border: none;
  color: #d9534f;
  font-size: 18px;
  cursor: pointer;
  padding: 4px 8px;
  border-radius: 6px;
  transition: background-color 0.2s ease;
}

.delete-btn:hover {
  background-color: #f2dede;
  color: #a94442;
}
</style>
