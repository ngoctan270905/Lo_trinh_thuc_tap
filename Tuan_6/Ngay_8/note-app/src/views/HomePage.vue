<template>
  <div class="home">
    <div class="home-content">
      <h1>🎉 Chào mừng bạn đến với <span class="highlight">Note App</span></h1>
      <p class="subtext">Quản lý ghi chú nhanh chóng, dễ dàng và tiện lợi.</p>

      <router-link to="/notes">
        <md-button class="md-primary md-raised md-large">
          ✏️ Xem Ghi Chú
        </md-button>
      </router-link>
    </div>
  </div>
</template>

<style scoped>
.home {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: calc(100vh - 64px); /* trừ chiều cao của toolbar */
  padding: 20px;
  text-align: center;
  background: linear-gradient(135deg, #e3f2fd, #ffffff);
}

.home-content {
  max-width: 600px;
  background-color: white;
  padding: 40px 24px;
  border-radius: 16px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

h1 {
  font-size: 2rem;
  margin-bottom: 16px;
}

.highlight {
  color: #1976d2;
  font-weight: bold;
}

.subtext {
  font-size: 1.1rem;
  margin-bottom: 24px;
  color: #555;
}

.md-button {
  font-size: 1rem;
  padding: 10px 20px;
}
</style>
