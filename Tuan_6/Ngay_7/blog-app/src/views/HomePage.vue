<template>
  <div class="home-page">
    <div class="card">
      <h1>👋 Chào mừng đến với <span class="highlight">Blog!</span></h1>
      <p>Khám phá và chia sẻ những bài viết tuyệt vời cùng cộng đồng.</p>
      <router-link to="/posts" class="btn">📚 Xem danh sách bài viết</router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'HomePage'
}
</script>

<style scoped>
.home-page {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 70vh;
  background: #f4f7fa;
  padding: 32px;
}

.card {
  background-color: white;
  padding: 40px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  text-align: center;
  max-width: 600px;
  width: 100%;
}

h1 {
  font-size: 2.2rem;
  margin-bottom: 12px;
  color: #333;
}

.highlight {
  color: #1976d2;
}

p {
  font-size: 1.1rem;
  color: #555;
  margin-bottom: 24px;
}

.btn {
  display: inline-block;
  background-color: #1976d2;
  color: white;
  padding: 10px 20px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: bold;
  transition: background 0.3s ease;
}

.btn:hover {
  background-color: #145ea8;
}
</style>
