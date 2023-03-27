import { defineStore } from 'pinia';

import $API from '@/plugins/axios';

export const useBlogStore = defineStore('blogStore', {
  state: () => ({
    post: {},
    isPostLoading: false,
  }),

  actions: {
    async getPost(id) {
      this.isPostLoading = true;
      const { data } = await $API.get(`posts/${id}`);
      this.post = data;
      this.isPostLoading = false;
      
      return await data;
    }
  },
})
