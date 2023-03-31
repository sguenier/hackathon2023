import {
  createRouter,
  createWebHistory,
} from 'vue-router';

import { useAuthStore } from '@/store/authStore';

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
    },
    {
      path: '/register',
      name: 'register',
      redirect: () => ({ name: 'register-base' }),
      component: () => import('@/views/Register.vue'),
      children: [
        {
          path: 'base',
          name: 'register-base',
          component: () => import('@/views/Register/RegisterBase.vue'),
        },
        {
          path: 'personal',
          name: 'register-personal',
          component: () => import('@/views/Register/RegisterPersonal.vue'),
          beforeEnter: (to, from, next) => {
            if (from.name === 'register-base' || from.name === 'register-care') {
              next();
            } else {
              next({ name: 'register-base' });
            }
          },
        },
        {
          path: 'care',
          name: 'register-care',
          component: () => import('@/views/Register/RegisterCare.vue'),
          beforeEnter: (to, from, next) => {
            if (from.name === 'register-personal' || from.name === 'register-tags') {
              next();
            } else {
              next({ name: 'register-personal' });
            }
          },
        },
        {
          path: 'tags',
          name: 'register-tags',
          component: () => import('@/views/Register/RegisterTags.vue'),
          beforeEnter: (to, from, next) => {
            if (from.name === 'register-care') {
              next();
            } else {
              next({ name: 'register-care' });
            }
          },
        },
      ],
    },
    {
      path: '/profile',
      name: 'profile',
      component: () => import('@/views/Profile.vue'),
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
    {
      path: '/exercice/:id',
      name: 'exercice',
      component: () => import('@/views/Exercice.vue'),
    },
    // {
    //   path: '/:pathMatch(.*)*',
    //   name: 'not-found',
    //   component: () => import('@/views/NotFound.vue'),
    // },
  ],
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  if (authStore.isLogged) {
    next();
  } else if (to.name === 'login' || to.name.startsWith('register')) {
    next();
  } else {
    next({ name: 'login' });
  }
});

export default router;
