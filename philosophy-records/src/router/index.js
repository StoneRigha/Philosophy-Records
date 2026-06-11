import { createRouter, createWebHistory } from "vue-router";
import LoginView from "../views/LoginView.vue";
import HomeView from "../views/HomeView.vue";
import CatalogView from "../views/CatalogView.vue";
import HRTheMessengerView from "../views/HRTheMessengerView.vue";
import LordArnoldView from "../views/LordArnoldView.vue";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      name: "login",
      component: LoginView,
    },
    {
      path: "/home",
      name: "home",
      component: HomeView,
    },
    {
      path: "/catalog",
      name: "catalog",
      component: CatalogView,
    },
    {
      path: "/hr-the-messenger",
      name: "hr-the-messenger",
      component: HRTheMessengerView,
    },
    {
      path: "/lord-arnold",
      name: "lord-arnold",
      component: LordArnoldView,
    },
  ],
});

export default router;