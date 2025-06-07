<template>
  <div>
    <h1>Welcome to Project Manager</h1>
    <button @click="$router.push('/projects')">Go to Projects</button>
  </div>
</template>

<script>
export default {
  name: 'HomeView'
};
</script>
