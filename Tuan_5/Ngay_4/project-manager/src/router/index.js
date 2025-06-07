import { createRouter, createWebHistory } from 'vue-router';

import HomeView from '@/views/HomeView.vue';
import ProjectListView from '@/views/ProjectListView.vue';
import ProjectDetailView from '@/views/ProjectDetailView.vue';
import ProjectFormView from '@/views/ProjectFormView.vue';
import TaskListView from '@/views/TaskListView.vue';

const routes = [
  { path: '/', name: 'home', component: HomeView },

  { path: '/projects', name: 'project-list', component: ProjectListView },

  {
    path: '/projects/new',
    name: 'project-new',
    component: ProjectFormView,
    beforeEnter: (to, from, next) => {
      const role = localStorage.getItem('role');
      if (role === 'admin') next();
      else next('/');
    },
  },

  {
    path: '/projects/:id',
    name: 'project-detail',
    component: ProjectDetailView,
    props: true,
    children: [
      {
        path: 'tasks',
        name: 'project-tasks',
        component: TaskListView,
        props: true,
      },
      {
        path: 'edit',
        name: 'project-edit',
        component: ProjectFormView,
        props: true,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('isAuthenticated') === 'true';
  if (to.path.startsWith('/projects') && !isAuthenticated) {
    next('/');
  } else {
    next();
  }
});

export default router;
