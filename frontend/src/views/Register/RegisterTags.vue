<template>
  <div class="register-tags">
    <jaji-tag
      v-for="tag in tags"
      :key="tag.id"
      :value="tag.id"
      :label="tag.name"
      :is-selected="form.tags?.includes(tag.id)"
      @click="toggleTag(tag)"
    />
    <div class="register-tags__buttons">
      <el-button
        size="large"
        @click="$emit('previous')"
      >Précedent</el-button>
      <el-button
        type="primary"
        size="large"
        @click="$emit('submit');"
      >S'inscrire</el-button>
    </div>
  </div>
</template>

<script>
import {
  computed,
  onMounted,
  ref,
  watch,
} from 'vue';

import JajiTag from '@/components/JajiTag.vue';
import { useTagStore } from '@/store/tagStore';

export default {
  name: 'RegisterBase',
  components: {
    JajiTag,
  },
  emits: [
    'previous',
    'next',
    'update:modelValue',
    'submit',
  ],
  props: {
    modelValue: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props, { emit }) {
    const form = ref(props.modelValue);
    const tagStore = useTagStore();

    onMounted(() => {
      tagStore.getTags();
      form.value.tags = [];
    });

    const tags = computed(() => tagStore.tags);

    watch(
      () => form.value,
      (value) => {
        emit('update:modelValue', value);
      },
    );

    const toggleTag = ({ id }) => {
      if (form.value.tags.includes(id)) {
        form.value.tags = form.value.tags.filter((tagId) => tagId !== id);
      } else {
        form.value.tags.push(id);
      }
    };

    return {
      tags,
      form,
      toggleTag,
    };
  },
};
</script>

<style lang="scss" scoped>
.register-tags {
  padding: 0 48px;
  display: flex;
  flex-wrap: wrap;
  gap: 8px;

  &__buttons {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    margin-top: 16px;
  }
}
</style>