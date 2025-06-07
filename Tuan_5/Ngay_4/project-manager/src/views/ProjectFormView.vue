<template>
  <div class="project-form-container">
    <h2>{{ isEdit ? 'Chỉnh sửa dự án' : 'Dự án mới' }}</h2>
    <form @submit.prevent="submitForm" class="project-form">
      <label>
        Tiêu đề:
        <input
          v-model="form.title"
          required
          placeholder="Nhập tiêu đề dự án"
          autocomplete="off"
        />
      </label>
      <label>
        Mô tả:
        <textarea
          v-model="form.description"
          required
          placeholder="Nhập mô tả dự án"
          rows="5"
        ></textarea>
      </label>
      <div class="btn-group">
        <button
          type="submit"
          :disabled="!hasPermission"
          class="btn-save"
          :title="!hasPermission ? 'Bạn không có quyền chỉnh sửa' : ''"
        >
          Lưu
        </button>
        <button
          v-if="isEdit"
          type="button"
          @click="cancelEdit"
          class="btn-cancel"
        >
          Hủy
        </button>
      </div>
    </form>
    <p v-if="!hasPermission" class="permission-warning">
      Bạn không có quyền chỉnh sửa dự án này.
    </p>
  </div>
</template>

<script>
export default {
  name: 'ProjectFormView',
  props: ['id'],
  data() {
    return {
      form: {
        id: null,
        title: '',
        description: '',
        owner: '', // chủ dự án (username hoặc id)
      },
      hasPermission: false,
      isEdit: false,
      currentUser: localStorage.getItem('username') || '',
      role: localStorage.getItem('role') || 'guest',
    };
  },
  mounted() {
    if (this.id) {
      this.isEdit = true;
      this.loadProject();
    } else {
      // Tạo mới, chỉ admin mới được phép
      this.hasPermission = this.role === 'admin';
    }
  },
  methods: {
    loadProject() {
      const saved = localStorage.getItem('projects');
      const projects = saved ? JSON.parse(saved) : [];
      const project = projects.find(p => p.id === this.id);
      if (project) {
        this.form = { ...project };
        // Quyền chỉnh sửa: admin hoặc chủ dự án
        this.hasPermission = this.role === 'admin' || this.currentUser === project.owner;
      } else {
        this.hasPermission = false;
      }
    },
    submitForm() {
      if (!this.hasPermission) {
        alert('Bạn không có quyền lưu dự án này!');
        return;
      }
      const saved = localStorage.getItem('projects');
      const projects = saved ? JSON.parse(saved) : [];

      if (this.isEdit) {
        const index = projects.findIndex(p => p.id === this.form.id);
        if (index !== -1) {
          projects.splice(index, 1, { ...this.form });
        }
      } else {
        // Gán id và chủ dự án
        this.form.id = Date.now().toString();
        this.form.owner = this.currentUser;
        projects.push({ ...this.form, tasks: [] });
      }
      localStorage.setItem('projects', JSON.stringify(projects));
      this.$router.push({ name: 'project-list' });
    },
    cancelEdit() {
      this.$router.back();
    },
  },
};
</script>

<style scoped>
.project-form-container {
  max-width: 480px;
  margin: 20px auto;
  padding: 24px;
  background-color: #f9fafd;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}
h2 {
  margin-bottom: 20px;
  color: #1976d2;
  font-weight: 700;
  text-align: center;
}
.project-form {
  display: flex;
  flex-direction: column;
  gap: 16px;
}
label {
  display: flex;
  flex-direction: column;
  font-weight: 600;
  color: #333;
}
input,
textarea {
  padding: 10px;
  font-size: 1rem;
  border: 1.5px solid #ccc;
  border-radius: 6px;
  transition: border-color 0.3s ease;
}
input:focus,
textarea:focus {
  outline: none;
  border-color: #1976d2;
  box-shadow: 0 0 6px rgba(25, 118, 210, 0.5);
}
.btn-group {
  display: flex;
  gap: 12px;
  justify-content: flex-start;
  margin-top: 10px;
}
button {
  font-weight: 600;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  padding: 10px 24px;
  font-size: 1rem;
  transition: background-color 0.3s ease;
}
.btn-save {
  background-color: #1976d2;
  color: white;
}
.btn-save:disabled {
  background-color: #a0a0a0;
  cursor: not-allowed;
}
.btn-save:hover:not(:disabled) {
  background-color: #155a9c;
}
.btn-cancel {
  background-color: #e0e0e0;
  color: #555;
}
.btn-cancel:hover {
  background-color: #c6c6c6;
}
.permission-warning {
  margin-top: 16px;
  color: #d32f2f;
  font-weight: 600;
  text-align: center;
}
</style>
