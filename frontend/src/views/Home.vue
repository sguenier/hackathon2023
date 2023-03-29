<template>
  <main>
    <h2>Home</h2>
  </main>
</template>

<script>
import {
  computed,
  onMounted,
} from 'vue';

import { useBlogStore } from '@/store/blogStore';

export default {
  name: 'Home',
  setup() {
    const blogStore = useBlogStore();

    onMounted(async () => {
      // await blogStore.getPost(1);
    });

    const post = computed(() => blogStore.post);
    const isPostLoading = computed(() => blogStore.isPostLoading);
    return {
      blogStore,
      post,
      isPostLoading,
    };
  },
};
</script>
