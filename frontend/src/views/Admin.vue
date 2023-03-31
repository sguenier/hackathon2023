

<template>
  <div class="admin">
    <h1>Bienvenue sur votre backoffice</h1>
    <jaji-tabs
      :tabs="tabs"
      v-model="selectedTabValue"
      @change="$router.push({ name: `admin-${$event}` })"
    />
    <div class="admin__view">
      <router-view />
    </div>
  </div>
</template>

<script>
import {
  onMounted,
  ref,
} from 'vue';

import { useRoute } from 'vue-router';

import JajiTabs from '@/components/JajiTabs.vue';

export default {
  name: 'Admin',
  components: {
    JajiTabs,
  },
  setup() {
    const route = useRoute();
    const selectedTabValue = ref('tags');
    const tabs = [
      { label: 'Tags', value: 'tags' },
      { label: 'Exercices', value: 'exercices' },
      { label: 'Conseils', value: 'posts' },
    ];

    onMounted(() => {
      const currentRouteName = route.name;
      selectedTabValue.value = currentRouteName.split('-')[1];
    });

    return { tabs, selectedTabValue };
  },
};
</script>

<style lang="scss" scoped>
.admin {
  &__view {
    margin-top: 2rem;
  }
}
</style>