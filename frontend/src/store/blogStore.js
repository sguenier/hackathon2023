import { defineStore } from 'pinia';

import $API from '@/plugins/axios';

export const useBlogStore = defineStore('blogStore', {
  state: () => ({
    advises: [],
    isAdvisesLoading: false,
    post: {},
    isPostLoading: false,
  }),

  actions: {
    async getAdvises() {
      this.isPostsLoading = true;
      const { data } = await $API.get('admin/posts/');
      await new Promise((resolve) => setTimeout(resolve, 300));
      this.advises = data;
      this.isAdvisesLoading = false;

      return data;
    },

    async getPost(id) {
      this.isPostLoading = true;
      const { data } = await $API.get(`admin/post/${id}/`);
      await new Promise((resolve) => setTimeout(resolve, 300));
      this.post = data;
      this.isPostLoading = false;
      
      return data;
    },

    async deletePost(id) {
      await $API.delete(`admin/post/${id}/`);
      this.advises = this.advises.filter((post) => post.id !== id);
      return true;
    },

    async createPost(form) {
      const { data } = await $API.post('admin/post/new/', form);
      this.getAdvises();
      return data;
    },
  },
});
