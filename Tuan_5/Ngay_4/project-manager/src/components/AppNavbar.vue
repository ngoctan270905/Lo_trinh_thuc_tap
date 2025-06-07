<template>
  <nav class="navbar">
    <router-link class="nav-link" to="/">Home</router-link>
    <router-link class="nav-link" to="/projects">Projects</router-link>
    <router-link
      v-if="role === 'admin'"
      class="nav-link btn-new-project"
      to="/projects/new"
      >New Project</router-link
    >
  </nav>
</template>

<script>
export default {
  name: 'AppNavbar',
  data() {
    return {
      role: localStorage.getItem('role') || 'guest',
    };
  },
  methods: {
    goHome() {
      this.$router.push('/');
    },
  },
};
</script>

<style scoped>
.navbar {
  display: flex;
  gap: 20px;
  padding: 12px 24px;
  background-color: #1976d2;
  color: white;
  align-items: center;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  box-shadow: 0 2px 6px rgb(0 0 0 / 0.15);
}

.nav-btn {
  background: transparent;
  border: none;
  color: white;
  cursor: pointer;
  font-size: 1rem;
  font-weight: 600;
  padding: 6px 12px;
  border-radius: 4px;
  transition: background-color 0.3s ease;
}

.nav-btn:hover {
  background-color: rgba(255 255 255 / 0.2);
}

.nav-link {
  color: white;
  text-decoration: none;
  font-weight: 600;
  font-size: 1rem;
  padding: 6px 12px;
  border-radius: 4px;
  transition: background-color 0.3s ease;
}

.nav-link:hover {
  background-color: rgba(255 255 255 / 0.2);
}

.btn-new-project {
  background-color: #ff9800;
  color: #fff;
  font-weight: 700;
  box-shadow: 0 2px 8px rgb(255 152 0 / 0.6);
  transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.btn-new-project:hover {
  background-color: #f57c00;
  box-shadow: 0 4px 12px rgb(245 124 0 / 0.8);
}
</style>
