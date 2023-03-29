<template>
  <nav class="sidebar">
    <div class="sidebar__list">
      <router-link
        class="sidebar__list__link"
        v-for="{ name, label } in filteredMenuItems"
        :key="name"
        :class="{ 'sidebar__list__link--active': activeRouteName === name}"
        :to="{ name }"
      >
        <span>
          {{ label }}
        </span>
      </router-link>
    </div>
    <div class="sidebar__list">
      <button
        v-if="isLogged"
        class="sidebar__list__link"
      >
        <vue-feather
          size="16"
          type="user"
        />
        <span>Jhon Doe</span>
      </button>
      <router-link
        v-if="!isLogged"
        class="sidebar__list__link"
        :to="{ name: 'login' }"
      >
        <vue-feather
          size="16"
          type="log-in"
        />
        <span>Login</span>
      </router-link>
      <button
        v-if="isLogged"
        class="sidebar__list__link"
        @click="logout"
      >
        <vue-feather
          size="16"
          type="log-out"
        />
        <span>Logout</span>
      </button>
    </div>
  </nav>
</template>

<script>
import { computed } from 'vue';

import { useRouter } from 'vue-router';

import menuItems from '@/helpers/menu';
import { useAuthStore } from '@/store/authStore';

export default {
  name: 'Sidebar',
  setup() {
    const router = useRouter();
    const authStore = useAuthStore();

    const isLogged = computed(() => authStore.isLogged);
    const activeRouteName = computed(() => router.currentRoute.value.name);

    const filteredMenuItems = computed(() => {
      return menuItems.filter((item) => {
        if (item.mustBeLogged) {
          return isLogged.value;
        }
        return true;
      });
    });

    const logout = () => {
      authStore.logout();
      router.push({ name: 'Login' });
    }

    return {
      logout,
      filteredMenuItems,
      isLogged,
      activeRouteName,
    };
  },
};
</script>

<style lang="scss" scoped>
.sidebar {
  box-sizing: border-box;
  padding: 24px 0;
  border-right: 1px solid var(--color-border);
  color: var(--text-secondary);
  font-size: 14px;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;

  &__list {
    all: unset;
    display: flex;
    flex-direction: column;

    &__link {
      all: unset;
      padding: 0 24px;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      height: 42px;
      cursor: pointer;

      span, a {
        all: unset;
      }

      &:hover {
        color: var(--color-blue-action);
        background-color: var(--color-blue-hover-light);
        border-left: 4px solid var(--color-blue-action);
        padding-left: 20px;
      }

      &--active {
        color: var(--color-blue-action);
        background-color: var(--color-blue-hover-light);
        border-left: 4px solid var(--color-blue-action);
        padding-left: 20px;
      }
    }
  }
}
</style>
