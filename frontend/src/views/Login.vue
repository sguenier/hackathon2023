<template>
  <main>
    <h2>Login</h2>
    <el-form
      ref="loginForm"
      :rules="rules"
      :model="form"
      label-width="120px"
    >
      <el-form-item
        label="Email"
        prop="email"
      >
        <el-input v-model="form.email" />
      </el-form-item>
      <el-form-item
        label="Password"
        prop="pwd"
      >
        <el-input
          v-model="form.pwd"
          type="password"
          autocomplete="off"
        />
      </el-form-item>
      <el-form-item>
        <el-button
          type="primary"
          @click="onSubmit"
        >Login</el-button>
      </el-form-item>
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
</style>
