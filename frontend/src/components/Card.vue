<template>
  <router-link
    class="link"
    :to="{ name: name, params: { id: id } }"
  >
    <div
      class="card"
      @click="$emit('click')"
    >
      <img
        class="card__image"
        :src="image"
        :alt="title"
      >
      <span class="card__title" >{{ title }}</span>
    </div>
  </router-link>
</template>

<script>
export default {
  name: 'Card',
  emits: [ 'click' ],
  props: {
    /**
     * The image of the card.
     * @type {string}
     */
    image: {
      type: String,
      required: true,
    },
    /**
     * The title of the card.
     * @type {string}
     */
    title: {
      type: String,
      required: true,
    },
    name: {
      type: String,
      required: false,
    },
    id: {
      type: Number,
      required: false,
    },
  },
};
</script>

<style lang="scss" scoped>
.link {
  text-decoration: none;
}
.card {
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
    .card__image {
      opacity: 0.8;
    }

    .card__title {
      text-decoration: underline;
    }
  }
}
</style>