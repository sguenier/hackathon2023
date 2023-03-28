<template>
  <main>
    <h2>Register</h2>
    <el-form ref="registerFrom" :rules="rules" :model="form" label-width="170px">
      <el-form-item label="Email" prop="email">
        <el-input v-model="form.email" />
      </el-form-item>
      <el-form-item label="Mot de passe" prop="password">
        <el-input v-model="form.password" type="password" autocomplete="off" />
      </el-form-item>
      <el-form-item label="Confirmation du MdP" prop="passwordConfirmation">
        <el-input v-model="form.passwordConfirmation" type="password" autocomplete="off" />
      </el-form-item>
      <el-form-item label="Prénom" prop="firstname">
        <el-input v-model="form.firstname" />
      </el-form-item>
      <el-form-item label="Nom de Famille" prop="lastname">
        <el-input v-model="form.lastname" />
      </el-form-item>
      <el-form-item label="Numéro de securité social" prop="socialSecurityNumber">
        <el-input v-model="form.socialSecurityNumber" />
      </el-form-item>
      <el-form-item label="Poste occupé" prop="socialSecurityNumber">
        <el-select v-model="value" class="m-2" placeholder="Select" size="large">
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">Register</el-button>
      </el-form-item>
    </el-form>
  </main>
</template>

<script>
import { ref } from 'vue';

import { useRouter } from 'vue-router';

import { useAuthStore } from '@/store/authStore';

export default {
  name: 'Login',
  setup() {
    const router = useRouter()
    const authStore = useAuthStore();
    const form = ref({});
    const registerFrom = ref(null);

    const confirmPasswordValidator = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('Veuillez confirmer le mot de passe'));
      } else if (value !== form.value.password) {
        callback(new Error('Les mots de passe ne correspondent pas!'));
      } else {
        callback();
      }
    };

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
      password: [
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
      passwordConfirmation: [
        {
          required: true,
          message: 'Veuillez confirmer le mot de passe',
          trigger: 'blur', 
        },
        {
          validator: confirmPasswordValidator,
          trigger: 'blur', 
        },
      ],
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
      socialSecurityNumber: [
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
    });

    const onSubmit = () => {
      registerFrom.value.validate(async (valid) => {
        if (valid) {
          await authStore.register(form.value);
          router.push({ name: 'login' });
        }
      });
    }

    return {
      rules,
      form,
      registerFrom,
      onSubmit,
    }
  },
}
</script>

<style lang="scss" scoped>
</style>
