<template>
  <div class="app">
    <h1>📝 Danh sách Công việc</h1>

    <TaskForm @add="addTask" />

    <ul class="task-list">
      <TaskItem
        v-for="task in tasks"
        :key="task.id"
        :task="task"
        @toggle="toggleTask"
        @delete="deleteTask"
      />
    </ul>

    <p>Còn {{ remaining }} công việc chưa hoàn thành.</p>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import TaskForm from './components/TaskForm.vue'
import TaskItem from './components/TaskItem.vue'

const tasks = ref([])

onMounted(() => {
  const saved = localStorage.getItem('tasks')
  if (saved) tasks.value = JSON.parse(saved)
})

watch(tasks, (newTasks) => {
  localStorage.setItem('tasks', JSON.stringify(newTasks))
}, { deep: true })

const addTask = (title) => {
  tasks.value.push({ id: Date.now(), title, completed: false })
}

const toggleTask = (id) => {
  const task = tasks.value.find(t => t.id === id)
  if (task) task.completed = !task.completed
}

const deleteTask = (id) => {
  tasks.value = tasks.value.filter(t => t.id !== id)
}

const remaining = computed(() => tasks.value.filter(t => !t.completed).length)
</script>


<style scoped>
.app {
  max-width: 600px;
  margin: 0 auto;
  font-family: sans-serif;
}

.task-list {
  list-style: none;
  padding: 0;
}
#app {
  max-width: 600px;
  margin: 40px auto;
  padding: 20px;
  background: #f9f9f9;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

h1 {
  text-align: center;
  color: #333;
  margin-bottom: 20px;
}

.task-count {
  text-align: center;
  margin-top: 20px;
  color: #666;
  font-style: italic;
}
</style>


