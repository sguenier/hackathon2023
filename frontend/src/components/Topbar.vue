<template>
  <header class="topbar">
    <div class="topbar__menu" />
    <router-link
      to="/"
      class="topbar__logo"
    >
      <img
        class="topbar__logo__image"
        src="@/assets/logo.svg"
        alt="Jajic"
      >
    </router-link>
    <div class="topbar__container">
      <button @click="logout">LOGOUT</button>
      <vue-feather
        class="topbar__search"
        size="24"
        type="search"
      />
      <router-link
        :to="{ name: 'profile' }"
        v-if="isLogged"
        class="topbar__user"
      >
        <div
          class="topbar__user__avatar"
        />
        <span class="topbar__user__name">{{ profile.firstname }} {{ profile.lastname }}</span>
      </router-link>
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
import { computed } from 'vue';

import { useAuthStore } from '@/store/authStore';
import { useProfileStore } from '@/store/profileStore';

export default {
  name: 'Topbar',

  setup() {
    const authStore = useAuthStore();
    const profileStore = useProfileStore();

    const isLogged = computed(() => authStore.isLogged);
    const profile = computed(() => profileStore.profile);
    const logout = () => {
      authStore.logout();

    };

    return {
      logout,
      profile,
      isLogged,
    };
  },

};

</script>

<style lang="scss" scoped>
.topbar {
  display: grid;
  align-items: center;
  grid-template-columns: 1fr 1fr 1fr;
  padding: 1rem;
  border-width: 0px 1px 1px 1px;
  border-style: solid;
  border-color: var(--color-border);
  box-shadow: 0px 0px 2px rgba(23, 43, 77, 0.04), 0px 3px 2px rgba(23, 43, 77, 0.08);
  border-radius: 3px;

  &__menu {
    color: var(--text-secondary);
  }

  &__menu:hover {
    cursor: pointer;
    color: var(--text-primary);
  }

  &__logo {
    display: flex;
    &__image {
      max-height: 2.5rem;
    }
    justify-content: center;
  }

  &__container {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    align-items: center;
  }

  &__user {
    all: unset;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;

    &__avatar {
      width: 2rem;
      height: 2rem;
      background-color: var(--color-border);
      border-radius: 1rem;
    }

    &__name {
      color: var(--text-secondary);

      @media (max-width: 768px) {
        display: none;
      }
    }
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