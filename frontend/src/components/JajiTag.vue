<template>
  <button
    class="jaji-tag"
    :class="{
      'jaji-tag--selected': isSelected,
    }"
    @click="$emit('click', value)"
  >
    <span class="jaji-tag__label">{{ label }}</span>
  </button>
</template>

<script>
export default {
  name: 'JajiTag',
  emits: [ 'click' ],
  props: {
    label: {
      type: String,
      required: true,
    },
    value: {
      type: Number,
      required: true,
    },
    isSelected: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style lang="scss" scoped>
.jaji-tag {
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: var(--color-blue-action);
  border: none;
  border-radius: 8px;
  color: white;
  padding: 12px 24px;

  &--selected, &:hover {
    background-color: var(--color-blue-hover);
  }
}
</style>