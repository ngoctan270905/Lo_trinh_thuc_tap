<template>
  <div id="app" class="container">
    <AppNavbar />
    <router-view />
  </div>
</template>

<script>
import AppNavbar from '@/components/AppNavbar.vue';

export default {
  name: 'App',
  components: { AppNavbar }
};
</script>

<style>
.container {
  max-width: 960px;
  margin: 0 auto;
  padding: 20px;
}
</style>
