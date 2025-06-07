<template>
  <div class="project-detail-container">
    <h2>Chi tiết dự án</h2>
    <div v-if="project" class="project-content">
      <h3 class="project-title">{{ project.title }}</h3>
      <p class="project-description">{{ project.description }}</p>
      <button @click="goEdit" class="btn-edit">Chỉnh sửa dự án</button>
      <nav class="project-nav">
        <router-link
          :to="{ name: 'project-tasks', params: { id: project.id } }"
          class="link-tasks"
        >
          Công việc (Tasks)
        </router-link>
      </nav>
      <router-view />
    </div>
    <div v-else class="not-found">
      <p>Dự án không tồn tại hoặc đã bị xóa.</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProjectDetailView',
  props: ['id'],
  data() {
    return {
      project: null,
    };
  },
  mounted() {
    this.loadProject();
  },
  watch: {
    id() {
      this.loadProject();
    },
  },
  methods: {
    loadProject() {
      const saved = localStorage.getItem('projects');
      const projects = saved ? JSON.parse(saved) : [];
      this.project = projects.find(p => p.id === this.id) || null;
    },
    goEdit() {
      this.$router.push({ name: 'project-edit', params: { id: this.id } });
    },
  },
};
</script>

<style scoped>
.project-detail-container {
  max-width: 600px;
  margin: 20px auto;
  padding: 24px;
  background-color: #fefefe;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}
h2 {
  color: #1976d2;
  font-weight: 700;
  text-align: center;
  margin-bottom: 24px;
}
.project-title {
  font-size: 1.8rem;
  margin-bottom: 12px;
  color: #333;
}
.project-description {
  font-size: 1.1rem;
  line-height: 1.6;
  margin-bottom: 24px;
  color: #555;
}
.btn-edit {
  background-color: #1976d2;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  margin-bottom: 20px;
  transition: background-color 0.3s ease;
}
.btn-edit:hover {
  background-color: #155a9c;
}
.project-nav {
  margin-bottom: 24px;
}
.link-tasks {
  color: #1976d2;
  text-decoration: none;
  font-weight: 600;
  font-size: 1rem;
  border-bottom: 2px solid transparent;
  transition: border-color 0.3s ease;
}
.link-tasks:hover {
  border-color: #1976d2;
}
.not-found {
  text-align: center;
  color: #d32f2f;
  font-weight: 600;
  font-size: 1.1rem;
}
</style>
