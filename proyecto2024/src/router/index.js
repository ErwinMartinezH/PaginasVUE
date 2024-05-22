import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import MainPage from '@/views/MainPage.vue';

//const createPage = (page) => () => import(`../views/${page}.vue`);

const routes = [
  { path: '/', redirect: '/loginAuth' },
  { path: '/loginAuth', component: Login },
  { path: '/register', component: Register },
  { path: '/main', component: MainPage}
  //{ path: '/main', component: createPage('MainPage') }
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

export default router;
