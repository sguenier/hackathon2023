<template>
  <main>
    <h3>Connexion</h3>
    <h1>Espace adhérent</h1>
    <el-form
      ref="loginForm"
      class="login-form"
      :rules="rules"
      :model="form"
    >
      <el-form-item
        prop="email"
      >
        <el-input
          class="login-form__input"
          v-model="form.email"
          placeholder="Email"
          size="large"
        />
      </el-form-item>
      <el-form-item
        prop="pwd"
      >
        <el-input
          class="login-form__input"
          v-model="form.pwd"
          type="password"
          autocomplete="off"
          placeholder="Mot de passe"
          size="large"
        />
      </el-form-item>
      <el-form-item>
        <el-button
          type="primary"
          @click="onSubmit"
          size="large"
        >
          Connexion
        </el-button>
      </el-form-item>
      <el-button
        text
        @click="$router.push({ name: 'register' })"
        size="large"
      >
        Pas encore inscrit ?
      </el-button>
    </el-form>
  </main>
</template>

<script>
import { ref } from 'vue';

import { useRouter } from 'vue-router';

import { useAuthStore } from '@/store/authStore';
import { useProfileStore } from '@/store/profileStore';

export default {
  name: 'Login',
  setup() {
    const router = useRouter();
    const authStore = useAuthStore();
    const profileStore = useProfileStore();
    const form = ref({});
    const loginForm = ref(null);

    const rules = ref({
      email: [
        {
          required: true,
          message: 'Veuillez renseigner un email',
          trigger: 'blur', 
        },
        {
          type: 'email',
          message: 'Veuillez renseigner un email valide',
          trigger: [ 'blur', 'change' ], 
        },
      ],
      pwd: [
        {
          required: true,
          message: 'Veuillez renseigner un mot de passe',
          trigger: 'blur', 
        },
        {
          min: 6,
          max: 20,
          message: 'Le mot de passe doit faire entre 6 et 20 caractere',
          trigger: 'blur', 
        },
      ],
    });

    const onSubmit = () => {
      loginForm.value.validate(async (valid) => {
        if (valid) {
          await authStore.login(form.value);
          await profileStore.getProfile();
          router.push({ name: 'home' });
        }
      });
    };

    return {
      rules,
      form,
      loginForm,
      onSubmit,
    };
  },
};
</script>

<style lang="scss" scoped>
.login-form {
  display: flex;
  flex-direction: column;
  align-items: center;

  &__input {
    width: 300px;
  }
}
</style>
