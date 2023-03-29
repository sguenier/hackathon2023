<template>
  <div class="jaji-app">
    <div class="jaji-app__topbar">Topbar</div>
    <sidebar class="jaji-app__sidebar" />
    <main class="jaji-app__main">
      <router-view />
    </main>
  </div>
</template>

<script>
import { RouterView } from 'vue-router';

import Sidebar from './components/Sidebar.vue';

export default {
  name: 'App',
  components: {
    RouterView,
    Sidebar,
  },
}
</script>

<style lang="scss" scoped>
.jaji-app {
  display: grid;
  grid-template-areas: "topbar topbar" "sidebar main";
  grid-template-rows: auto 1fr;
  grid-template-columns: 200px 1fr;
  height: 100%;

  @media (max-width: 768px) {
    grid-template-areas: "topbar" "main";
    grid-template-rows: auto auto 1fr;
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

    @media (max-width: 768px) {
      padding: 8px;
    }
  }
}
</style>
