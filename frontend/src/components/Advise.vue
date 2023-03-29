<template>
  <div
    class="advise"
    @click="$emit('click')"
  >
    <img
      class="advise__image"
      :src="image"
      :alt="title"
    >
    <span class="advise__title" >{{ title }}</span>
  </div>
</template>

<script>
export default {
  name: 'Advise',
  emits: [ 'click' ],
  props: {
    /**
     * The image of the advise.
     * @type {string}
     */
    image: {
      type: String,
      required: true,
    },
    /**
     * The title of the advise.
     * @type {string}
     */
    title: {
      type: String,
      required: true,
    },
  },
};
</script>

<style lang="scss" scoped>
.advise {
  display: flex;
  flex-direction: column;
  gap: 12px;
  cursor: pointer;

  &__image {
    width: 160px;
    height: 160px;
    object-fit: cover;
    border: 1px solid var(--color-background-disabled);
    border-radius: 8px;
    box-shadow: 0px 2px 4px rgba(23, 43, 77, 0.15);
    opacity: 1;
    transition: opacity 0.2s ease-in-out;
  }

  &__title {
    padding: 0 12px;
    font-size: 16px;
    font-weight: 500;
    color: var(--text-primary-light);
    text-decoration: none;
    transition: text-decoration 0.2s ease-in-out;
  }

  &:hover {
    .advise__image {
      opacity: 0.8;
    }

    .advise__title {
      text-decoration: underline;
    }
  }
}
</style>