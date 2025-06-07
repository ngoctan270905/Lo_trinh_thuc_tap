import { createApp } from 'vue';
import App from './App.vue';
import AppNavbar from './components/AppNavbar.vue';

const app = createApp(App);
app.component('AppNavbar', AppNavbar);
app.mount('#app');
