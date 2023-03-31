<template>
  <div class="exercices">
    <h2 class="exercices__title">Exercices</h2>
    <p class="exercices__filter">Filtrer par :</p>
    <el-select
      v-model="filter"
      placeholder="Choisissez"
      @change="onFilterChange"
    >
      <el-option
        v-for="item in tags"
        :key="item.id"
        :label="item.name"
        :value="item.id"
      />
    </el-select>

    <div class="exercices__list">
      <exercice
        v-for="exercice in exercices"
        :key="exercice.id"
        :title="exercice.name"
        image="https://picsum.photos/200/300"
        :id="exercice.id"
        @click="cardClick"
      />
      <p v-if="exercices.length ===0"> Aucun exercice</p>
    </div>

  </div>
</template>

<script>
import {
  computed,
  onMounted,
  ref,
} from 'vue';

import { useRouter } from 'vue-router';

import Exercice from '@/components/Card.vue';
import { useExerciceStore } from '@/store/exerciceStore';
import { useTagStore } from '@/store/tagStore';

export default {
  name: 'Exercices',
  components: {
    Exercice,
  },
  setup() {
    const router = useRouter();
    const exercicesStore = useExerciceStore();
    const tagsStore = useTagStore();
    const filter = ref(0);

    let tags = computed(() => tagsStore.tags);
    // get tags and add one tag value : 0 and name : tous
    tags = computed(() => {
      const tags = tagsStore.tags;
      tags.unshift({ id: 0, name: 'Tous' });
      return tags;
    });
    const exercices = computed(() => exercicesStore.exercices);

    onMounted(() => {
      exercicesStore.getExercices(filter.value);
      tagsStore.getTags();
    });

    const onFilterChange = () => {
      exercicesStore.getExercices(filter.value);
    };

    const cardClick = (id) => {
      router.push({ name: 'exercice', params: { id } });
    };

    return {
      tags,
      filter,
      exercices,
      onFilterChange,
      cardClick,
    };

    
  },
};
</script>

<style lang="scss" scoped>
.exercices {
  &__form {
    margin-top: 1.8rem;
  }

  &__list {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    gap: 32px;
    margin-top: 32px;
  }
}
</style>
