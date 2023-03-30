<template>
  <div class="logged">
    <topbar class="logged__topbar" />
    <sidebar class="logged__sidebar" />
    <transition-group
      name="fade"
      tag="main"
      class="logged__main"
      :key="$route.path"
    >
      <slot />
    </transition-group>
  </div>
</template>

<script>
import Sidebar from '@/components/Navbar.vue';
import Topbar from '@/components/Topbar.vue';

export default {
  name: 'LoggedLayout',
  components: {
    Sidebar,
    Topbar,
  },
};
</script>

<style lang="scss" scoped>
.logged {
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