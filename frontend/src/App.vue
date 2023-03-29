<template>
  <router-view v-slot="{ Component }">
    <transition-group name="fade">
      <div
        class="jaji-app"
        v-if="!isAppLoading"
      >
        <topbar class="jaji-app__topbar" />
        <sidebar class="jaji-app__sidebar" />
        <main class="jaji-app__main">
          <component :is="Component" />
        </main>
      </div>
      <loading-screen v-else />
    </transition-group>
  </router-view>
</template>

<script>
import { computed } from 'vue';

import Cookies from 'js-cookie';
import { RouterView } from 'vue-router';

import Topbar from '@/components/Topbar.vue';

import Sidebar from './components/Sidebar.vue';
import { useAuthStore } from './store/authStore';
import { useProfileStore } from './store/profileStore';
import LoadingScreen from './views/LoadingScreen.vue';

export default {
  name: 'App',
  components: {
    RouterView,
    Sidebar,
    Topbar,
    LoadingScreen,
  },
  setup() {
    const authStore = useAuthStore();
    const profileStore = useProfileStore();
    const isAppLoading = computed(() => {
      if (!Cookies.get(import.meta.env.VITE_COOKIE_TOKEN_NAME)) {
        return false;
      }
      else if (authStore.isAuthLoading || profileStore.isProfileLoading) {
        return true;
      }
      else {
        return false;
      }
    });
    return {
      isAppLoading,
    };
  },
};
</script>

<style lang="scss" scoped>
.jaji-app {
  display: grid;
  grid-template-areas: "topbar topbar" "sidebar main";
  grid-template-rows: auto 1fr;
  grid-template-columns: 200px 1fr;
  min-height: 100%;

  @media (max-width: 768px) {
    grid-template-areas: "topbar" "main";
    grid-template-rows: auto 1fr;
    grid-template-columns: 1fr;
  }

  &__topbar {
    grid-area: topbar;
  }

  &__sidebar {
    grid-area: sidebar;
  }

  &__main {
    grid-area: main;
    padding: 24px;
    overflow-y: auto;

    @media (max-width: 768px) {
      padding: 24px 16px;
    }
  }
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}

.fade-enter-to,
.fade-leave {
  opacity: 1;
}
</style>
