<template>
  <div class="advises">
    <h2>Conseils</h2>
    <jaji-tabs
      :tabs="filteredTabs"
      v-model="selectedTabValue"
    />
    <div class="advises__list">
      <advise
        v-for="advise in advises"
        :key="advise.id"
        :image="advise.image"
        :title="advise.title"
      />
    </div>
  </div>
</template>

<script>
import {
  computed,
  onMounted,
  ref,
} from 'vue';

import Advise from '@/components/Card.vue';
import JajiTabs from '@/components/JajiTabs.vue';
import { useAuthStore } from '@/store/authStore';
import { useBlogStore } from '@/store/blogStore';

export default {
  name: 'Advises',
  components: {
    Advise,
    JajiTabs,
  },
  setup() {
    const blogStore = useBlogStore();
    const authStore = useAuthStore();
    const tabs = [ { label: 'Pour Vous', value: 'custom', mustBeLogged: true }, { label: 'Actualité Santé', value: 'actuality' } ];
    const selectedTabValue = ref('custom');

    const isLogged = computed(() => authStore.isLogged);
    const filteredTabs = computed(() => tabs.filter((tab) => tab.mustBeLogged ? isLogged.value : true));

    onMounted(() => {
      if (!isLogged.value) {
        selectedTabValue.value = 'actuality';
      }
      blogStore.getAdvises();
    });

    const advises = computed(() => blogStore.advises);

    return {
      isLogged,
      advises,
      filteredTabs,
      selectedTabValue,
    };
  },
};
</script>

<style lang="scss" scoped>
.advises {
  display: flex;
  flex-direction: column;
  height: 100%;

  &__list {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    gap: 32px;
    margin-top: 32px;
  }
}
</style>
