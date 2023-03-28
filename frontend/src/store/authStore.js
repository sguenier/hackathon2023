import Cookies from 'js-cookie';
import { defineStore } from 'pinia';

import $API from '@/plugins/axios';

export const useAuthStore = defineStore('authStore', {
  state: () => ({
    isLogged: false,
    isLoginLoading: false,
    ephemeralToken: '',
    isRegisterLoading: false,
  }),

  actions: {
    async login(form) {
      this.ephemeralToken = '';
      this.isLoginLoading = true;
      try {
        const { data } = await $API.post('auth/login/', form);
        if (data.auth_token) {
          this.isLogged = true;
          Cookies.set(
            import.meta.env.VITE_COOKIE_TOKEN_NAME,
            data.auth_token,
            {
              expires: parseFloat(import.meta.env.VITE_COOKIE_TOKEN_DURATION, 10),
              secure: true,
            },
          );
        } else {
          this.ephemeralToken = data.ephemeral_token;
        }
        this.isLoginLoading = false;
        return data;
      } catch (error) {
        this.isLogged = false;
        this.isLoginLoading = false;
        throw error;
      }
    },

    async register(form) {
      this.isRegisterLoading = true;
      try {
        const { data } = await $API.post('auth/register/', form);
        this.isRegisterLoading = false;
        return data;
      } catch (error) {
        this.isRegisterLoading = false;
        throw error;
      }
      
    },

    async logout(apiCall = true) {
      this.isLogged = false;
      try {
        if (apiCall) {
          await $API.post('auth/logout/');
        }
        Cookies.remove(import.meta.env.VITE_COOKIE_TOKEN_NAME);
      } catch (error) {
        Cookies.remove(import.meta.env.VITE_COOKIE_TOKEN_NAME);
        throw error;
      }
    },

    initLogged() {
      this.isLogged = !!Cookies.get(import.meta.env.VITE_COOKIE_TOKEN_NAME);
    },
  },
});
