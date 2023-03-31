<template>
  <div class="advice">
    <h2>{{ advice.title }}</h2>
    <img
      class="advice__image"
      :src="advice.image"
      :alt="advice.title"
    >
    <div class="advice__infos">
      <span>John Doe</span>
      <span> - </span>
      <span v-if="advice.created_at"> {{ new Date(advice.created_at.date) }} </span>
    </div>
    <p class="advice__content">{{ advice.content }}</p>
    <div
      class="advice__tags"
      v-if="advice.Tag"
    >
      <span 
        v-for="tag in advice.Tag"
        :key="tag"
      >
        {{ tag.name }}
        <span v-if="advice.Tag.indexOf(tag) !== advice.Tag.length - 1"> - </span>
      </span>
    </div>
  </div>
</template>

<script>
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useBlogStore } from '@/store/blogStore';

export default {
  name: 'Advice',
  setup(){
    const router = useRouter();
    const adviceStore = useBlogStore();

    const advice = computed(() => adviceStore.post);

    onMounted( async() => {
      await adviceStore.getPost(router.currentRoute.value.params.id);
    });

    return {
      advice,
    };
  },
};
</script>

<style lang="scss" scoped>
.advice {
  &__image{
    margin: 28px auto 28px auto;
    display: flex;
  }
  &__infos {
    font-size: 14px;
    font-style: italic;
  }
  &__content {
    font-size: 14px;
  }
  &__tags {
    font-size: 14px;
    font-style: italic;
  }
}
</style>
