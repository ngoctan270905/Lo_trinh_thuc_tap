<template>
  <div class="task-view">
    <h3>Các công việc của dự án: {{ project?.title || 'Không rõ' }}</h3>

    <div class="task-form">
      <input v-model="newTask" placeholder="Nhập tên công việc..." />
      <button @click="addTask">Thêm</button>
    </div>

    <ul class="task-list">
      <li v-for="task in tasks" :key="task.id">
        {{ task.title }}
        <button class="delete-btn" @click="deleteTask(task.id)">🗑️</button>
      </li>
      <li v-if="tasks.length === 0">Chưa có công việc nào.</li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'TaskListView',
  props: ['id'],
  data() {
    return {
      newTask: '',
      tasks: [],
      project: null,
    };
  },
  mounted() {
    this.loadTasks();
  },
  watch: {
    id() {
      this.loadTasks();
    },
  },
  methods: {
    loadTasks() {
      const saved = localStorage.getItem('projects');
      const projects = saved ? JSON.parse(saved) : [];
      this.project = projects.find(p => p.id === this.id) || null;
      this.tasks = this.project?.tasks || [];
    },
    addTask() {
      if (!this.newTask.trim()) return;

      const saved = localStorage.getItem('projects');
      const projects = saved ? JSON.parse(saved) : [];
      const projectIndex = projects.findIndex(p => p.id === this.id);

      if (projectIndex !== -1) {
        const task = {
          id: Date.now().toString(),
          title: this.newTask.trim(),
        };
        projects[projectIndex].tasks.push(task);
        localStorage.setItem('projects', JSON.stringify(projects));

        this.tasks.push(task);
        this.newTask = '';
      }
    },
    deleteTask(taskId) {
      const saved = localStorage.getItem('projects');
      const projects = saved ? JSON.parse(saved) : [];
      const projectIndex = projects.findIndex(p => p.id === this.id);

      if (projectIndex !== -1) {
        projects[projectIndex].tasks = projects[projectIndex].tasks.filter(t => t.id !== taskId);
        localStorage.setItem('projects', JSON.stringify(projects));

        this.tasks = this.tasks.filter(t => t.id !== taskId);
      }
    },
  },
};
</script>

<style scoped>
.task-view {
  max-width: 600px;
  margin-top: 16px;
}

.task-form {
  display: flex;
  gap: 8px;
  margin-bottom: 12px;
}

.task-form input {
  flex: 1;
  padding: 8px;
  font-size: 1rem;
}

.task-form button {
  padding: 8px 12px;
  background-color: #1976d2;
  color: white;
  border: none;
  cursor: pointer;
}
.task-form button:hover {
  background-color: #115293;
}

.task-list {
  list-style-type: disc;
  padding-left: 20px;
}

.task-list li {
  margin-bottom: 8px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.delete-btn {
  background: transparent;
  border: none;
  cursor: pointer;
  color: red;
  font-size: 1rem;
}
.delete-btn:hover {
  color: darkred;
}
</style>
