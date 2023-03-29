<template>
  <header class="topbar">
    <font-awesome-icon icon="bars" class="topbar__menu" />
    <img class="topbar__logo" src="@/assets/logo.svg" alt="Jajic" />
    <div>
      <font-awesome-icon icon="magnifying-glass" class="topbar__search" />

    </div>
  </header>
</template>

<script>

export default {
  name: 'Topbar',
};

</script>

<style lang="scss" scoped>
.topbar {
  background-color: var(--color-background);
  width: 100%;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;

  &__menu {

  }
  &__logo {
    max-height: 2.5rem;
  }
}

</style>