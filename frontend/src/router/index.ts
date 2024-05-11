import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import HomeView from "../views/HomeView.vue";
import AboutView from "../views/AboutView.vue";
import UserView from "../views/UserView.vue";
import UsersView from "../views/UsersView.vue";
import MessageView from "../views/MessageView.vue";
import MessagesView from "../views/MessagesView.vue";
import NotFoundView from "../views/NotFoundView.vue";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/about",
    name: "about",
    component: AboutView,
  },
  {
    path: "/users",
    name: "users",
    component: UsersView,
  },
  {
    path: "/user/:id",
    children: [
      {
        path: "",
        component: UserView,
      },
    ],
  },
  {
    path: "/messages",
    name: "messages",
    component: MessagesView,
  },
  {
    path: "/message/:id",
    children: [
      {
        path: "",
        component: MessageView,
      },
    ],
  },
  {
    path: "/:catchAll(.*)",
    component: NotFoundView,
  },
];
// put a link to profile in the user view

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
