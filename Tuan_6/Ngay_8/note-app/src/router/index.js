import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/HomePage.vue';
import Notes from '../views/NoteView.vue';

export default createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: Home },
    { path: '/notes', component: Notes },
  ],
});
