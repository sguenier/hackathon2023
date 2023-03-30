<template>
  <div class="exercice">
    <h2>Exercice</h2>
    <h3>{{ exercice.title }}</h3>
    <iframe
      class="exercice__video"
      :src="exercice.video"
      title="YouTube video player"
      frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
      allowfullscreen
    />
    <div class="exercice__content">
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
          <span>{{ exercice.categorie }}</span>
          <vue-feather
            type="chevron-right"
            size="24"
            class="exercice__categorie-chevron"
          />
        </div>
      </div>
      <p>{{ exercice.content }}</p>
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

    onMounted(() => {
      exerciceStore.getExercice(router.currentRoute.value.params.id);
    });

    return {
      exercice,
      duration,
    };
  },
};
</script>

<style lang="scss" scoped>
.exercice {
  &__video {
    width: 100%;
    height: 210px;
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
}
</style>
