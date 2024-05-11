import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';
import HomeView from '../views/HomeView.vue';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('../views/AboutView.vue'),
  },
  {
    path: '/users',
    name: 'users',
    component: () => import('../views/UsersView.vue'),
  },
  {
    path: '/user/:id',
    children: [
      {
        path: '',
        component: () => import('../views/userView.vue'),
      },
    ],
  },
  {
    path: '/messages',
    name: 'messages',
    component: () => import('../views/MessagesView.vue'),
  },
  {
    path: '/message/:id',
    children: [
      {
        path: '',
        component: () => import('../views/messageView.vue'),
      },
    ],
  },
  {
    path: '/:catchAll(.*)',
    component: () => import('../views/NotFoundView.vue'),
  },
];
// put a link to profile in the user view

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
