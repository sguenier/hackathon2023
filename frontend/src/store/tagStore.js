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
        const { data } = await $API.get('admin/tag/');
        this.tags = data;
        this.isTagsLoading = false;
        return data;
      } catch (error) {
        this.isTagsLoading = false;
        throw error;
      }
    },
  },
});
