import { defineStore } from 'pinia';

import $API from '@/plugins/axios';

export const useTagStore = defineStore('tagStore', {
  state: () => ({
    /**
     * @type {{id: string, name: string}[]}
     */
    tags: [],
    isTagsLoading: false,
  }),

  actions: {
    async getTags() {
      this.isTagsLoading = true;
      try {
        // uncomment to fake long request for showing app loading
        // await new Promise((resolve) => setTimeout(resolve, 800));
        const { data } = await $API.get('admin/tags/');
        this.tags = data;
        this.isTagsLoading = false;
        return data;
      } catch (error) {
        this.isTagsLoading = false;
        throw error;
      }
    },
    async deleteTag(id) {
      await $API.delete(`admin/tag/${id}/`);
      this.tags = this.tags.filter((tag) => tag.id !== id);
      return true;
    },
    async createTag(form) {
      const { data } = await $API.post('admin/tag/', form);
      this.getTags();
      return data;
    },
  },
});
