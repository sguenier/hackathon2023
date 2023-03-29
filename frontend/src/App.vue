<template>
  <div class="jaji-app">
    <div class="jaji-app__topbar">Topbar</div>
    <div class="jaji__sidebar">sidebar</div>
    <main class="jaji-app__main">
      <router-view />
    </main>
  </div>
</template>

<script>
import { RouterView } from 'vue-router';

export default {
  name: 'App',
  components: {
    RouterView,
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

  &__topbar {
    grid-area: topbar;
  }

  &__sidebar {
    grid-area: sidebar;
  }

  &__main {
    grid-area: main;
  }
}
</style>
