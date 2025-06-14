<template>
  <div id="app">
    <md-app md-waterfall md-mode="fixed">
      <!-- Navigation Drawer -->
      <NavDrawer />

      <!-- Main Content -->
      <md-app-content>
        <router-view />
      </md-app-content>
    </md-app>
  </div>
</template>

<script setup>
import NavDrawer from './components/NavDrawer.vue'
</script>

<style>


#app {
  font-family: 'Roboto', sans-serif;
  max-width: 1200px;
  margin: 0 auto;
  padding: 16px;
}
</style>
