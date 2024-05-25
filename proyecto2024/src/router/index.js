import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import MainPage from "@/views/MainPage.vue";
import AboutUs from "@/views/AboutUs.vue";
import Grupos from "@/views/Grupos.vue";
import GruposDisponible from "@/views/GruposDisponibles.vue";
import PasarLista from "@/views/PasarLista.vue";
import VerAsistencia from "@/views/VerAsistencia.vue";

const routes = [
  { path: "/", redirect: "/loginAuth" },
  { path: "/loginAuth", component: Login },
  { path: "/register", component: Register },
  { path: "/main", component: MainPage },
  { path: "/:catchAll(.*)", redirect: "/loginAuth" },
  { path: "/about", component: AboutUs },
  { path: "/grupos", component: Grupos },
  { path: "/gruposDisponibles", component: GruposDisponible },
  { path: "/pasarLista", component: PasarLista },
  { path: "/verAsistencia", component: VerAsistencia },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
