<template>
  <div id="app">
    <h1>Blog App</h1>
    <router-view :key="$route.fullPath" />

  </div>
</template>

<style>
#app {
  max-width: 800px;
  margin: 0 auto;
  padding: 16px;
}
</style>
