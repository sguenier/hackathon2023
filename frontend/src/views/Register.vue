<template>
  <main>
    <h1>Bienvue sur votre suivi santé</h1>
    <h3>Apprenons à mieux vous connaitre</h3>
    <router-view
      v-slot="{ Component }"
    >
      <transition-group
        name="fade"
        tag="div"
      >
        <component
          :key="$route.path"
          :is="Component"
          v-model="form"
          @next="nextStep"
          @previous="previousStep"
          @submit="submit"
        />
      </transition-group>
    </router-view>
    <div class="login-link">
      <router-link :to="{ name: 'login' }">Déjà inscrit ?</router-link>
    </div>
  </main>
</template>

<script>
import {
  computed,
  ref,
} from 'vue';

import { useRouter } from 'vue-router';

import { useAuthStore } from '@/store/authStore';

export default {
  name: 'Login',
  setup() {
    const router = useRouter();
    const authStore = useAuthStore();
    const form = ref({});

    const actualRouteName = computed(() => router.currentRoute.value.name);

    const registerRouteNames = [
      'register-base',
      'register-personal',
      'register-care',
      'register-tags',
    ];

    const registerProfile = computed(() => authStore.registerProfile);

    const nextStep = async () => {
      const currentRouteIndex = registerRouteNames.indexOf(actualRouteName.value);
      await router.push({ name: registerRouteNames[currentRouteIndex + 1] });
    };

    const previousStep = () => {
      const currentRouteIndex = registerRouteNames.indexOf(actualRouteName.value);
      router.push({ name: registerRouteNames[currentRouteIndex - 1] });
    };

    const submit = async () => {
      await authStore.register(form.value);
      router.push({ name: 'login' });
    };

    return {
      form,
      submit,
      nextStep,
      previousStep,
      registerProfile,
    };
  },
};
</script>

<style lang="scss" scoped>
.login-link {
  text-align: right;
  margin-top: 1rem;
  padding: 0 48px;
}
</style>
