import { defineStore } from 'pinia';

import $API from '@/plugins/axios';

export const useProfileStore = defineStore('profileStore', {
  state: () => ({
    profile: {},
    isProfileLoading: false,
  }),

  actions: {
    async getProfile() {
      this.isProfileLoading = true;
      try {
        const { data } = await $API.get('admin/user/profile/');
        this.profile = data;
        this.isProfileLoading = false;
        return data;
      } catch (error) {
        this.isProfileLoading = false;
        throw error;
      }
    },
  },
});
