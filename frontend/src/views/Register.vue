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
    {{ form }}
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

    const registerFrom = ref(null);

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

    const rules = ref({
      firstname: [
        {
          required: true,
          message: 'Veuillez renseigner un prénom',
          trigger: 'blur', 
        },
      ],
      lastname: [
        {
          required: true,
          message: 'Veuillez renseigner un nom',
          trigger: 'blur', 
        },
      ],
      socialsecuritynumber: [
        {
          required: true,
          message: 'Veuillez renseigner un numéro de sécurité sociale',
          trigger: 'blur', 
        },
        {
          required: true,
          pattern: /^[12][0-9]{2}(0[1-9]|1[0-2])(2[AB]|[0-9]{2})[0-9]{3}[0-9]{3}([0-9]{2})$/,
          message: 'Veuillez renseigner un numéro de sécurité sociale valide',
          trigger: 'blur', 
        },
      ],
      job: [ { required: true, message: 'Veuillez renseigner un poste', trigger: 'change' } ],
    });

    const submit = async () => {
      await authStore.register(form.value);
      router.push({ name: 'login' });
    };

    return {
      rules,
      form,
      registerFrom,
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
