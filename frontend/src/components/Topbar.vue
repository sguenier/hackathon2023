<template>
  <header class="topbar">
    <font-awesome-icon icon="bars" class="topbar__menu" />
    <router-link to="/">
      <img class="topbar__logo" src="@/assets/logo.svg" alt="Jajic" />
    </router-link>
    <div class="topbar__container">
      <font-awesome-icon icon="magnifying-glass" class="topbar__search" />
      <div class="topbar__avatar" ></div>
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
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;

  &__menu {
    color: var(--text-secondary);
  }

  &__menu:hover {
    cursor: pointer;
    color: var(--text-primary);
  }

  &__logo {
    max-height: 2.5rem;
  }

  &__container {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
  }

  &__avatar {
    width: 2rem;
    height: 2rem;
    background-color: var(--color-border);
    border-radius: 1rem;
  }

  &__search {
    color: var(--text-secondary);
    margin-right: 1rem;
  }

  &__search:hover {
    cursor: pointer;
    color: var(--text-primary);
  }
  
}

</style>