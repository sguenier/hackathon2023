import { defineStore } from 'pinia';

import $API from '@/plugins/axios';
import { useAuthStore } from '@/store/authStore';

export const useProfileStore = defineStore('profileStore', {
  state: () => ({
    profile: {},
    isProfileLoading: false,
  }),

  actions: {
    async getProfile() {
      this.isProfileLoading = true;
      try {
        // uncomment to fake long request for showing app loading
        await new Promise((resolve) => setTimeout(resolve, 800));
        const { data } = await $API.get('admin/user/profile/');
        this.profile = data.user;
        this.isProfileLoading = false;
        return data;
      } catch (error) {
        if (error.response.status === 404) {
          useAuthStore().logout();
        }
        this.isProfileLoading = false;
        throw error;
      }
    },
  },
});
