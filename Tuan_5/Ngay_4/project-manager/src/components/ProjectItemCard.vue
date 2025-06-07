<template>
  <li class="project-item">
    <div class="project-info">
      <strong class="project-title">{{ project.title }}</strong>
      <p class="project-description">{{ project.description }}</p>
    </div>
    <div class="project-actions">
      <button @click="$emit('view-project', project.id)" class="btn-view">Xem</button>
      <button @click="$emit('delete-project', project.id)" class="btn-delete">Xóa</button>
    </div>
  </li>
</template>

<script>
export default {
  name: 'ProjectItemCard',
  props: {
    project: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped>
.project-item {
  padding: 12px 16px;
  border-bottom: 1px solid #ddd;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #fafafa;
  border-radius: 8px;
  margin-bottom: 8px;
  box-shadow: 0 2px 4px rgb(0 0 0 / 0.05);
  transition: background-color 0.3s ease;
}
.project-item:hover {
  background-color: #e3f2fd;
}

.project-info {
  max-width: 70%;
}

.project-title {
  font-size: 1.1rem;
  color: #1976d2;
  margin-bottom: 4px;
}

.project-description {
  font-size: 0.9rem;
  color: #555;
  margin: 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.project-actions button {
  margin-left: 8px;
  padding: 6px 12px;
  font-size: 0.9rem;
  cursor: pointer;
  border: none;
  border-radius: 4px;
  transition: background-color 0.3s ease;
}

.btn-view {
  background-color: #1976d2;
  color: white;
}
.btn-view:hover {
  background-color: #115293;
}

.btn-delete {
  background-color: #e53935;
  color: white;
}
.btn-delete:hover {
  background-color: #ab000d;
}
</style>
