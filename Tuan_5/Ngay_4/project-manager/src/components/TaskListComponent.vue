<template>
  <ul class="task-list">
    <li v-for="(task, index) in tasks" :key="index" class="task-item">
      {{ task }}
    </li>
  </ul>
</template>

<script>
export default {
  name: 'TaskListComponent',
  props: {
    tasks: {
      type: Array,
      default: () => [],
    },
  },
};
</script>

<style scoped>
.task-list {
  padding: 12px 16px;
  margin: 0;
  list-style-type: disc;
  background-color: #f0f4f8;
  border-radius: 8px;
  max-width: 400px;
}

.task-item {
  padding: 8px 12px;
  margin-bottom: 6px;
  background-color: #e3f2fd;
  border-radius: 6px;
  color: #333;
  font-size: 1rem;
  box-shadow: 0 1px 3px rgba(25, 118, 210, 0.3);
}

.task-item:last-child {
  margin-bottom: 0;
}
</style>
