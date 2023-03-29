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
        const { data } = await $API.post('admin/user/login/', form);
        if (data.token) {
          this.isLogged = true;
          Cookies.set(
            import.meta.env.VITE_COOKIE_TOKEN_NAME,
            data.token,
            {
              expires: parseFloat(import.meta.env.VITE_COOKIE_TOKEN_DURATION, 10),
              secure: true,
            },
          );
        } else {
          throw new Error('No token found');
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
        const { data } = await $API.post('admin/user/createuser/', form);
        this.isRegisterLoading = false;
        return data;
      } catch (error) {
        this.isRegisterLoading = false;
        throw error;
      }
      
    },

    async logout() {
      this.isLogged = false;
      try {
        Cookies.remove(import.meta.env.VITE_COOKIE_TOKEN_NAME);
      } catch (error) {
        Cookies.remove(import.meta.env.VITE_COOKIE_TOKEN_NAME);
        throw error;
      }
    },

    init() {
      const token = Cookies.get(import.meta.env.VITE_COOKIE_TOKEN_NAME);
      if (token) {
        this.isLogged = true;
      }
    },
    
  },
});
