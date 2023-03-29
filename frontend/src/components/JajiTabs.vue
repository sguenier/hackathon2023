<template>
  <div class="jaji-tabs">
    <button
      v-for="{ label, value } in tabs"
      :key="value"
      @click="tabChange(value)"
      class="jaji-tabs__tab"
      :class="{ 'jaji-tabs__tab--active': modelValue === value }"
    >
      {{ label }}
    </button>
  </div>
</template>

<script>
export default {
  name: 'JajiTabs',
  emits: [ 'update:modelValue' ],
  props: {
    /**
     * The tabs to display.
     * @type {{ label: string, value: string }[]}
     */
    tabs: {
      type: Array,
      required: true,
    },
    /**
     * The value of the selected tab.
     * @type {string}
     */
    modelValue: {
      type: String,
      required: true,
    },
  },
  setup(props, { emit }) {
    const tabChange = (value) => {
      emit('update:modelValue', value);
    };

    return {
      tabChange,
    };
  },
};
</script>

<style lang="scss" scoped>
.jaji-tabs {
  display: flex;
  border-bottom: 1px solid var(--text-placeholder);

  &__tab {
    all: unset;
    cursor: pointer;
    color: var(--text-primary-light);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    flex-grow: 1;

    &--active {
      overflow: hidden;
      color: var(--color-blue-action);
      position: relative;

      &::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 0;
        right: 0;
        height: 8px;
        background-color: var(--color-blue-action);
        border-radius: 4px;
      }
    }
  }
}
</style>
