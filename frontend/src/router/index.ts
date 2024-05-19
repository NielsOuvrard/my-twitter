import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';
import HomeView from '@/views/HomeView.vue';
import UserView from '@/views/UserView.vue';

import SearchView from '@/views/SearchView.vue';
import ProfileView from '@/views/ProfileView.vue';

import MessageView from '@/views/MessageView.vue'; // more 'conversational' view of messages
import MessagesView from '@/views/MessagesView.vue'; // list of users sent you a message, click on a user to see the messages

import RegisterView from '@/views/RegisterView.vue';
import LoginView from '@/views/LoginView.vue';
import LogoutView from '@/views/LogoutView.vue';
import NotFoundView from '@/views/NotFoundView.vue';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
  },
  {
    path: '/users/:id',
    children: [
      {
        path: '',
        component: UserView,
      },
    ],
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView,
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView,
  },
  {
    path: '/logout',
    name: 'logout',
    component: LogoutView,
  },
  {
    path: '/search',
    name: 'search',
    component: SearchView,
  },
  {
    path: '/profile',
    name: 'profile',
    component: ProfileView,
  },
  {
    path: '/messages',
    name: 'messages',
    component: MessagesView,
  },
  {
    path: '/messages/:id',
    children: [
      {
        path: '',
        component: MessageView,
      },
    ],
  },
  {
    path: '/:catchAll(.*)',
    component: NotFoundView,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
