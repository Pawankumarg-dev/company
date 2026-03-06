import { createWebHistory, createRouter } from "vue-router";
import Home from "../components/Home.vue";
import Signin from "../components/Signin.vue";
import NewIncident from '../components/Incident/Create'

const routes = [
  {
    path: "/home",
    name: "home",
    component: Home,
  },
  {
    path: "/auth/login",
    name: "signin",
    component: Signin,
  },
  {
    path: "/incident/create",
    name: "newincident",
    component: NewIncident,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;