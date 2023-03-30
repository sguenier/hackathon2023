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
        v-for="item in categories"
        :key="item.id"
        :label="item.title"
        :value="item.id"
      />
    </el-select>

    <div class="exercices__list">
      <exercice
        v-for="exercice in exercices"
        :key="exercice.id"
        :title="exercice.title"
        :image="exercice.image"
      />
    </div>

  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import Exercice from '@/components/Card.vue';
import { useExerciceStore } from '@/store/exerciceStore';

export default {
  name: 'Exercices',
  components: {
    Exercice,
  },
  setup() {
    const exercicesStore = useExerciceStore();
    const filter = ref(0);

    const categories = computed(() => exercicesStore.categories);
    const exercices = computed(() => exercicesStore.exercices);

    onMounted(() => {
      exercicesStore.getExercices(filter.value);
      exercicesStore.getCategories();
    });

    const onFilterChange = () => {
      exercicesStore.getExercices(filter.value);
    };

    return {
      categories,
      filter,
      exercices,
      onFilterChange,
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
