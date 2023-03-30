<template>
  <router-view
    v-slot="{ Component }"
  >
    <transition-group
      name="fade"
      tag="div"
      class="jaji-app"
    >
      <component
        :is="LayoutComponent"
        v-if="!isAppLoading"
      >
        <component :is="Component" />
      </component>
      <loading-screen v-else />
    </transition-group>
  </router-view>
</template>

<script>
import { computed } from 'vue';

import Cookies from 'js-cookie';
import { RouterView } from 'vue-router';

import LoggedLayout from '@/Layouts/Logged.vue';
import NotLoggedLayout from '@/Layouts/NotLogged.vue';
import { useAuthStore } from '@/store/authStore';
import { useProfileStore } from '@/store/profileStore';
import LoadingScreen from '@/views/LoadingScreen.vue';

export default {
  name: 'App',
  components: {
    RouterView,
    LoadingScreen,
  },
  setup() {
    const authStore = useAuthStore();
    const profileStore = useProfileStore();
    const isAppLoading = computed(() => {
      if (!Cookies.get(import.meta.env.VITE_COOKIE_TOKEN_NAME)) {
        return false;
      } else if (authStore.isAuthLoading || profileStore.isProfileLoading) {
        return true;
      }
      return false;
      
    });

    const LayoutComponent = computed(() => {
      if (authStore.isLogged) {
        return LoggedLayout;
      }
      return NotLoggedLayout;
      
    });
    return {
      LayoutComponent,
      isAppLoading,
    };
  },
};
</script>

<style lang="scss" scoped>
.jaji-app {
  height: 100%;
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
