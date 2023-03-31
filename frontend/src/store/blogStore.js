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
      // const { data } = await $API.get('posts/');
      const data = [
        {
          id: 1,
          title: 'Post 1',
          image: 'https://picsum.photos/200/300',
          content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
        },
        {
          id: 2,
          title: 'Post 2',
          image: 'https://picsum.photos/200/300',
          content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
        },
        {
          id: 3,
          title: 'Post 3',
          image: 'https://picsum.photos/200/300',
          content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
        },
        {
          id: 4,
          title: 'Post 4',
          image: 'https://picsum.photos/200/300',
          content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
        },
        {
          id: 5,
          title: 'Post 5',
          image: 'https://picsum.photos/200/300',
          content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
        },
        {
          id: 6,
          title: 'Post 6',
          image: 'https://picsum.photos/200/300',
          content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
        },
        {
          id: 7,
          title: 'Post 7',
          image: 'https://picsum.photos/200/300',
          content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
        },
        {
          id: 8,
          title: 'Post 8',
          image: 'https://picsum.photos/200/300',
          content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl',
        },
      ];
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
  },
});
