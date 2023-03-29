<template>
  <div class="loading-screen">
    <img
      class="loading-screen__logo"
      :src="logoLight"
    >
    <img
      class="loading-screen__loader"
      :src="loader"
    >
  </div>
</template>

<script>
import loader from '@/assets/loader.png';
import logoLight from '@/assets/logo-light.svg';

export default {
  name: 'LoadingScreen',
  setup() {
    return {
      logoLight,
      loader,
    };
  },
};
</script>

<style lang="scss" scoped>
.loading-screen {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  gap: 64px;
  height: 100%;
  background-color: var(--text-primary-light);

  &__loader {
    height: 50px;
    width: 50px;

    animation: spin 1s linear infinite;
  }
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>