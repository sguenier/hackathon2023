<template>
  <div class="exercice">
    <h2>Exercice</h2>
    <h3>{{ exercice.name }}</h3>
    <iframe
      class="exercice__video"
      :src="'https://www.youtube.com/embed/' + exercice.urlyoutube"
      title="YouTube video player"
      frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
      allowfullscreen
    />
    <div class="exercice__content">
      <div class="exercice__tags">
        <span
          v-for="tag in exercice.Tag"
          :key="tag.id"
        >
          {{ tag.name }}
          <span v-if="exercice.Tag.indexOf(tag) !== exercice.Tag.length - 1"> - </span>
        </span>
      </div>
      <div class="exercice__infos">
        <div class="exercice__card">
          <vue-feather
            type="clock"
            size="24"
            class="exercice__duration-icon"
          />
          <span>{{ duration }} minutes</span>
          <vue-feather
            type="chevron-right"
            size="24"
            class="exercice__duration-chevron"
          />
        </div>
        <div class="exercice__card" >
          <vue-feather
            type="clipboard"
            size="24"
            class="exercice__categorie-icon"
          />
          <span>{{ exercice.equipment }}</span>
          <vue-feather
            type="chevron-right"
            size="24"
            class="exercice__categorie-chevron"
          />
        </div>
      </div>
      <p>{{ exercice.description }}</p>
    </div>
    <div class="exercice__start">
      <button class="exercice__start__button">DÉMARRER L’ENTRAINEMENT</button>
    </div>
  </div>
</template>

<script>
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useExerciceStore } from '@/store/exerciceStore';

export default {
  name: 'Exercice',
  setup(){
    const router = useRouter();
    const exerciceStore = useExerciceStore();

    const exercice = computed(() => exerciceStore.exercice);
    const duration = computed(() => Math.floor(exercice.value.duration / 60));
    const categorie = computed(() => exerciceStore.categorie);

    onMounted( async() => {
      await exerciceStore.getExercice(router.currentRoute.value.params.id);
      exerciceStore.getCategorie(exercice.value.categorie);
    });

    return {
      exercice,
      duration,
      categorie,
    };
  },
};
</script>

<style lang="scss" scoped>
.exercice {
  &__video {
    width: 650px;
    height: 410px;
    border-radius: 8px;
  }

  &__content {
    border: 1px solid var(--color-background-disable);
    box-shadow: 0px 2px 4px rgba(23, 43, 77, 0.15);
    border-radius: 8px;
    padding: 30px 1rem;
  }

  &__infos {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    flex-wrap: wrap;
  }
  &__card {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    width: fit-content;
    border: 1px solid var(--color-background-disable);
    box-shadow: 0px 2px 4px rgba(23, 43, 77, 0.15);
    border-radius: 1rem;
    padding: 12px 9px;
    span {
      margin: 0 1rem;
    }
  }
  &__start {
    background-color: var(--text-white);
    padding: 12px 0;
    display: flex;
    justify-content: center;
    &__button {
      background-color: var(--color-turquoise-light);
      text-transform: uppercase;
      font-size: 13px;
      padding: 12px 35px;
      border: none;
    }
    &__button:hover {
      cursor: pointer;
      background-color: var(--color-turquoise-lighter);
    }
  }
  @media (max-width: 768px) {
    &__video {
      width: 100%;
      height: 200px;
    }
  }
}
</style>
