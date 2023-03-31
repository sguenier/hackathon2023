<template>
  <div class="home">
    <h1 class="left">Bienvenue, {{ profile.firstname }}</h1>
    <h2 class="left">Mes programmes</h2>
    <!-- <router-link :to="{ name: 'programs' }">Voir tout les programes</router-link> -->
    <div class="home__programs">
      <card
        v-for="program in programs"
        :key="program.id"
        :image="program.image"
        :title="program.name"
        :id="program.id"
        :isLarge="true"
        @click="programCardClick"
      />
    </div>
    <h2 class="left">Mes conseils santé</h2>
    <router-link :to="{ name: 'advises' }">Voir tout les conseils</router-link>
    <div class="home__advices">
      <card
        v-for="program in programs"
        :key="program.id"
        :image="program.image"
        :title="program.name"
        :id="program.id"
        @click="adviseCardClick"
      />
    </div>
  </div>
</template>

<script>
import {
  computed,
  onMounted,
} from 'vue';

import Card from '@/components/Card.vue';
import { useBlogStore } from '@/store/blogStore';
import { useProfileStore } from '@/store/profileStore';
import { useProgramStore } from '@/store/programStore';

export default {
  name: 'Home',
  components: {
    Card,
  },
  setup() {
    const programStore = useProgramStore();
    const blogStore = useBlogStore();
    const profileStore = useProfileStore();

    onMounted(async () => {
      await programStore.getPrograms();
    });

    const profile = computed(() => profileStore.profile);
    const programs = computed(() => programStore.programs);

    const isPostLoading = computed(() => blogStore.isPostLoading);

    const programCardClick = (id) => {
      // router.push({ name: 'program', params: { id } });
    };

    return {
      profile,
      blogStore,
      programs,
      isPostLoading,
      programCardClick,
    };
  },
};
</script>

<style lang="scss" scoped>
.home {
  display: flex;
  flex-direction: column;
  
  &__programs, &__advices {
    margin-top: 2rem;
    margin-bottom: 2rem;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    overflow-x: auto;
    width: 100%;
    gap: 1.5rem;
  }
}
</style>
