<template>
  <header class="topbar">
    <vue-feather
      class="topbar__menu"
      size="24"
      type="menu"
    />
    <router-link to="/">
      <img
        class="topbar__logo"
        src="@/assets/logo.svg"
        alt="Jajic"
      >
    </router-link>
    <div class="topbar__container">
      <vue-feather
        class="topbar__search"
        size="24"
        type="search"
      />
      <div
        v-if="isLogged"
        class="topbar__avatar"
      />
      <div
        v-else
        class="topbar__login"
      >
        <router-link
          class="topbar__login"
          to="/login"
        >Login</router-link>
      </div>
    </div>
  </header>
</template>

<script>
import { useAuthStore } from '@/store/authStore';
import { computed } from 'vue';

export default {
  name: 'Topbar',

  setup() {
    const authStore = useAuthStore();

    const isLogged = computed(() => authStore.isLogged);

    return {
      isLogged,
    }
  },

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

  &__login {
    color: var(--text-secondary);
    text-decoration: none;
  }

  &__login:hover {
    color: var(--text-primary);
    text-decoration: underline;
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