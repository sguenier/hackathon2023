<template>
  <nav class="navbar">
    <div class="navbar__list">
      <router-link
        class="navbar__list__link"
        v-for="{ name, label, icon } in filteredMenuItems"
        :key="name"
        :class="{ 'navbar__list__link--active': activeRouteName === name}"
        :to="{ name }"
      >
        <vue-feather
          v-if="isSmallScreen"
          size="26"
          :type="icon"
        /> 
        <span>  
          {{ label }}
        </span>
      </router-link>
    </div>
    <div
      class="navbar__list"
      v-if="!isSmallScreen"
    >
      <button
        v-if="isLogged"
        class="navbar__list__link"
      >
        <vue-feather
          v-if="isSmallScreen"
          size="26"
          type="user"
        />
        <vue-feather
          v-else
          size="16"
          type="user"
        />
        <span>{{ profile.firstname }} {{ profile.lastname }}</span>
      </button>
      <router-link
        v-if="!isLogged"
        class="navbar__list__link"
        :to="{ name: 'login' }"
      >
        <vue-feather
          v-if="isSmallScreen"
          size="26"
          type="log-in"
        />
        <vue-feather
          v-else
          size="16"
          type="log-in"
        />
        <span>Login</span>
      </router-link>
      <button
        v-if="isLogged"
        class="navbar__list__link"
        @click="logout"
      >
        <vue-feather
          v-if="isSmallScreen"
          size="26"
          type="log-out"
        />
        <vue-feather
          v-else
          size="16"
          type="log-out"
        />
        <span>Logout</span>
      </button>
      <router-link
        v-if="isLogged"
        class="navbar__list__link"
        :to="{ name: 'admin' }"
      >
        <vue-feather
          size="16"
          type="box"
        />
        <span>  
          Backoffice
        </span>
      </router-link>
    </div>
  </nav>
</template>

<script>
import {
  computed,
  onMounted,
  onUnmounted,
  ref,
} from 'vue';

import { useRouter } from 'vue-router';

import menuItems from '@/helpers/menu';
import { useAuthStore } from '@/store/authStore';
import { useProfileStore } from '@/store/profileStore';

export default {
  name: 'navbar',
  setup() {
    const router = useRouter();
    const authStore = useAuthStore();
    const profileStore = useProfileStore();

    const isLogged = computed(() => authStore.isLogged);
    const activeRouteName = computed(() => router.currentRoute.value.name);
    const profile = computed(() => profileStore.profile);

    const filteredMenuItems = computed(() => menuItems.filter((item) => {
      if (item.mustBeLogged) {
        return isLogged.value;
      }
      return true;
    }));

    const logout = () => {
      authStore.logout();
      router.push({ name: 'home' });
    };

    const screenWidth = ref(window.innerWidth);

    const updateScreenWidth = () => {
      screenWidth.value = window.innerWidth;
    };

    onMounted(() => {
      window.addEventListener('resize', updateScreenWidth);
    });

    onUnmounted(() => {
      window.removeEventListener('resize', updateScreenWidth);
    });

    const isSmallScreen = computed(() => screenWidth.value < 768);
    
    return {
      profile,
      logout,
      filteredMenuItems,
      isLogged,
      activeRouteName,
      isSmallScreen,
    };
  },
};
</script>

<style lang="scss" scoped>
.navbar {
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

  @media (max-width: 768px) {
    z-index: 1;
    flex-direction: row;
    position: fixed;
    bottom: 0;
    background-color: var(--text-white);
    height: unset;
    width: 100%;
    padding: 0;
    box-shadow: 0px 0px 2px rgba(23, 43, 77, 0.04), 0px -3px 2px rgba(23, 43, 77, 0.08);
    justify-content: center;

    &__list {
      flex-direction: row;
      flex-grow: 1;

      &__link {
        flex-grow: 1;
        padding-top: 12px;
        flex-direction: column;
        height: unset;
        background-color: unset;
      }

      &__link--active {
        padding-top: 8px;
        padding-left: 24px;
        border-left: none;
        border-top: 4px solid var(--color-blue-action)
      }

      &__link:hover {
        padding-top: 8px;
        padding-left: 24px;
        border-left: none;
        background-color: unset;
        border-top: 4px solid var(--color-blue-action)
      }

    }
  }
}
</style>
