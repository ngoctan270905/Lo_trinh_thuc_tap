<template>
  <nav>
    <h1>Shopping List</h1>
  </nav>
</template>

<script>
export default {
  name: "AppNavbar"
};
</script>

<style scoped>
nav {
  background-color: #2563eb; 
  color: white;
  padding: 16px 24px;
  text-align: center;
  box-shadow: 0 2px 6px rgba(37, 99, 235, 0.5);
  border-radius: 0 0 8px 8px;
  user-select: none;
}

h1 {
  font-weight: 700;
  font-size: 1.8rem;
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
</style>
