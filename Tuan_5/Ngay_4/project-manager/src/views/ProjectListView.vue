<template>
  <div class="project-list-container">
    <div class="header">
      <h2>Danh sách Dự Án</h2>
      <button class="btn-add" @click="goToAddProject">+ Thêm Dự Án</button>
    </div>

    <ul class="project-list">
      <ProjectItemCard
        v-for="project in projects"
        :key="project.id"
        :project="project"
        @delete-project="deleteProject"
        @view-project="viewProject"
      />
      <li v-if="projects.length === 0" class="empty-state">
        Chưa có dự án nào. Vui lòng thêm dự án mới.
      </li>
    </ul>
  </div>
</template>

<script>
import ProjectItemCard from '@/components/ProjectItemCard.vue';

export default {
  name: 'ProjectListView',
  components: { ProjectItemCard },
  data() {
    return {
      projects: [],
    };
  },
  mounted() {
    const saved = localStorage.getItem('projects');
    this.projects = saved ? JSON.parse(saved) : [];
  },
  methods: {
    deleteProject(id) {
      this.projects = this.projects.filter(p => p.id !== id);
      localStorage.setItem('projects', JSON.stringify(this.projects));
    },
    viewProject(id) {
      this.$router.push({ name: 'project-detail', params: { id } });
    },
    goToAddProject() {
      this.$router.push({ name: 'project-new' });
    },
  },
};
</script>

<style scoped>
.project-list-container {
  max-width: 900px;
  margin: 0 auto;
  padding: 20px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

h2 {
  color: #333;
  font-weight: 600;
  font-size: 1.8rem;
}

.btn-add {
  background-color: #1976d2;
  color: white;
  border: none;
  padding: 10px 18px;
  border-radius: 5px;
  cursor: pointer;
  font-weight: 600;
  font-size: 1rem;
  transition: background-color 0.3s ease;
}

.btn-add:hover {
  background-color: #115293;
}

.project-list {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.empty-state {
  padding: 20px;
  color: #777;
  font-style: italic;
  text-align: center;
}
</style>
