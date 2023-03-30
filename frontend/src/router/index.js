import {
  createRouter,
  createWebHistory,
} from 'vue-router';

import { useAuthStore } from '@/store/authStore';

const isNotLogged = (to, from, next) => {
  const authStore = useAuthStore();
  if (authStore.isLogged) {
    next({ name: 'home' });
  } else {
    next();
  }
};

const isLogged = (to, from, next) => {
  const authStore = useAuthStore();
  if (authStore.isLogged) {
    next();
  } else {
    next({ name: 'login' });
  }
};

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('@/views/Home.vue'),
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('@/views/Login.vue'),
      beforeEnter: isNotLogged,
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('@/views/Register.vue'),
      beforeEnter: isNotLogged,
    },
    {
      path: '/profile',
      name: 'profile',
      component: () => import('@/views/Profile.vue'),
      beforeEnter: isLogged,
      children: [
        {
          path: 'edit',
          name: 'profileEdit',
          component: () => import('@/views/ProfileEdit.vue'),
        },
      ],
    },
    {
      path: '/form',
      name: 'formExample',
      component: () => import('@/views/FormExample.vue'),
    },
    {
      path: '/advises',
      name: 'advises',
      component: () => import('@/views/Advises.vue'),
    },
    {
      path: '/exercices',
      name: 'exercices',
      component: () => import('@/views/Exercices.vue'),
    },
    // {
    //   path: '/:pathMatch(.*)*',
    //   name: 'not-found',
    //   component: () => import('@/views/NotFound.vue'),
    // },
  ],
});

export default router;
